<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasProgramasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear escuelas
        $escuelas = [
            [
                'nombre' => 'Escuela de Música',
                'descripcion' => 'Formación musical integral para todas las edades, incluyendo instrumentos, canto y teoría musical'
            ],
            [
                'nombre' => 'Escuela de Danza',
                'descripcion' => 'Formación en danza tradicional, folclórica y contemporánea con énfasis en la cultura colombiana'
            ],
            [
                'nombre' => 'Escuela de Artes Plásticas',
                'descripcion' => 'Desarrollo de habilidades artísticas en dibujo, pintura, escultura y técnicas mixtas'
            ],
            [
                'nombre' => 'Escuela de Teatro',
                'descripcion' => 'Formación en artes dramáticas, expresión corporal y montajes teatrales comunitarios'
            ],
            [
                'nombre' => 'Escuela de Artesanías',
                'descripcion' => 'Preservación y enseñanza de técnicas artesanales tradicionales de la región'
            ],
            [
                'nombre' => 'Escuela de Literatura',
                'descripcion' => 'Fomento de la lectura, escritura creativa y narración oral'
            ],
            [
                'nombre' => 'Escuela de Deportes y Recreación',
                'descripcion' => 'Actividades deportivas y recreativas para el desarrollo físico y social'
            ],
            [
                'nombre' => 'Escuela de Patrimonio Cultural',
                'descripcion' => 'Conocimiento y preservación del patrimonio cultural local y nacional'
            ]
        ];

        foreach ($escuelas as $escuela) {
            DB::table('escuelas')->updateOrInsert(
                ['nombre' => $escuela['nombre']],
                [
                    'nombre' => $escuela['nombre'],
                    'descripcion' => $escuela['descripcion'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Crear tipos de escuela
        $tiposEscuela = [
            ['tipos_escuela' => 'Formal'],
            ['tipos_escuela' => 'No Formal'],
            ['tipos_escuela' => 'Taller Corto'],
            ['tipos_escuela' => 'Semillero'],
            ['tipos_escuela' => 'Diplomado'],
            ['tipos_escuela' => 'Curso Libre'],
            ['tipos_escuela' => 'Intensivo'],
        ];

        foreach ($tiposEscuela as $tipo) {
            DB::table('tipos_escuela')->updateOrInsert(
                ['tipos_escuela' => $tipo['tipos_escuela']],
                [
                    'tipos_escuela' => $tipo['tipos_escuela'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Crear ubicaciones
        $ubicaciones = [
            ['ubicacion' => 'Centro Cultural Municipal'],
            ['ubicacion' => 'Biblioteca Municipal'],
            ['ubicacion' => 'Plaza Principal'],
            ['ubicacion' => 'Casa de la Cultura'],
            ['ubicacion' => 'Parque Central'],
            ['ubicacion' => 'Salón Comunal'],
            ['ubicacion' => 'Teatro al Aire Libre'],
            ['ubicacion' => 'Polideportivo Municipal'],
            ['ubicacion' => 'Sede Administrativa'],
            ['ubicacion' => 'Centro Comunitario'],
            ['ubicacion' => 'Salón Parroquial'],
            ['ubicacion' => 'Escuela Rural'],
        ];

        foreach ($ubicaciones as $ubicacion) {
            DB::table('ubicaciones')->updateOrInsert(
                ['ubicacion' => $ubicacion['ubicacion']],
                [
                    'ubicacion' => $ubicacion['ubicacion'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Escuelas y programas creados exitosamente.');
    }
}