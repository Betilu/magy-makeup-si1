<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estilista extends Model
{
    protected $fillable = [
        'user_id',
        'horario_id',
        'calificacion',
        'comision',
        'disponibilidad',
        'especialidad',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'comision' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }
}
