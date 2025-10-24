<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'clients';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'direccion',
        'frecuencia',
        'observacion',
    ];

    protected $casts = [
        'frecuencia' => 'integer',
    ];

    /**
     * Relación: un cliente pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
