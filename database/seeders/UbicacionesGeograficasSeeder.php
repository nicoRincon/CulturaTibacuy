<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionesGeograficasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear países
        $colombia_id = DB::table('pais')->updateOrInsert(
            ['pais' => 'Colombia'],
            [
                'pais' => 'Colombia',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Si no se insertó, obtener el ID existente
        if (!$colombia_id) {
            $colombia = DB::table('pais')->where('pais', 'Colombia')->first();
            $colombia_id = $colombia ? $colombia->id_pais : null;
        }

        if (!$colombia_id) {
            $colombia_id = DB::table('pais')->insertGetId([
                'pais' => 'Colombia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Crear departamentos principales de Colombia
        $departamentos = [
            'Cundinamarca',
            'Antioquia',
            'Valle del Cauca',
            'Atlántico',
            'Santander',
            'Bolívar',
            'Boyacá',
            'Córdoba',
            'Meta',
            'Tolima',
        ];

        $departamento_ids = [];
        foreach ($departamentos as $departamento) {
            $existing = DB::table('departamentos')
                ->where('departamento', $departamento)
                ->where('id_pais', $colombia_id)
                ->first();

            if (!$existing) {
                $departamento_ids[$departamento] = DB::table('departamentos')->insertGetId([
                    'id_pais' => $colombia_id,
                    'departamento' => $departamento,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $departamento_ids[$departamento] = $existing->id_dpto;
            }
        }

        // Crear municipios específicos para Cundinamarca (enfoque en Tibacuy)
        $municipios_cundinamarca = [
            'Bogotá D.C.',
            'Tibacuy',
            'Soacha',
            'Fusagasugá',
            'Girardot',
            'Zipaquirá',
            'Chía',
            'Facatativá',
            'Madrid',
            'Mosquera',
            'San Antonio del Tequendama',
            'Viotá',
            'Nilo',
            'Ricaurte',
            'Agua de Dios',
        ];

        $cundinamarca_id = $departamento_ids['Cundinamarca'];
        $municipio_ids = [];

        foreach ($municipios_cundinamarca as $municipio) {
            $existing = DB::table('municipios')
                ->where('municipio', $municipio)
                ->where('id_pais', $colombia_id)
                ->where('id_dpto', $cundinamarca_id)
                ->first();

            if (!$existing) {
                $municipio_ids[$municipio] = DB::table('municipios')->insertGetId([
                    'id_pais' => $colombia_id,
                    'id_dpto' => $cundinamarca_id,
                    'municipio' => $municipio,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $municipio_ids[$municipio] = $existing->id_mpio;
            }
        }

        // Crear algunos lugares de nacimiento principales
        $lugares_principales = [
            ['pais' => $colombia_id, 'dpto' => $cundinamarca_id, 'mpio' => $municipio_ids['Bogotá D.C.']],
            ['pais' => $colombia_id, 'dpto' => $cundinamarca_id, 'mpio' => $municipio_ids['Tibacuy']],
            ['pais' => $colombia_id, 'dpto' => $cundinamarca_id, 'mpio' => $municipio_ids['Fusagasugá']],
            ['pais' => $colombia_id, 'dpto' => $cundinamarca_id, 'mpio' => $municipio_ids['Soacha']],
        ];

        foreach ($lugares_principales as $lugar) {
            $existing = DB::table('lugar_de_nacimiento')
                ->where('id_pais', $lugar['pais'])
                ->where('id_dpto', $lugar['dpto'])
                ->where('id_mpio', $lugar['mpio'])
                ->first();

            if (!$existing) {
                DB::table('lugar_de_nacimiento')->insert([
                    'id_pais' => $lugar['pais'],
                    'id_dpto' => $lugar['dpto'],
                    'id_mpio' => $lugar['mpio'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Ubicaciones geográficas creadas exitosamente.');
    }
}