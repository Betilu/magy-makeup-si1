<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Base de Maquillaje HD',
                'marca' => 'MAC',
                'cateogoria' => 'Base',
                'precio' => '480.00',
                'stockActual' => 25.00,
                'stockMin' => 5.00,
                'fechaVencimiento' => '2026-11-07',
            ],
            [
                'nombre' => 'Paleta de Sombras Nude',
                'marca' => 'Urban Decay',
                'cateogoria' => 'Sombras',
                'precio' => '650.00',
                'stockActual' => 15.00,
                'stockMin' => 3.00,
                'fechaVencimiento' => '2027-05-15',
            ],
            [
                'nombre' => 'Labial Mate Líquido',
                'marca' => 'Kylie Cosmetics',
                'cateogoria' => 'Labial',
                'precio' => '280.00',
                'stockActual' => 40.00,
                'stockMin' => 10.00,
                'fechaVencimiento' => '2026-08-20',
            ],
            [
                'nombre' => 'Delineador de Ojos',
                'marca' => 'Stila',
                'cateogoria' => 'Ojos',
                'precio' => '320.00',
                'stockActual' => 30.00,
                'stockMin' => 8.00,
                'fechaVencimiento' => '2026-12-10',
            ],
            [
                'nombre' => 'Rubor en Polvo',
                'marca' => 'NARS',
                'cateogoria' => 'Rubor',
                'precio' => '420.00',
                'stockActual' => 20.00,
                'stockMin' => 5.00,
                'fechaVencimiento' => '2027-03-01',
            ],
            [
                'nombre' => 'Máscara de Pestañas',
                'marca' => 'Benefit',
                'cateogoria' => 'Pestañas',
                'precio' => '380.00',
                'stockActual' => 35.00,
                'stockMin' => 10.00,
                'fechaVencimiento' => '2026-09-15',
            ],
            [
                'nombre' => 'Iluminador en Polvo',
                'marca' => 'Fenty Beauty',
                'cateogoria' => 'Iluminador',
                'precio' => '520.00',
                'stockActual' => 18.00,
                'stockMin' => 4.00,
                'fechaVencimiento' => '2027-01-20',
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
