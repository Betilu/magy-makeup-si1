<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacions';

    protected $fillable = [
        'client_id',
        'cita_id',
        'estado',
        'fecha',
        'mensaje',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
