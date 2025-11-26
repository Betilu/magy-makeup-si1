<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')
                ->constrained('citas')
                ->onDelete('cascade');

            // Información de Stripe
            $table->string('stripe_payment_intent_id')->unique()->nullable();
            $table->string('stripe_checkout_session_id')->unique()->nullable();

            // Información del pago
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('mxn');
            $table->string('estado'); // pending, succeeded, failed, refunded
            $table->string('metodo_pago')->default('stripe'); // stripe, efectivo, transferencia
            $table->string('tipo_pago'); // anticipo, total, saldo

            // Metadata adicional
            $table->text('descripcion')->nullable();
            $table->json('metadata')->nullable();

            // Información de reembolso
            $table->string('stripe_refund_id')->nullable();
            $table->decimal('monto_reembolsado', 10, 2)->default(0);
            $table->timestamp('fecha_reembolso')->nullable();

            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index('estado');
            $table->index('tipo_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
