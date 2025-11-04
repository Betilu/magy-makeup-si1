<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PromocionServicio
 *
 * Modelo para la tabla pivot `promocion_servicios`.
 */
class PromocionServicio extends Model
{
    use HasFactory;

    protected $table = 'promocion_servicios';

    /**
     * Atributos asignables.
     *
     * @var array
     */
    protected $fillable = [
        'servicio_id',
        'promocion_id',
    ];

    /**
     * Relaciones
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id');
    }
}
 