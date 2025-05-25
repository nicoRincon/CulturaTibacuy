<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoIdentificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentos = [
            ['tipo_documento' => 'Cédula de Ciudadanía'],
            ['tipo_documento' => 'Tarjeta de Identidad'],
            ['tipo_documento' => 'Cédula de Extranjería'],
            ['tipo_documento' => 'Pasaporte'],
            ['tipo_documento' => 'Registro Civil'],
            ['tipo_documento' => 'NUIP'],
        ];

        foreach ($documentos as $documento) {
            DB::table('documento_de_identificacion')->updateOrInsert(
                ['tipo_documento' => $documento['tipo_documento']],
                [
                    'tipo_documento' => $documento['tipo_documento'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Documentos de identificación creados exitosamente.');
    }
}