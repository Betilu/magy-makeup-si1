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
}
