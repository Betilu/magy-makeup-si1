<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promocion;

class PromocionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promociones = [
            [
                'nombre' => 'Paquete Quinceañera',
                'descripcion' => 'Maquillaje + peinado especial para quinceañeras',
                'descuento' => 15.00,
                'fechaInicio' => '2025-11-01',
                'fechaFin' => '2025-12-31',
            ],
            [
                'nombre' => 'Especial Novias',
                'descripcion' => 'Paquete completo para novias con prueba incluida',
                'descuento' => 20.00,
                'fechaInicio' => '2025-11-01',
                'fechaFin' => '2026-03-31',
            ],
            [
                'nombre' => 'Black Friday Beauty',
                'descripcion' => 'Descuento especial en todos los servicios',
                'descuento' => 30.00,
                'fechaInicio' => '2025-11-29',
                'fechaFin' => '2025-11-29',
            ],
            [
                'nombre' => 'Día de las Madres',
                'descripcion' => 'Promoción especial para mamás',
                'descuento' => 25.00,
                'fechaInicio' => '2026-05-01',
                'fechaFin' => '2026-05-10',
            ],
            [
                'nombre' => 'Paquete Amigas',
                'descripcion' => 'Descuento para grupos de 3 o más personas',
                'descuento' => 18.00,
                'fechaInicio' => '2025-11-01',
                'fechaFin' => '2026-06-30',
            ],
            [
                'nombre' => 'Fin de Año',
                'descripcion' => 'Especial para celebrar el año nuevo',
                'descuento' => 22.00,
                'fechaInicio' => '2025-12-15',
                'fechaFin' => '2025-12-31',
            ],
            [
                'nombre' => 'Cliente Frecuente',
                'descripcion' => 'Descuento permanente para clientes frecuentes',
                'descuento' => 10.00,
                'fechaInicio' => '2025-11-01',
                'fechaFin' => '2026-12-31',
            ],
        ];

        foreach ($promociones as $promocion) {
            Promocion::create($promocion);
        }
    }
}
