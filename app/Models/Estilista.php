<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estilista extends Model
{
    protected $fillable = [
        'user_id',
        'horario_id',
        'calificacion',
        'comision',
        'total_comisiones',
        'disponibilidad',
        'especialidad',
        'estado',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'comision' => 'decimal:2',
        'total_comisiones' => 'decimal:2',
    ];

    /**
     * Obtener el porcentaje de comisión según el estado del estilista
     */
    public function getPorcentajeComisionAttribute()
    {
        return $this->estado === 'antiguo' ? 50 : 40;
    }

    /**
     * Calcular comisión para un precio de servicio
     */
    public function calcularComision($precioServicio)
    {
        $porcentaje = $this->porcentaje_comision;
        return ($precioServicio * $porcentaje) / 100;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /**
     * Relación muchos a muchos con Servicio
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'estilista_servicio');
    }
}
