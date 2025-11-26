<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios con rol cliente (excluyendo el usuario de prueba básico)
        $clienteUsers = User::role('cliente')->get();
        
        $clientesData = [
            [
                'direccion' => 'Av. Principal #123, Col. Centro',
                'frecuencia' => 5,
                'observacion' => 'Cliente frecuente, prefiere maquillaje natural',
            ],
            [
                'direccion' => 'Calle Reforma #456, Col. Reforma',
                'frecuencia' => 3,
                'observacion' => 'Acude principalmente para eventos especiales',
            ],
            [
                'direccion' => 'Blvd. Insurgentes #789, Col. Del Valle',
                'frecuencia' => 8,
                'observacion' => 'Muy puntual, cliente VIP',
            ],
            [
                'direccion' => 'Av. Juárez #321, Col. Juárez',
                'frecuencia' => 4,
                'observacion' => 'Piel sensible, requiere productos hipoalergénicos',
            ],
            [
                'direccion' => 'Calle Hidalgo #654, Col. Morelos',
                'frecuencia' => 6,
                'observacion' => 'Le gusta probar estilos nuevos',
            ],
            [
                'direccion' => 'Av. Constitución #987, Col. Constitución',
                'frecuencia' => 2,
                'observacion' => 'Cliente ocasional, bodas y quinceañeras',
            ],
            [
                'direccion' => 'Calle Madero #147, Col. Centro Histórico',
                'frecuencia' => 7,
                'observacion' => 'Prefiere citas matutinas',
            ],
        ];

        // Crear registros de clientes asociados a los usuarios
        foreach ($clienteUsers as $index => $user) {
            if ($index < count($clientesData)) {
                Client::create([
                    'user_id' => $user->id,
                    'direccion' => $clientesData[$index]['direccion'],
                    'frecuencia' => $clientesData[$index]['frecuencia'],
                    'observacion' => $clientesData[$index]['observacion'],
                ]);
            }
        }
    }
}
