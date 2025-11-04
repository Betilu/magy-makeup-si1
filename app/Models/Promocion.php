<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Promocion
 *
 * Columnas esperadas (según la migration): id, nombre, descripcion, fechaInicio, fechaFin, descuento, timestamps
 */
class Promocion extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     *
     * @var string
     */
    protected $table = 'promocions';

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'fechaInicio',
        'fechaFin',
        'descuento',
    ];

    /**
     * Casts para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fechaInicio' => 'date',
        'fechaFin' => 'date',
        'descuento' => 'float',
    ];
}
 