<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Pago;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\LogsActivity;

class PaymentController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Crear una sesión de Stripe Checkout para una cita
     */
    public function createCheckoutSession(Request $request)
    {
        try {
            $validated = $request->validate([
                'cita_id' => 'required|exists:citas,id',
                'tipo_pago' => 'required|in:anticipo,total',
            ]);

            $cita = Cita::with(['user', 'servicio'])->findOrFail($validated['cita_id']);

            // Verificar autorización
            if (auth()->user()->id !== $cita->user_id && !auth()->user()->hasRole(['super-admin', 'admin', 'recepcionista'])) {
                abort(403, 'No autorizado');
            }

            // Calcular el monto según el tipo de pago
            $monto = $validated['tipo_pago'] === 'anticipo'
                ? $cita->anticipo
                : $cita->precio_total;

            if ($monto <= 0) {
                return back()->with('error', 'El monto a pagar debe ser mayor a 0');
            }

            // Convertir a centavos (Stripe trabaja con centavos)
            $montoEnCentavos = (int) ($monto * 100);

            // Crear la sesión de Stripe Checkout
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'mxn',
                        'product_data' => [
                            'name' => $cita->servicio->nombre ?? 'Servicio de belleza',
                            'description' => $validated['tipo_pago'] === 'anticipo'
                                ? 'Anticipo para cita'
                                : 'Pago completo de cita',
                        ],
                        'unit_amount' => $montoEnCentavos,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['cita_id' => $cita->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['cita_id' => $cita->id]),
                'metadata' => [
                    'cita_id' => $cita->id,
                    'tipo_pago' => $validated['tipo_pago'],
                    'user_id' => auth()->user()->id,
                ],
            ]);

            // Registrar el pago como pendiente en la base de datos
            Pago::create([
                'cita_id' => $cita->id,
                'stripe_checkout_session_id' => $checkoutSession->id,
                'stripe_payment_intent_id' => null, // Se actualizará con el webhook
                'monto' => $monto,
                'moneda' => 'mxn',
                'estado' => 'pending',
                'metodo_pago' => 'stripe',
                'tipo_pago' => $validated['tipo_pago'],
                'descripcion' => "Pago de {$validated['tipo_pago']} para cita #{$cita->id}",
                'metadata' => [
                    'servicio' => $cita->servicio->nombre ?? 'N/A',
                    'fecha_cita' => $cita->fecha,
                    'hora_cita' => $cita->hora,
                ],
            ]);

            // Registrar en bitácora
            $this->logActivity(
                'Iniciar Pago',
                "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) inició un pago de {$validated['tipo_pago']} de \${$monto} para la cita #{$cita->id}"
            );

            // Redirigir a Stripe Checkout
            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            Log::error('Error al crear sesión de Stripe Checkout: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Manejar el éxito del pago
     */
    public function success(Request $request, $cita_id)
    {
        try {
            $sessionId = $request->query('session_id');

            if (!$sessionId) {
                return redirect()->route('citas.index')
                    ->with('error', 'Sesión de pago no encontrada');
            }

            $cita = Cita::with(['user', 'servicio'])->findOrFail($cita_id);

            // Obtener el pago asociado
            $pago = Pago::where('cita_id', $cita_id)
                ->where('stripe_checkout_session_id', $sessionId)
                ->first();

            if (!$pago) {
                return redirect()->route('citas.index')
                    ->with('warning', 'Pago no encontrado en el sistema. Será actualizado automáticamente.');
            }

            // Registrar en bitácora
            $this->logActivity(
                'Pago Exitoso',
                "{$this->getCurrentUserName()} completó un pago de \${$pago->monto} para la cita #{$cita->id}"
            );

            return view('pagos.success', compact('cita', 'pago'));

        } catch (\Exception $e) {
            Log::error('Error en success de pago: ' . $e->getMessage());
            return redirect()->route('citas.index')
                ->with('error', 'Error al procesar el pago exitoso');
        }
    }

    /**
     * Manejar la cancelación del pago
     */
    public function cancel($cita_id)
    {
        try {
            $cita = Cita::with(['user', 'servicio'])->findOrFail($cita_id);

            // Marcar los pagos pendientes de esta cita como fallidos
            Pago::where('cita_id', $cita_id)
                ->where('estado', 'pending')
                ->update(['estado' => 'failed']);

            // Registrar en bitácora
            $this->logActivity(
                'Pago Cancelado',
                "{$this->getCurrentUserName()} canceló el pago para la cita #{$cita->id}"
            );

            return view('pagos.cancel', compact('cita'));

        } catch (\Exception $e) {
            Log::error('Error en cancel de pago: ' . $e->getMessage());
            return redirect()->route('citas.index')
                ->with('warning', 'Pago cancelado');
        }
    }

    /**
     * Webhook de Stripe para confirmar pagos
     */
    public function webhook(Request $request)
    {
        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error('Webhook Stripe: Payload inválido');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Webhook Stripe: Firma inválida');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Manejar el evento
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            case 'charge.refunded':
                $this->handleChargeRefunded($event->data->object);
                break;

            default:
                Log::info('Webhook Stripe: Evento no manejado - ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Manejar sesión de checkout completada
     */
    private function handleCheckoutSessionCompleted($session)
    {
        DB::beginTransaction();
        try {
            $pago = Pago::where('stripe_checkout_session_id', $session->id)->first();

            if (!$pago) {
                Log::warning("Pago no encontrado para session: {$session->id}");
                return;
            }

            // Actualizar el pago con el payment_intent_id
            $pago->update([
                'stripe_payment_intent_id' => $session->payment_intent,
                'estado' => 'succeeded',
            ]);

            // Actualizar el estado de la cita según el tipo de pago
            $cita = $pago->cita;

            if ($pago->tipo_pago === 'total') {
                // Si pagó el total, marcar como confirmada
                $cita->update(['estado' => 'confirmada']);

                // Descontar productos del stock
                $this->descontarStockProductos($cita->servicio_id);
            } elseif ($pago->tipo_pago === 'anticipo') {
                // Si solo pagó anticipo, mantener como pendiente pero registrado
                if ($cita->estado === 'pendiente') {
                    // Puedes agregar lógica adicional aquí
                }
            }

            Log::info("Pago completado exitosamente: {$pago->id} - Cita: {$cita->id}");

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en handleCheckoutSessionCompleted: " . $e->getMessage());
        }
    }

    /**
     * Manejar payment intent exitoso
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        try {
            $pago = Pago::where('stripe_payment_intent_id', $paymentIntent->id)->first();

            if ($pago && $pago->estado !== 'succeeded') {
                $pago->marcarComoExitoso();
                Log::info("PaymentIntent succeeded: {$paymentIntent->id}");
            }
        } catch (\Exception $e) {
            Log::error("Error en handlePaymentIntentSucceeded: " . $e->getMessage());
        }
    }

    /**
     * Manejar payment intent fallido
     */
    private function handlePaymentIntentFailed($paymentIntent)
    {
        try {
            $pago = Pago::where('stripe_payment_intent_id', $paymentIntent->id)->first();

            if ($pago) {
                $pago->marcarComoFallido();
                Log::warning("PaymentIntent failed: {$paymentIntent->id}");
            }
        } catch (\Exception $e) {
            Log::error("Error en handlePaymentIntentFailed: " . $e->getMessage());
        }
    }

    /**
     * Manejar cargo reembolsado
     */
    private function handleChargeRefunded($charge)
    {
        try {
            $pago = Pago::where('stripe_payment_intent_id', $charge->payment_intent)->first();

            if ($pago) {
                $monto_reembolsado = $charge->amount_refunded / 100; // Convertir de centavos
                $pago->registrarReembolso($charge->refunds->data[0]->id ?? null, $monto_reembolsado);
                Log::info("Charge refunded: {$charge->id} - Monto: {$monto_reembolsado}");
            }
        } catch (\Exception $e) {
            Log::error("Error en handleChargeRefunded: " . $e->getMessage());
        }
    }

    /**
     * Descontar stock de productos asociados a un servicio
     */
    private function descontarStockProductos($servicioId)
    {
        try {
            $servicio = \App\Models\Servicio::with('productos')->find($servicioId);

            if (!$servicio) {
                return;
            }

            foreach ($servicio->productos as $producto) {
                $cantidad = $producto->pivot->cantidad ?? 1;

                if ($producto->stockActual >= $cantidad) {
                    $producto->decrement('stockActual', $cantidad);
                    Log::info("Stock descontado - Producto: {$producto->nombre}, Cantidad: {$cantidad}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Error al descontar stock: " . $e->getMessage());
        }
    }

    /**
     * Ver historial de pagos de una cita
     */
    public function historial($cita_id)
    {
        $cita = Cita::with(['pagos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'user', 'servicio'])->findOrFail($cita_id);

        $this->authorize('view', $cita);

        return view('pagos.historial', compact('cita'));
    }
}
