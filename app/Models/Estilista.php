<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estilista extends Model
{
    use HasFactory;

    protected $table = 'estilistas';

    protected $fillable = [
        'horario_id',
        'user_id',
        'calificacion',
        'comision',
        'disponibilidad',
        'especialidad',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    // 👥 Si más adelante un estilista tiene muchas citas:
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
