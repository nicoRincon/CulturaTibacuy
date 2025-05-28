<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BasicUsersSeeder extends Seeder
{
    /**
     * Crear usuarios básicos del sistema (Instructor y Estudiante).
     */
    public function run(): void
    {
        $this->command->info('👥 Creando usuarios básicos del sistema...');
        
        // Crear usuario Instructor
        $this->createInstructor();
        
        // Crear usuario Estudiante
        $this->createEstudiante();
        
        $this->command->info('✅ Usuarios básicos creados exitosamente!');
        $this->command->info('');
        $this->command->info('🔗 Credenciales de acceso:');
        $this->command->info('   📧 Instructor: instructor@culturatibacuy.com / instructor123');
        $this->command->info('   📧 Estudiante: estudiante@culturatibacuy.com / estudiante123');
    }

    private function createInstructor(): void
    {
        // Verificar si ya existe el instructor
        $existeInstructor = DB::table('usuarios')
            ->join('contactos', 'usuarios.id_contacto', '=', 'contactos.id_contacto')
            ->where('contactos.email', 'instructor@culturatibacuy.com')
            ->exists();

        if ($existeInstructor) {
            $this->command->info('El usuario Instructor ya existe en la base de datos.');
            return;
        }

        // Obtener IDs necesarios
        $colombia_id = $this->getOrCreatePais();
        $cundinamarca_id = $this->getOrCreateDepartamento($colombia_id);
        $tibacuy_id = $this->getOrCreateMunicipio($colombia_id, $cundinamarca_id, 'Tibacuy');
        $lugar_nacimiento_id = $this->getOrCreateLugarNacimiento($colombia_id, $cundinamarca_id, $tibacuy_id);
        
        $cedula_id = $this->getOrCreateDocumento();
        $masculino_id = $this->getOrCreateGenero('Masculino');
        $instructor_rol_id = $this->getOrCreateRolInstructor();
        $activo_id = $this->getOrCreateEstado();
        $musica_id = $this->getOrCreateEspecialidad('Música');
        
        // Crear contacto para el instructor
        $contacto_id = DB::table('contactos')->insertGetId([
            'telefono' => '3112345678',
            'email' => 'instructor@culturatibacuy.com',
            'direccion' => 'Centro Tibacuy - Cundinamarca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear el instructor
        DB::table('usuarios')->insert([
            'primer_nombre' => 'Carlos',
            'segundo_nombre' => 'Alberto',
            'primer_apellido' => 'Martínez',
            'segundo_apellido' => 'López',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000001',
            'fecha_nacimiento' => '1985-05-15',
            'id_lugar_nacimiento' => $lugar_nacimiento_id,
            'id_genero' => $masculino_id,
            'id_rol' => $instructor_rol_id,
            'id_contacto' => $contacto_id,
            'id_especialidad' => $musica_id,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Usuario Instructor creado exitosamente');
    }

    private function createEstudiante(): void
    {
        // Verificar si ya existe el estudiante
        $existeEstudiante = DB::table('usuarios')
            ->join('contactos', 'usuarios.id_contacto', '=', 'contactos.id_contacto')
            ->where('contactos.email', 'estudiante@culturatibacuy.com')
            ->exists();

        if ($existeEstudiante) {
            $this->command->info('El usuario Estudiante ya existe en la base de datos.');
            return;
        }

        // Obtener IDs necesarios
        $colombia_id = $this->getOrCreatePais();
        $cundinamarca_id = $this->getOrCreateDepartamento($colombia_id);
        $tibacuy_id = $this->getOrCreateMunicipio($colombia_id, $cundinamarca_id, 'Tibacuy');
        $lugar_nacimiento_id = $this->getOrCreateLugarNacimiento($colombia_id, $cundinamarca_id, $tibacuy_id);
        
        $cedula_id = $this->getOrCreateDocumento();
        $femenino_id = $this->getOrCreateGenero('Femenino');
        $estudiante_rol_id = $this->getOrCreateRolEstudiante();
        $activo_id = $this->getOrCreateEstado();
        $danza_id = $this->getOrCreateEspecialidad('Danza');
        
        // Crear contacto para el estudiante
        $contacto_id = DB::table('contactos')->insertGetId([
            'telefono' => '3223456789',
            'email' => 'estudiante@culturatibacuy.com',
            'direccion' => 'Vereda El Carmen - Tibacuy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear el estudiante
        DB::table('usuarios')->insert([
            'primer_nombre' => 'María',
            'segundo_nombre' => 'Fernanda',
            'primer_apellido' => 'García',
            'segundo_apellido' => 'Rodríguez',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000002',
            'fecha_nacimiento' => '2000-10-20',
            'id_lugar_nacimiento' => $lugar_nacimiento_id,
            'id_genero' => $femenino_id,
            'id_rol' => $estudiante_rol_id,
            'id_contacto' => $contacto_id,
            'id_especialidad' => $danza_id,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Usuario Estudiante creado exitosamente');
    }

    // Métodos auxiliares (reutilizando la lógica del SuperAdminSeeder)
    private function getOrCreatePais()
    {
        $pais = DB::table('pais')->where('pais', 'Colombia')->first();
        
        if (!$pais) {
            return DB::table('pais')->insertGetId([
                'pais' => 'Colombia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $pais->id_pais;
    }

    private function getOrCreateDepartamento($id_pais)
    {
        $departamento = DB::table('departamentos')
            ->where('departamento', 'Cundinamarca')
            ->where('id_pais', $id_pais)
            ->first();
        
        if (!$departamento) {
            return DB::table('departamentos')->insertGetId([
                'id_pais' => $id_pais,
                'departamento' => 'Cundinamarca',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $departamento->id_dpto;
    }

    private function getOrCreateMunicipio($id_pais, $id_dpto, $nombreMunicipio)
    {
        $municipio = DB::table('municipios')
            ->where('municipio', $nombreMunicipio)
            ->where('id_pais', $id_pais)
            ->where('id_dpto', $id_dpto)
            ->first();
        
        if (!$municipio) {
            return DB::table('municipios')->insertGetId([
                'id_pais' => $id_pais,
                'id_dpto' => $id_dpto,
                'municipio' => $nombreMunicipio,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $municipio->id_mpio;
    }

    private function getOrCreateLugarNacimiento($id_pais, $id_dpto, $id_mpio)
    {
        $lugar = DB::table('lugar_de_nacimiento')
            ->where('id_pais', $id_pais)
            ->where('id_dpto', $id_dpto)
            ->where('id_mpio', $id_mpio)
            ->first();
        
        if (!$lugar) {
            return DB::table('lugar_de_nacimiento')->insertGetId([
                'id_pais' => $id_pais,
                'id_dpto' => $id_dpto,
                'id_mpio' => $id_mpio,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $lugar->id_lugar_nacimiento;
    }

    private function getOrCreateDocumento()
    {
        $documento = DB::table('documento_de_identificacion')
            ->where('tipo_documento', 'Cédula de Ciudadanía')
            ->first();
        
        if (!$documento) {
            return DB::table('documento_de_identificacion')->insertGetId([
                'tipo_documento' => 'Cédula de Ciudadanía',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $documento->id_documento;
    }

    private function getOrCreateGenero($nombreGenero)
    {
        $genero = DB::table('generos')
            ->where('genero', $nombreGenero)
            ->first();
        
        if (!$genero) {
            return DB::table('generos')->insertGetId([
                'genero' => $nombreGenero,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $genero->id_genero;
    }

    private function getOrCreateRolInstructor()
    {
        $rol = DB::table('roles')
            ->where('rol', 'Instructor')
            ->first();
        
        if (!$rol) {
            return DB::table('roles')->insertGetId([
                'rol' => 'Instructor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $rol->id_rol;
    }

    private function getOrCreateRolEstudiante()
    {
        $rol = DB::table('roles')
            ->where('rol', 'Estudiante')
            ->first();
        
        if (!$rol) {
            return DB::table('roles')->insertGetId([
                'rol' => 'Estudiante',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $rol->id_rol;
    }

    private function getOrCreateEstado()
    {
        $estado = DB::table('estados')
            ->where('estado', 'Activo')
            ->first();
        
        if (!$estado) {
            return DB::table('estados')->insertGetId([
                'estado' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $estado->id_estado;
    }

    private function getOrCreateEspecialidad($nombreEspecialidad)
    {
        $especialidad = DB::table('especialidades')
            ->where('especialidad', $nombreEspecialidad)
            ->first();
        
        if (!$especialidad) {
            return DB::table('especialidades')->insertGetId([
                'especialidad' => $nombreEspecialidad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $especialidad->id_especialidad;
    }
}