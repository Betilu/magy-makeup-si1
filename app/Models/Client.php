<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
     use HasFactory;

    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'clients';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'direccion',
        'frecuencia',
        'observacion',
    ];

    /**
     * Relación: un cliente pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
