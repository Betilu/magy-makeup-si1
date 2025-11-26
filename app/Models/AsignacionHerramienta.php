<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionHerramienta extends Model
{
    use HasFactory;

    // Constantes de estado
    const ESTADO_FUNCIONANDO = 'funcionando';
    const ESTADO_DEJO_FUNCIONAR = 'dejo de funcionar';
    const ESTADO_OTRO = 'otro';

    protected $fillable = [
        'herramienta_id',
        'estilista_id',
        'recepcionista_id',
        'estadoEntrega',
        'estadoDevolucion',
        'fechaAsignacion',
        'fechaDevolucion',

    ];

    protected $casts = [
        'fechaAsignacion' => 'date',
        'fechaDevolucion' => 'date',
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

    /**
     * Obtener los estados disponibles
     */
    public static function getEstados()
    {
        return [
            self::ESTADO_FUNCIONANDO => 'Funcionando',
            self::ESTADO_DEJO_FUNCIONAR => 'Dejó de funcionar',
            self::ESTADO_OTRO => 'Otro',
        ];
    }
}
