<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Producto
 *
 * Columnas esperadas (según la migration): id, cateogoria, nombre, marca, precio,
 * stockActual, stockMin, fechaVencimiento, timestamps
 */
class Producto extends Model
{
    use HasFactory;

    /**
     * Tabla asociada.
     * (Se define explícitamente aunque siga la convención, por claridad.)
     *
     * @var string
     */
    protected $table = 'productos';

    /**
     * Atributos asignables en masa.
     * Mantengo los nombres tal y como están en la migration (p.ej. 'cateogoria').
     *
     * @var array
     */
    protected $fillable = [
        'cateogoria',
        'nombre',
        'marca',
        'precio',
        'stockActual',
        'stockMin',
        'fechaVencimiento',
    ];

    /**
     * Casts para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'stockActual' => 'float',
        'stockMin' => 'float',
        'fechaVencimiento' => 'date',
        // 'precio' se definió como string en la migration; lo dejamos como string
        // para evitar inconsistencias. Si desea manejarlo como decimal, cambiar la
        // migration o la columna a decimal/float y añadir: 'precio' => 'decimal:2'
    ];

    /**
     * Relación muchos a muchos con Servicio
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_productos')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}
