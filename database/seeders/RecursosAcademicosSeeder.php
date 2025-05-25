<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecursosAcademicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear recursos/espacios físicos
        $recursos = [
            ['recurso' => 'Salón Principal'],
            ['recurso' => 'Aula Múltiple'],
            ['recurso' => 'Teatro Municipal'],
            ['recurso' => 'Plaza Central'],
            ['recurso' => 'Biblioteca Municipal'],
            ['recurso' => 'Auditorio'],
            ['recurso' => 'Salón de Danza'],
            ['recurso' => 'Salón de Música'],
            ['recurso' => 'Taller de Artes'],
            ['recurso' => 'Patio Exterior'],
            ['recurso' => 'Cancha Deportiva'],
            ['recurso' => 'Salón de Conferencias'],
            ['recurso' => 'Laboratorio Audiovisual'],
            ['recurso' => 'Espacio Verde'],
            ['recurso' => 'Salón Comunitario'],
        ];

        foreach ($recursos as $recurso) {
            DB::table('recursos')->updateOrInsert(
                ['recurso' => $recurso['recurso']],
                [
                    'recurso' => $recurso['recurso'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Crear niveles académicos
        $niveles = [
            ['nivel' => 'Inicial'],
            ['nivel' => 'Básico'],
            ['nivel' => 'Intermedio'],
            ['nivel' => 'Avanzado'],
            ['nivel' => 'Especializado'],
            ['nivel' => 'Profesional'],
        ];

        foreach ($niveles as $nivel) {
            DB::table('niveles')->updateOrInsert(
                ['nivel' => $nivel['nivel']],
                [
                    'nivel' => $nivel['nivel'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Crear horarios
        $horarios = [
            ['dia' => 'Lunes', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
            ['dia' => 'Lunes', 'hora_inicio' => '16:00:00', 'hora_fin' => '18:00:00'],
            ['dia' => 'Martes', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
            ['dia' => 'Martes', 'hora_inicio' => '16:00:00', 'hora_fin' => '18:00:00'],
            ['dia' => 'Miércoles', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
            ['dia' => 'Miércoles', 'hora_inicio' => '16:00:00', 'hora_fin' => '18:00:00'],
            ['dia' => 'Jueves', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
            ['dia' => 'Jueves', 'hora_inicio' => '16:00:00', 'hora_fin' => '18:00:00'],
            ['dia' => 'Viernes', 'hora_inicio' => '15:00:00', 'hora_fin' => '17:00:00'],
            ['dia' => 'Viernes', 'hora_inicio' => '17:00:00', 'hora_fin' => '19:00:00'],
            ['dia' => 'Sábado', 'hora_inicio' => '08:00:00', 'hora_fin' => '10:00:00'],
            ['dia' => 'Sábado', 'hora_inicio' => '10:00:00', 'hora_fin' => '12:00:00'],
            ['dia' => 'Sábado', 'hora_inicio' => '14:00:00', 'hora_fin' => '16:00:00'],
            ['dia' => 'Domingo', 'hora_inicio' => '09:00:00', 'hora_fin' => '11:00:00'],
            ['dia' => 'Domingo', 'hora_inicio' => '15:00:00', 'hora_fin' => '17:00:00'],
        ];

        foreach ($horarios as $horario) {
            DB::table('horarios')->updateOrInsert(
                [
                    'dia' => $horario['dia'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fin' => $horario['hora_fin']
                ],
                [
                    'dia' => $horario['dia'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fin' => $horario['hora_fin'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Recursos académicos creados exitosamente.');
    }
}