<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['estado' => 'Activo'],
            ['estado' => 'Inactivo'],
            ['estado' => 'Suspendido'],
            ['estado' => 'Pendiente'],
            ['estado' => 'Bloqueado'],
        ];

        foreach ($estados as $estado) {
            DB::table('estados')->updateOrInsert(
                ['estado' => $estado['estado']],
                [
                    'estado' => $estado['estado'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Estados creados exitosamente.');
    }
}