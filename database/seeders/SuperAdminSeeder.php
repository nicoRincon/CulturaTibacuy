<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un superadmin
        $existeSuperAdmin = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id_rol')
            ->where('roles.rol', 'Administrador')
            ->where('usuarios.num_documento', '1000000000')
            ->exists();

        if ($existeSuperAdmin) {
            $this->command->info('El SuperAdmin ya existe en la base de datos.');
            return;
        }

        // Obtener IDs necesarios o crearlos si no existen
        $colombia_id = $this->getOrCreatePais();
        $cundinamarca_id = $this->getOrCreateDepartamento($colombia_id);
        $bogota_id = $this->getOrCreateMunicipio($colombia_id, $cundinamarca_id);
        $lugar_nacimiento_id = $this->getOrCreateLugarNacimiento($colombia_id, $cundinamarca_id, $bogota_id);
        
        $cedula_id = $this->getOrCreateDocumento();
        $masculino_id = $this->getOrCreateGenero();
        $admin_rol_id = $this->getOrCreateRolAdmin();
        $activo_id = $this->getOrCreateEstado();
        $administracion_id = $this->getOrCreateEspecialidad();
        
        // Crear contacto para el superadmin
        $contacto_id = DB::table('contactos')->insertGetId([
            'telefono' => '3001234567',
            'email' => 'superadmin@culturatibacuy.com',
            'direccion' => 'Administración Central - Tibacuy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear el superadmin
        $superadmin_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Super',
            'segundo_nombre' => 'Admin',
            'primer_apellido' => 'Sistema',
            'segundo_apellido' => 'Tibacuy',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000000',
            'fecha_nacimiento' => '1990-01-01',
            'id_lugar_nacimiento' => $lugar_nacimiento_id,
            'id_genero' => $masculino_id,
            'id_rol' => $admin_rol_id,
            'id_contacto' => $contacto_id,
            'id_especialidad' => $administracion_id,
            'password' => Hash::make('SuperAdmin123!'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('SuperAdmin creado exitosamente:');
        $this->command->info('- Email: superadmin@culturatibacuy.com');
        $this->command->info('- Documento: 1000000000');
        $this->command->info('- Contraseña: SuperAdmin123!');
    }

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

    private function getOrCreateMunicipio($id_pais, $id_dpto)
    {
        $municipio = DB::table('municipios')
            ->where('municipio', 'Tibacuy')
            ->where('id_pais', $id_pais)
            ->where('id_dpto', $id_dpto)
            ->first();
        
        if (!$municipio) {
            return DB::table('municipios')->insertGetId([
                'id_pais' => $id_pais,
                'id_dpto' => $id_dpto,
                'municipio' => 'Tibacuy',
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

    private function getOrCreateGenero()
    {
        $genero = DB::table('generos')
            ->where('genero', 'Masculino')
            ->first();
        
        if (!$genero) {
            return DB::table('generos')->insertGetId([
                'genero' => 'Masculino',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $genero->id_genero;
    }

    private function getOrCreateRolAdmin()
    {
        $rol = DB::table('roles')
            ->where('rol', 'Administrador')
            ->first();
        
        if (!$rol) {
            return DB::table('roles')->insertGetId([
                'rol' => 'Administrador',
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

    private function getOrCreateEspecialidad()
    {
        $especialidad = DB::table('especialidades')
            ->where('especialidad', 'Administración')
            ->first();
        
        if (!$especialidad) {
            return DB::table('especialidades')->insertGetId([
                'especialidad' => 'Administración',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return $especialidad->id_especialidad;
    }
}