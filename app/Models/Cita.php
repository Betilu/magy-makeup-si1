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
        'estado',
        'anticipo',
        'fecha',
        'hora',
        'tipo',
    ];

    // 🔗 Relación: una cita pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relación: una cita puede tener notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
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
}
