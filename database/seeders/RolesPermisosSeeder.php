<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de roles
        $adminRol = DB::table('roles')->where('rol', 'Administrador')->first();
        $instructorRol = DB::table('roles')->where('rol', 'Instructor')->first();
        $estudianteRol = DB::table('roles')->where('rol', 'Estudiante')->first();

        // Obtener todos los permisos
        $permisos = DB::table('permisos')->get();

        // Asignar TODOS los permisos al Administrador
        if ($adminRol) {
            foreach ($permisos as $permiso) {
                DB::table('roles_permisos')->updateOrInsert(
                    [
                        'id_rol' => $adminRol->id_rol,
                        'id_permiso' => $permiso->id_permiso
                    ],
                    [
                        'id_rol' => $adminRol->id_rol,
                        'id_permiso' => $permiso->id_permiso,
                        'fecha_asignacion' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // Permisos específicos para Instructor
        if ($instructorRol) {
            $permisosInstructor = [
                'ver_cursos',
                'editar_cursos', // Solo sus propios cursos
                'crear_evaluaciones',
                'editar_evaluaciones',
                'ver_evaluaciones',
                'ver_inscripciones',
                'crear_inscripciones', // Para inscribir estudiantes en sus cursos
                'generar_informes_academicos',
                'ver_usuarios', // Solo estudiantes
            ];

            foreach ($permisosInstructor as $permisoNombre) {
                $permiso = DB::table('permisos')->where('permiso', $permisoNombre)->first();
                if ($permiso) {
                    DB::table('roles_permisos')->updateOrInsert(
                        [
                            'id_rol' => $instructorRol->id_rol,
                            'id_permiso' => $permiso->id_permiso
                        ],
                        [
                            'id_rol' => $instructorRol->id_rol,
                            'id_permiso' => $permiso->id_permiso,
                            'fecha_asignacion' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }

        // Permisos específicos para Estudiante
        if ($estudianteRol) {
            $permisosEstudiante = [
                'ver_cursos',
                'crear_inscripciones', // Solo para inscribirse a sí mismo
                'ver_inscripciones', // Solo sus propias inscripciones
                'ver_evaluaciones', // Solo sus propias evaluaciones
            ];

            foreach ($permisosEstudiante as $permisoNombre) {
                $permiso = DB::table('permisos')->where('permiso', $permisoNombre)->first();
                if ($permiso) {
                    DB::table('roles_permisos')->updateOrInsert(
                        [
                            'id_rol' => $estudianteRol->id_rol,
                            'id_permiso' => $permiso->id_permiso
                        ],
                        [
                            'id_rol' => $estudianteRol->id_rol,
                            'id_permiso' => $permiso->id_permiso,
                            'fecha_asignacion' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }

        $this->command->info('Relaciones roles-permisos creadas exitosamente.');
    }
}