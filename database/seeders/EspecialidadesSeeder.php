<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            ['especialidad' => 'Administración'],
            ['especialidad' => 'Música'],
            ['especialidad' => 'Danza'],
            ['especialidad' => 'Teatro'],
            ['especialidad' => 'Artes Plásticas'],
            ['especialidad' => 'Pintura'],
            ['especialidad' => 'Escultura'],
            ['especialidad' => 'Fotografía'],
            ['especialidad' => 'Cine y Audiovisuales'],
            ['especialidad' => 'Literatura'],
            ['especialidad' => 'Poesía'],
            ['especialidad' => 'Narración Oral'],
            ['especialidad' => 'Artesanías'],
            ['especialidad' => 'Cultura Popular'],
            ['especialidad' => 'Patrimonio Cultural'],
            ['especialidad' => 'Deportes'],
            ['especialidad' => 'Recreación'],
            ['especialidad' => 'Educación'],
            ['especialidad' => 'Psicología'],
            ['especialidad' => 'Trabajo Social'],
        ];

        foreach ($especialidades as $especialidad) {
            DB::table('especialidades')->updateOrInsert(
                ['especialidad' => $especialidad['especialidad']],
                [
                    'especialidad' => $especialidad['especialidad'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Especialidades creadas exitosamente.');
    }
}