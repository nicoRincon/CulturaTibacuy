<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generos = [
            ['genero' => 'Masculino'],
            ['genero' => 'Femenino'],
            ['genero' => 'Otro'],
            ['genero' => 'Prefiero no decirlo'],
        ];

        foreach ($generos as $genero) {
            DB::table('generos')->updateOrInsert(
                ['genero' => $genero['genero']],
                [
                    'genero' => $genero['genero'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Géneros creados exitosamente.');
    }
}