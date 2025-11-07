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
