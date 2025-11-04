<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Servicio
 *
 * Columnas esperadas (según la migration): id, categoria, nombre, descripcion, duracion, timestamps
 */
class Servicio extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     *
     * @var string
     */
    protected $table = 'servicios';

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'categoria',
        'nombre',
        'descripcion',
        'duracion',
    ];

    /**
     * Casts para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        // La migration define 'categoria' como string.
        'categoria' => 'string',
        // 'duracion' se dejó como string en la migration.
    ];
}
 