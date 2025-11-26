<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\User;
use App\Models\Client;
use App\Models\Estilista;
use App\Models\Servicio;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\LogsActivity;

class CitaController extends Controller
{
    use LogsActivity;
    /**
     * Obtener lista de clientes (usuarios con registro en tabla clients)
     */
    private function getClientes()
    {
        return User::select('users.id', 'users.name')
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->orderBy('users.name')
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Cita::class);

        $user = Auth::user();

        // Si es cliente, solo muestra sus propias citas
        if ($user->hasRole('cliente') && !$user->hasRole('super-admin')) {
            $citas = Cita::with(['user', 'estilista.user', 'servicio'])
                ->where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->paginate(15);
        } else {
            // Admin y recepcionista ven todas las citas
            $citas = Cita::with(['user', 'estilista.user', 'servicio'])
                ->orderBy('fecha', 'desc')
                ->paginate(15);
        }

        // Obtener solo los usuarios que son clientes (tienen registro en tabla clients)
        $clientes = $this->getClientes();

        // Obtener estilistas y servicios
        $estilistas = Estilista::with('user')->get();
        $servicios = Servicio::where('estado', 'activo')->get();

        return view('citas.index', compact('citas', 'clientes', 'estilistas', 'servicios'));
    }

    /**
     * Obtener servicios de una estilista específica (AJAX)
     */
    public function getServiciosPorEstilista($estilistaId)
    {
        $estilista = Estilista::with('servicios')->findOrFail($estilistaId);

        // Si la estilista no tiene servicios asignados, devolver todos los servicios activos
        if ($estilista->servicios->isEmpty()) {
            $servicios = Servicio::where('estado', 'activo')->get();
        } else {
            $servicios = $estilista->servicios()->where('estado', 'activo')->get();
        }

        return response()->json([
            'servicios' => $servicios,
            'estilista' => [
                'id' => $estilista->id,
                'nombre' => $estilista->user->name,
                'comision' => $estilista->porcentaje_comision
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('citas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cita::class);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estilista_id' => 'required|exists:estilistas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado' => 'nullable|string',
            'anticipo' => 'nullable|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Si es cliente, forzar que el user_id sea el del usuario autenticado
            // y establecer el estado como "pendiente"
            if (Auth::user()->hasRole('cliente') && !Auth::user()->hasRole('super-admin')) {
                $validated['user_id'] = Auth::id();
                $validated['estado'] = 'pendiente';
            }

            // Si no se especificó estado, establecer como "pendiente"
            if (!isset($validated['estado'])) {
                $validated['estado'] = 'pendiente';
            }

            // Obtener el servicio para calcular el precio
            $servicio = Servicio::findOrFail($validated['servicio_id']);
            $estilista = Estilista::findOrFail($validated['estilista_id']);

            // PASO 1: Obtener la duración del servicio y calcular hora de fin
            $duracionMinutos = (int) $servicio->duracion; // Duración en minutos
            $horaInicio = $validated['hora']; // Formato: "HH:MM"

            // Calcular la hora de fin de la nueva cita
            $horaFinNueva = date('H:i', strtotime($horaInicio . ' +' . $duracionMinutos . ' minutes'));

            // PASO 2: Verificar conflictos de horario con la misma estilista
            // Buscar todas las citas de la misma estilista en la misma fecha
            $citasExistentes = Cita::with('servicio')
                ->where('estilista_id', $validated['estilista_id'])
                ->where('fecha', $validated['fecha'])
                ->whereIn('estado', ['pendiente', 'confirmada']) // Solo verificar citas pendientes o confirmadas
                ->get();

            $hayConflicto = false;
            $citaConflictiva = null;

            // Log para depuración
            Log::info("Verificando conflictos para nueva cita:", [
                'estilista_id' => $validated['estilista_id'],
                'servicio_id' => $validated['servicio_id'],
                'fecha' => $validated['fecha'],
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFinNueva,
                'citas_existentes' => $citasExistentes->count()
            ]);

            foreach ($citasExistentes as $citaExistente) {
                $horaInicioExistente = $citaExistente->hora;
                $duracionExistente = (int) $citaExistente->servicio->duracion;
                $horaFinExistente = date('H:i', strtotime($horaInicioExistente . ' +' . $duracionExistente . ' minutes'));

                // 1. Convertir a timestamps base
                $inicioNuevoTs = strtotime("2000-01-01 " . $horaInicio);
                $finNuevoTs = strtotime("2000-01-01 " . $horaFinNueva);

                $inicioExistenteTs = strtotime("2000-01-01 " . $horaInicioExistente);
                $finExistenteTs = strtotime("2000-01-01 " . $horaFinExistente);

                // 2. CORRECCIÓN CRÍTICA: Ajustar cruce de medianoche
                // Si la hora fin es menor que la hora inicio, significa que termina al día siguiente
                if ($finNuevoTs < $inicioNuevoTs) {
                    $finNuevoTs += 86400; // Sumar 24 horas (1 día en segundos)
                }

                if ($finExistenteTs <= $inicioExistenteTs) {
                    $finExistenteTs += 86400; // Sumar 24 horas
                }

                // Logs corregidos para verificar que ahora los números tienen sentido
                Log::info("Comparando (CORREGIDO):", [
                    'cita_id' => $citaExistente->id,
                    'inicio_existente' => $inicioExistenteTs,
                    'fin_existente_ajustado' => $finExistenteTs, // Debería ser mayor que inicio
                    'inicio_nuevo' => $inicioNuevoTs,
                    'fin_nuevo_ajustado' => $finNuevoTs
                ]);

                // 3. Verificar solapamiento con la lógica estándar
                if (($inicioNuevoTs < $finExistenteTs) && ($finNuevoTs > $inicioExistenteTs)) {
                    $hayConflicto = true;
                    $citaConflictiva = $citaExistente;
                    Log::warning("¡CONFLICTO DETECTADO!");
                    break;
                }
            }            // PASO 3: Bloquear si hay conflictos
            if ($hayConflicto) {
                DB::rollBack();

                $mensajeError = '🚫 OCUPADO: La estilista ya tiene una cita';
                if ($citaConflictiva) {
                    $horaInicioConflicto = $citaConflictiva->hora;
                    $duracionConflicto = (int) $citaConflictiva->servicio->duracion;
                    $horaFinConflicto = date('H:i', strtotime($horaInicioConflicto . ' +' . $duracionConflicto . ' minutes'));
                    $servicioConflicto = $citaConflictiva->servicio->nombre;
                    $estadoConflicto = ucfirst($citaConflictiva->estado);
                    $mensajeError .= " {$estadoConflicto} en este horario ({$horaInicioConflicto} a {$horaFinConflicto}) con el servicio: {$servicioConflicto}";
                }
                $mensajeError .= '. Por favor, selecciona otro horario.';

                return redirect()
                    ->route('citas.index')
                    ->with('modal_error', $mensajeError)
                    ->withInput();
            }

            // Calcular precio total y comisión
            $validated['precio_total'] = $servicio->precio_servicio;
            $validated['comision_estilista'] = $estilista->calcularComision($servicio->precio_servicio);

            // Crear la cita
            $cita = Cita::create($validated);

            // Actualizar total de comisiones del estilista usando increment
            $estilista->increment('total_comisiones', $validated['comision_estilista']);

            // Si el estado es "confirmada", descontar productos del stock
            if ($validated['estado'] === 'confirmada') {
                $this->descontarStockProductos($servicio->id);
            }

            DB::commit();

            // Registrar en bitácora
            $this->logActivity(
                'Crear Cita',
                "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) creó una cita para {$cita->user->name} con {$estilista->user->name} - Servicio: {$servicio->nombre} - Fecha: {$cita->fecha} {$cita->hora} - Estado: {$cita->estado}"
            );

            return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear la cita: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::with(['user', 'estilista.user', 'servicio'])->findOrFail($id);
        $this->authorize('view', $cita);

        // Registrar en bitácora
        $this->logActivity(
            'Ver Cita',
            "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) visualizó la cita #{$cita->id} de {$cita->user->name} - {$cita->servicio->nombre}"
        );

        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);
        $this->authorize('update', $cita);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estilista_id' => 'required|exists:estilistas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado' => 'required|string',
            'anticipo' => 'nullable|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Si cambiaron el servicio o estilista, recalcular comisiones
            $servicioAnterior = $cita->servicio;
            $estilistaAnterior = $cita->estilista;
            $estadoAnterior = $cita->estado; // Guardar estado anterior

            $servicio = Servicio::findOrFail($validated['servicio_id']);
            $estilista = Estilista::findOrFail($validated['estilista_id']);

            // PASO 1: Obtener la duración del servicio y calcular hora de fin
            $duracionMinutos = (int) $servicio->duracion; // Duración en minutos
            $horaInicio = $validated['hora']; // Formato: "HH:MM"

            // Calcular la hora de fin de la cita editada
            $horaFinNueva = date('H:i', strtotime($horaInicio . ' +' . $duracionMinutos . ' minutes'));

            // PASO 2: Verificar conflictos de horario con la misma estilista (excluyendo la cita actual)
            $citasExistentes = Cita::with('servicio')
                ->where('estilista_id', $validated['estilista_id'])
                ->where('fecha', $validated['fecha'])
                ->where('id', '!=', $id) // Excluir la cita que se está editando
                ->whereIn('estado', ['pendiente', 'confirmada']) // Solo verificar citas pendientes o confirmadas
                ->get();

            $hayConflicto = false;
            $citaConflictiva = null;

            foreach ($citasExistentes as $citaExistente) {
                $horaInicioExistente = $citaExistente->hora;
                $duracionExistente = (int) $citaExistente->servicio->duracion;
                $horaFinExistente = date('H:i', strtotime($horaInicioExistente . ' +' . $duracionExistente . ' minutes'));

                // Convertir a timestamps para comparación precisa
                $inicioNuevoTs = strtotime("2000-01-01 " . $horaInicio);
                $finNuevoTs = strtotime("2000-01-01 " . $horaFinNueva);
                $inicioExistenteTs = strtotime("2000-01-01 " . $horaInicioExistente);
                $finExistenteTs = strtotime("2000-01-01 " . $horaFinExistente);

                // Verificar si hay solapamiento
                if (($inicioNuevoTs < $finExistenteTs) && ($finNuevoTs > $inicioExistenteTs)) {
                    $hayConflicto = true;
                    $citaConflictiva = $citaExistente;
                    break;
                }
            }

            // PASO 3: Bloquear si hay conflictos
            if ($hayConflicto) {
                DB::rollBack();

                $mensajeError = '🚫 OCUPADO: La estilista ya tiene una cita';
                if ($citaConflictiva) {
                    $horaInicioConflicto = $citaConflictiva->hora;
                    $duracionConflicto = (int) $citaConflictiva->servicio->duracion;
                    $horaFinConflicto = date('H:i', strtotime($horaInicioConflicto . ' +' . $duracionConflicto . ' minutes'));
                    $servicioConflicto = $citaConflictiva->servicio->nombre;
                    $estadoConflicto = ucfirst($citaConflictiva->estado);
                    $mensajeError .= " {$estadoConflicto} en este horario ({$horaInicioConflicto} a {$horaFinConflicto}) con el servicio: {$servicioConflicto}";
                }
                $mensajeError .= '. Por favor, selecciona otro horario.';

                return redirect()
                    ->route('citas.index')
                    ->with('modal_error', $mensajeError)
                    ->withInput();
            }

            // Restar comisión anterior del estilista anterior
            if ($estilistaAnterior) {
                $estilistaAnterior->decrement('total_comisiones', (float) $cita->comision_estilista);
            }

            // Calcular nuevo precio total y comisión
            $validated['precio_total'] = $servicio->precio_servicio;
            $validated['comision_estilista'] = $estilista->calcularComision($servicio->precio_servicio);

            // Actualizar la cita
            $cita->update($validated);

            // Sumar nueva comisión al estilista
            $estilista->increment('total_comisiones', $validated['comision_estilista']);

            // Si el estado cambió a "confirmada", descontar productos del stock
            if ($validated['estado'] === 'confirmada' && $estadoAnterior !== 'confirmada') {
                $this->descontarStockProductos($servicio->id);
            }

            DB::commit();

            // Registrar en bitácora
            $cambios = [];
            if ($cita->estilista_id != $validated['estilista_id']) $cambios[] = "Estilista";
            if ($cita->servicio_id != $validated['servicio_id']) $cambios[] = "Servicio";
            if ($cita->fecha != $validated['fecha']) $cambios[] = "Fecha";
            if ($cita->hora != $validated['hora']) $cambios[] = "Hora";
            if ($cita->estado != $validated['estado']) $cambios[] = "Estado ({$cita->estado} → {$validated['estado']})";
            $cambiosTexto = !empty($cambios) ? 'Cambios: ' . implode(', ', $cambios) : 'Sin cambios significativos';

            $this->logActivity(
                'Editar Cita',
                "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) editó la cita #{$cita->id} de {$cita->user->name}. {$cambiosTexto}"
            );

            return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $this->authorize('delete', $cita);

        DB::beginTransaction();
        try {
            // Restar la comisión del estilista antes de eliminar
            if ($cita->estilista && $cita->comision_estilista) {
                $cita->estilista->decrement('total_comisiones', (float) $cita->comision_estilista);
            }

            // Guardar información antes de eliminar
            $citaInfo = [
                'id' => $cita->id,
                'cliente' => $cita->user->name,
                'servicio' => $cita->servicio->nombre,
                'fecha' => $cita->fecha,
                'hora' => $cita->hora,
                'estado' => $cita->estado
            ];

            $cita->delete();

            DB::commit();

            // Registrar en bitácora
            $this->logActivity(
                'Eliminar Cita',
                "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) eliminó la cita #{$citaInfo['id']} de {$citaInfo['cliente']} - Servicio: {$citaInfo['servicio']} - Fecha: {$citaInfo['fecha']} {$citaInfo['hora']} - Estado: {$citaInfo['estado']}"
            );

            return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Descontar stock de productos asociados a un servicio
     */
    private function descontarStockProductos($servicioId)
    {
        try {
            // Obtener el servicio con sus productos relacionados
            $servicio = Servicio::with('productos')->find($servicioId);

            if (!$servicio) {
                Log::warning("Servicio no encontrado para descontar stock: ID {$servicioId}");
                return;
            }

            // Iterar sobre los productos del servicio
            foreach ($servicio->productos as $producto) {
                $cantidad = $producto->pivot->cantidad ?? 1;

                // Verificar que hay suficiente stock
                if ($producto->stockActual >= $cantidad) {
                    // Descontar del stock
                    $producto->decrement('stockActual', $cantidad);

                    Log::info("Stock descontado:", [
                        'servicio_id' => $servicioId,
                        'servicio_nombre' => $servicio->nombre,
                        'producto_id' => $producto->id,
                        'producto_nombre' => $producto->nombre,
                        'cantidad_descontada' => $cantidad,
                        'stock_anterior' => $producto->stockActual + $cantidad,
                        'stock_actual' => $producto->stockActual
                    ]);
                } else {
                    Log::warning("Stock insuficiente para descontar:", [
                        'producto_id' => $producto->id,
                        'producto_nombre' => $producto->nombre,
                        'stock_actual' => $producto->stockActual,
                        'cantidad_requerida' => $cantidad
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error al descontar stock de productos: " . $e->getMessage());
        }
    }
}
