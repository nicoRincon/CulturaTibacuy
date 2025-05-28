<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // Permisos de Usuarios
            ['permiso' => 'crear_usuarios', 'descripcion' => 'Permite crear nuevos usuarios en el sistema'],
            ['permiso' => 'editar_usuarios', 'descripcion' => 'Permite editar usuarios existentes'],
            ['permiso' => 'eliminar_usuarios', 'descripcion' => 'Permite eliminar usuarios del sistema'],
            ['permiso' => 'ver_usuarios', 'descripcion' => 'Permite ver la lista de usuarios'],
            
            // Permisos de Cursos
            ['permiso' => 'crear_cursos', 'descripcion' => 'Permite crear nuevos cursos'],
            ['permiso' => 'editar_cursos', 'descripcion' => 'Permite editar cursos existentes'],
            ['permiso' => 'eliminar_cursos', 'descripcion' => 'Permite eliminar cursos'],
            ['permiso' => 'ver_cursos', 'descripcion' => 'Permite ver la lista de cursos'],
            
            // Permisos de Escuelas
            ['permiso' => 'crear_escuelas', 'descripcion' => 'Permite crear nuevas escuelas'],
            ['permiso' => 'editar_escuelas', 'descripcion' => 'Permite editar escuelas existentes'],
            ['permiso' => 'eliminar_escuelas', 'descripcion' => 'Permite eliminar escuelas'],
            ['permiso' => 'ver_escuelas', 'descripcion' => 'Permite ver la lista de escuelas'],
            
            // Permisos de Programas
            ['permiso' => 'crear_programas', 'descripcion' => 'Permite crear programas de formación'],
            ['permiso' => 'editar_programas', 'descripcion' => 'Permite editar programas de formación'],
            ['permiso' => 'eliminar_programas', 'descripcion' => 'Permite eliminar programas de formación'],
            ['permiso' => 'ver_programas', 'descripcion' => 'Permite ver programas de formación'],
            
            // Permisos de Evaluaciones
            ['permiso' => 'crear_evaluaciones', 'descripcion' => 'Permite crear evaluaciones'],
            ['permiso' => 'editar_evaluaciones', 'descripcion' => 'Permite editar evaluaciones'],
            ['permiso' => 'eliminar_evaluaciones', 'descripcion' => 'Permite eliminar evaluaciones'],
            ['permiso' => 'ver_evaluaciones', 'descripcion' => 'Permite ver evaluaciones'],
            
            // Permisos de Inscripciones
            ['permiso' => 'crear_inscripciones', 'descripcion' => 'Permite crear inscripciones'],
            ['permiso' => 'eliminar_inscripciones', 'descripcion' => 'Permite eliminar inscripciones'],
            ['permiso' => 'ver_inscripciones', 'descripcion' => 'Permite ver inscripciones'],
            
            // Permisos de Informes
            ['permiso' => 'generar_informes_generales', 'descripcion' => 'Permite generar informes generales del sistema'],
            ['permiso' => 'generar_informes_academicos', 'descripcion' => 'Permite generar informes académicos'],
            ['permiso' => 'ver_reportes_estadisticos', 'descripcion' => 'Permite ver reportes y estadísticas'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(
                ['permiso' => $permiso['permiso']],
                [
                    'permiso' => $permiso['permiso'],
                    'descripcion' => $permiso['descripcion'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Permisos creados exitosamente.');
    }
}