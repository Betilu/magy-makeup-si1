<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServicioProducto
 *
 * Modelo para la tabla pivot `servicio_productos`.
 */
class ServicioProducto extends Model
{
    use HasFactory;

    protected $table = 'servicio_productos';

    /**
     * Atributos asignables.
     *
     * @var array
     */
    protected $fillable = [
        'servicio_id',
        'producto_id',
    ];

    /**
     * Relaciones
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
 