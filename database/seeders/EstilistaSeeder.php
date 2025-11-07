<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estilista;
use App\Models\Horario;
use App\Models\User;

class EstilistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero crear horarios
        $horarios = [];
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        
        foreach ($dias as $dia) {
            $horarios[] = Horario::create([
                'dia' => $dia,
                'horaInicio' => '09:00',
                'horaFin' => '18:00',
            ]);
        }

        // Obtener usuarios con rol estilista
        $estilistaUsers = User::role('estilista')->get();
        
        $estilistasData = [
            [
                'especialidad' => 'Maquillaje de Novias',
                'calificacion' => 5,
                'disponibilidad' => 'Lunes a Viernes',
                'estado' => 'antiguo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Maquillaje Social y Artístico',
                'calificacion' => 5,
                'disponibilidad' => 'Lunes a Sábado',
                'estado' => 'antiguo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Cejas y Pestañas',
                'calificacion' => 4,
                'disponibilidad' => 'Martes a Sábado',
                'estado' => 'nuevo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Peinados y Styling',
                'calificacion' => 4,
                'disponibilidad' => 'Lunes a Viernes',
                'estado' => 'nuevo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Maquillaje HD y Editorial',
                'calificacion' => 5,
                'disponibilidad' => 'Lunes a Domingo',
                'estado' => 'antiguo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Microblading y Diseño de Cejas',
                'calificacion' => 4,
                'disponibilidad' => 'Miércoles a Domingo',
                'estado' => 'nuevo',
                'total_comisiones' => 0.00,
            ],
            [
                'especialidad' => 'Maquillaje de Quinceañeras',
                'calificacion' => 3,
                'disponibilidad' => 'Viernes a Domingo',
                'estado' => 'nuevo',
                'total_comisiones' => 0.00,
            ],
        ];

        // Crear registros de estilistas asociados a los usuarios
        foreach ($estilistaUsers as $index => $user) {
            if ($index < count($estilistasData) && $index < count($horarios)) {
                Estilista::create([
                    'user_id' => $user->id,
                    'horario_id' => $horarios[$index]->id,
                    'especialidad' => $estilistasData[$index]['especialidad'],
                    'calificacion' => $estilistasData[$index]['calificacion'],
                    'disponibilidad' => $estilistasData[$index]['disponibilidad'],
                    'estado' => $estilistasData[$index]['estado'],
                    'total_comisiones' => $estilistasData[$index]['total_comisiones'],
                ]);
            }
        }
    }
}
