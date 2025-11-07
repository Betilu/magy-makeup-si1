<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Herramienta;

class HerramientaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $herramientas = [
            [
                'nombre' => 'Set de Brochas Profesionales',
                'tipo' => 'Brocha',
                'marca' => 'Morphe',
                'modelo' => 'M527',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-01-15',
                'observacion' => 'Set completo de 12 brochas para maquillaje profesional',
            ],
            [
                'nombre' => 'Rizador de Pestañas',
                'tipo' => 'Accesorio',
                'marca' => 'Shu',
                'modelo' => 'Classic',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-02-10',
                'observacion' => 'Rizador de pestañas de metal con almohadilla de silicón',
            ],
            [
                'nombre' => 'Esponja de Maquillaje',
                'tipo' => 'Esponja',
                'marca' => 'BB',
                'modelo' => 'Original',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-03-05',
                'observacion' => 'Esponja tipo beauty blender para aplicación de base',
            ],
            [
                'nombre' => 'Pinzas para Cejas',
                'tipo' => 'Herramienta',
                'marca' => 'Tweezer',
                'modelo' => 'Slant',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-01-20',
                'observacion' => 'Pinzas profesionales de acero inoxidable',
            ],
            [
                'nombre' => 'Espátula para Mezclar',
                'tipo' => 'Accesorio',
                'marca' => 'Generic',
                'modelo' => 'Pro-Mix',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-02-01',
                'observacion' => 'Espátula de acero para mezclar productos',
            ],
            [
                'nombre' => 'Plancha de Cabello',
                'tipo' => 'Eléctrico',
                'marca' => 'GHD',
                'modelo' => 'Platinum+',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-04-10',
                'observacion' => 'Plancha profesional de cerámica y turmalina',
            ],
            [
                'nombre' => 'Secadora de Cabello',
                'tipo' => 'Eléctrico',
                'marca' => 'Dyson',
                'modelo' => 'Super',
                'estadoHerramienta' => 'Disponible',
                'fechaAdquisicion' => '2025-03-15',
                'observacion' => 'Secadora profesional de 2000W con tecnología iónica',
            ],
        ];

        foreach ($herramientas as $herramienta) {
            Herramienta::create($herramienta);
        }
    }
}
