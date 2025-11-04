<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionHerramienta extends Model
{
    use HasFactory;

    protected $fillable = [
        'herramienta_id',
        'estilista_id',
        'recepcionista_id',
        'estadoEntrega',
        'estadoDevolucion',
        'fechaAsignacion',
        'fechaDevolucion',
       
    ];

    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class);
    }

    public function estilista()
    {
        return $this->belongsTo(Estilista::class);
    }

    public function recepcionista()
    {
        return $this->belongsTo(User::class, 'recepcionista_id');
    }
}
