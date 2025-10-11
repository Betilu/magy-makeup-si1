<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Herramienta extends Model
{
     use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'herramientas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'estadoHerramienta',
        'marca',
        'modelo',
        'fechaAdquisicion',
        'nombre',
        'observacion',
        'tipo',
    ];
}
