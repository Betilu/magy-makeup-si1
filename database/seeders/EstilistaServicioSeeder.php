<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estilista;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;

class EstilistaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las estilistas y servicios
        $estilistas = Estilista::all();
        $servicios = Servicio::all();

        if ($estilistas->isEmpty() || $servicios->isEmpty()) {
            $this->command->warn('⚠️  No hay estilistas o servicios en la base de datos. Asegúrate de ejecutar los seeders correspondientes primero.');
            return;
        }

        // Asignar todos los servicios a todas las estilistas por defecto
        // Esto permite que cualquier estilista pueda ofrecer cualquier servicio
        // Puedes modificar esta lógica según tus necesidades específicas
        foreach ($estilistas as $estilista) {
            // Asignar entre 3 y todos los servicios a cada estilista
            $serviciosAleatorios = $servicios->random(min(3, $servicios->count()));

            foreach ($serviciosAleatorios as $servicio) {
                DB::table('estilista_servicio')->insertOrIgnore([
                    'estilista_id' => $estilista->id,
                    'servicio_id' => $servicio->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ Relaciones entre estilistas y servicios creadas exitosamente.');
    }
}
