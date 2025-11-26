<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidencia extends Model
{
    use HasFactory;

    // Constantes de tipo de incidente
    const TIPO_EN_REVISION = 'En revisión';
    const TIPO_DANADA = 'Dañada';
    const TIPO_PERDIDA = 'Perdida';

    protected $fillable = [
        'herramienta_id',
        'tipo_incidente',
        'descripcion',
        'fechaIncidente',
        'fechaRemplazo',
    ];

    protected $casts = [
        'fechaIncidente' => 'date',
        'fechaRemplazo' => 'date',
    ];

    /**
     * Relación con Herramienta
     */
    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class);
    }

    /**
     * Obtener los tipos de incidente disponibles
     */
    public static function getTiposIncidente()
    {
        return [
            self::TIPO_EN_REVISION => 'En revisión',
            self::TIPO_DANADA => 'Dañada',
            self::TIPO_PERDIDA => 'Perdida',
        ];
    }
}
