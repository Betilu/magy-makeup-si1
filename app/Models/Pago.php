<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'cita_id',
        'stripe_payment_intent_id',
        'stripe_checkout_session_id',
        'monto',
        'moneda',
        'estado',
        'metodo_pago',
        'tipo_pago',
        'descripcion',
        'metadata',
        'stripe_refund_id',
        'monto_reembolsado',
        'fecha_reembolso',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'monto_reembolsado' => 'decimal:2',
        'metadata' => 'array',
        'fecha_reembolso' => 'datetime',
    ];

    /**
     * Relación: un pago pertenece a una cita
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Verificar si el pago fue exitoso
     */
    public function esExitoso(): bool
    {
        return $this->estado === 'succeeded';
    }

    /**
     * Verificar si el pago está pendiente
     */
    public function estaPendiente(): bool
    {
        return $this->estado === 'pending';
    }

    /**
     * Verificar si el pago falló
     */
    public function haFallado(): bool
    {
        return $this->estado === 'failed';
    }

    /**
     * Verificar si el pago fue reembolsado
     */
    public function fueReembolsado(): bool
    {
        return $this->estado === 'refunded' || $this->monto_reembolsado > 0;
    }

    /**
     * Marcar el pago como exitoso
     */
    public function marcarComoExitoso(): void
    {
        $this->update(['estado' => 'succeeded']);
    }

    /**
     * Marcar el pago como fallido
     */
    public function marcarComoFallido(): void
    {
        $this->update(['estado' => 'failed']);
    }

    /**
     * Registrar un reembolso
     */
    public function registrarReembolso(string $refundId, float $monto): void
    {
        $this->update([
            'stripe_refund_id' => $refundId,
            'monto_reembolsado' => $monto,
            'fecha_reembolso' => now(),
            'estado' => 'refunded',
        ]);
    }

    /**
     * Obtener el monto formateado
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format((float) $this->monto, 2);
    }

    /**
     * Scope: filtrar por estado
     */
    public function scopeEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope: filtrar por tipo de pago
     */
    public function scopeTipoPago($query, string $tipo)
    {
        return $query->where('tipo_pago', $tipo);
    }

    /**
     * Scope: pagos exitosos
     */
    public function scopeExitosos($query)
    {
        return $query->where('estado', 'succeeded');
    }

    /**
     * Scope: pagos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pending');
    }
}
