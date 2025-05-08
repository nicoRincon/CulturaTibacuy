<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear paises
        $colombia_id = DB::table('pais')->insertGetId([
            'pais' => 'Colombia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear departamentos
        $cundinamarca_id = DB::table('departamentos')->insertGetId([
            'id_pais' => $colombia_id,
            'departamento' => 'Cundinamarca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $boyaca_id = DB::table('departamentos')->insertGetId([
            'id_pais' => $colombia_id,
            'departamento' => 'Boyacá',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear municipios
        $bogota_id = DB::table('municipios')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'municipio' => 'Bogotá D.C.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tibacuy_id = DB::table('municipios')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'municipio' => 'Tibacuy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear lugar de nacimiento
        $lugar_nacimiento_bogota_id = DB::table('lugar_de_nacimiento')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'id_mpio' => $bogota_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lugar_nacimiento_tibacuy_id = DB::table('lugar_de_nacimiento')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'id_mpio' => $tibacuy_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear tipos de documento
        $cedula_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Cédula de Ciudadanía',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ti_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Tarjeta de Identidad',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pasaporte_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Pasaporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear géneros
        $masculino_id = DB::table('generos')->insertGetId([
            'genero' => 'Masculino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $femenino_id = DB::table('generos')->insertGetId([
            'genero' => 'Femenino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otro_id = DB::table('generos')->insertGetId([
            'genero' => 'Otro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear roles
        $admin_id = DB::table('roles')->insertGetId([
            'rol' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructor_id = DB::table('roles')->insertGetId([
            'rol' => 'Instructor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudiante_id = DB::table('roles')->insertGetId([
            'rol' => 'Estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear estados
        $activo_id = DB::table('estados')->insertGetId([
            'estado' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $inactivo_id = DB::table('estados')->insertGetId([
            'estado' => 'Inactivo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $suspendido_id = DB::table('estados')->insertGetId([
            'estado' => 'Suspendido',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear especialidades
        $administracion_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Administración',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $musica_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Música',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $danza_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Danza',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $pintura_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Pintura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teatro_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Teatro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $deporte_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Deporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear contactos
        $contacto_admin_id = DB::table('contactos')->insertGetId([
            'telefono' => '3001234567',
            'email' => 'admin@culturatibacuy.com',
            'direccion' => 'Calle 123 # 45-67',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contacto_instructor_id = DB::table('contactos')->insertGetId([
            'telefono' => '3112345678',
            'email' => 'instructor@culturatibacuy.com',
            'direccion' => 'Carrera 45 # 67-89',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contacto_estudiante_id = DB::table('contactos')->insertGetId([
            'telefono' => '3223456789',
            'email' => 'estudiante@culturatibacuy.com',
            'direccion' => 'Avenida 67 # 89-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contacto_instructor2_id = DB::table('contactos')->insertGetId([
            'telefono' => '3334567890',
            'email' => 'instructor2@culturatibacuy.com',
            'direccion' => 'Diagonal 89 # 01-23',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contacto_estudiante2_id = DB::table('contactos')->insertGetId([
            'telefono' => '3445678901',
            'email' => 'estudiante2@culturatibacuy.com',
            'direccion' => 'Transversal 01 # 23-45',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear usuarios
        $admin_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Admin',
            'segundo_nombre' => 'Sistema',
            'primer_apellido' => 'Tibacuy',
            'segundo_apellido' => 'Cultural',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000001',
            'fecha_nacimiento' => '1990-01-01',
            'id_lugar_nacimiento' => $lugar_nacimiento_bogota_id,
            'id_genero' => $masculino_id,
            'id_rol' => $admin_id,
            'id_contacto' => $contacto_admin_id,
            'id_especialidad' => $administracion_id,
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructor_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Carlos',
            'segundo_nombre' => 'Andrés',
            'primer_apellido' => 'Martínez',
            'segundo_apellido' => 'López',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000002',
            'fecha_nacimiento' => '1985-05-15',
            'id_lugar_nacimiento' => $lugar_nacimiento_bogota_id,
            'id_genero' => $masculino_id,
            'id_rol' => $instructor_id,
            'id_contacto' => $contacto_instructor_id,
            'id_especialidad' => $musica_id,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructor2_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'María',
            'segundo_nombre' => 'Fernanda',
            'primer_apellido' => 'Gómez',
            'segundo_apellido' => 'Ramírez',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000004',
            'fecha_nacimiento' => '1988-08-10',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $femenino_id,
            'id_rol' => $instructor_id,
            'id_contacto' => $contacto_instructor2_id,
            'id_especialidad' => $danza_id,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudiante_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Laura',
            'segundo_nombre' => 'Sofía',
            'primer_apellido' => 'Rodríguez',
            'segundo_apellido' => 'García',
            'id_documento' => $ti_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000003',
            'fecha_nacimiento' => '2005-10-20',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $femenino_id,
            'id_rol' => $estudiante_id,
            'id_contacto' => $contacto_estudiante_id,
            'id_especialidad' => $danza_id,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $estudiante2_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Juan',
            'segundo_nombre' => 'David',
            'primer_apellido' => 'Torres',
            'segundo_apellido' => 'Muñoz',
            'id_documento' => $ti_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000005',
            'fecha_nacimiento' => '2007-03-25',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $masculino_id,
            'id_rol' => $estudiante_id,
            'id_contacto' => $contacto_estudiante2_id,
            'id_especialidad' => $musica_id,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Continuar con el resto de las tablas siguiendo el mismo patrón...
    }
}
