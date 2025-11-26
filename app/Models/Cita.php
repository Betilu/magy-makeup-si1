<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'user_id',
        'estilista_id',
        'servicio_id',
        'estado',
        'anticipo',
        'precio_total',
        'comision_estilista',
        'fecha',
        'hora',
        'tipo',
    ];

    protected $casts = [
        'anticipo' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'comision_estilista' => 'decimal:2',
    ];

    // 🔗 Relación: una cita pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relación: una cita pertenece a un estilista
    public function estilista()
    {
        return $this->belongsTo(Estilista::class);
    }

    // 🔗 Relación: una cita pertenece a un servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // 🔗 Relación: una cita puede tener notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    // 🔗 Relación: una cita puede tener múltiples pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // 🔗 Relación: obtener el cliente a través del usuario
    // (asumiendo que el user de la cita es un cliente)
    public function client()
    {
        return $this->hasOneThrough(
            Client::class,  // Modelo final
            User::class,    // Modelo intermedio
            'id',           // Foreign key en la tabla users
            'user_id',      // Foreign key en la tabla clients
            'user_id',      // Local key en la tabla citas
            'id'            // Local key en la tabla users
        );
    }

    /**
     * Verificar si la cita tiene pagos exitosos
     */
    public function tienePagosExitosos(): bool
    {
        return $this->pagos()->where('estado', 'succeeded')->exists();
    }

    /**
     * Obtener el total pagado de la cita
     */
    public function totalPagado(): float
    {
        return (float) $this->pagos()
            ->where('estado', 'succeeded')
            ->sum('monto');
    }

    /**
     * Obtener el saldo pendiente de la cita
     */
    public function saldoPendiente(): float
    {
        $total = (float) $this->precio_total;
        $pagado = $this->totalPagado();
        return max(0, $total - $pagado);
    }

    /**
     * Verificar si la cita está completamente pagada
     */
    public function estaCompletamentePagada(): bool
    {
        return $this->saldoPendiente() <= 0.01; // Margen de error por decimales
    }

    /**
     * Obtener el último pago exitoso
     */
    public function ultimoPagoExitoso()
    {
        return $this->pagos()
            ->where('estado', 'succeeded')
            ->latest()
            ->first();
    }
}
