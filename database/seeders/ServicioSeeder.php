<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            [
                'categoria' => 'Maquillaje',
                'nombre' => 'Maquillaje Social',
                'descripcion' => 'Maquillaje profesional para eventos sociales, fiestas y ocasiones especiales',
                'duracion' => '60 minutos',
                'precio_servicio' => 150.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Maquillaje',
                'nombre' => 'Maquillaje de Novia',
                'descripcion' => 'Maquillaje nupcial completo con prueba previa incluida',
                'duracion' => '90 minutos',
                'precio_servicio' => 350.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Cejas',
                'nombre' => 'Depilación y Diseño de Cejas',
                'descripcion' => 'Diseño profesional de cejas con depilación incluida',
                'duracion' => '30 minutos',
                'precio_servicio' => 80.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Pestañas',
                'nombre' => 'Extensiones de Pestañas',
                'descripcion' => 'Aplicación de extensiones de pestañas pelo a pelo',
                'duracion' => '120 minutos',
                'precio_servicio' => 280.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Maquillaje',
                'nombre' => 'Maquillaje Artístico',
                'descripcion' => 'Maquillaje creativo para sesiones fotográficas y eventos artísticos',
                'duracion' => '75 minutos',
                'precio_servicio' => 200.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Peinado',
                'nombre' => 'Peinado de Fiesta',
                'descripcion' => 'Peinado profesional para eventos y celebraciones',
                'duracion' => '45 minutos',
                'precio_servicio' => 120.00,
                'estado' => 'activo',
            ],
            [
                'categoria' => 'Cejas',
                'nombre' => 'Microblading de Cejas',
                'descripcion' => 'Técnica de micropigmentación para cejas naturales y definidas',
                'duracion' => '150 minutos',
                'precio_servicio' => 450.00,
                'estado' => 'activo',
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
