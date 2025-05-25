<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['rol' => 'Administrador'],
            ['rol' => 'Instructor'],
            ['rol' => 'Estudiante'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['rol' => $rol['rol']],
                [
                    'rol' => $rol['rol'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Roles creados exitosamente.');
    }
}