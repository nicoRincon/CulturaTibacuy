<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Este seeder ejecuta todos los seeders básicos necesarios
     * para el funcionamiento del sistema en el orden correcto.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando la creación de datos básicos del sistema...');

        // 1. Datos geográficos (base para lugares de nacimiento)
        $this->command->info('📍 Creando ubicaciones geográficas...');
        $this->call(UbicacionesGeograficasSeeder::class);

        // 2. Documentos de identificación
        $this->command->info('📄 Creando tipos de documentos de identificación...');
        $this->call(DocumentoIdentificacionSeeder::class);

        // 3. Géneros
        $this->command->info('👥 Creando géneros...');
        $this->call(GeneroSeeder::class);

        // 4. Estados de usuario
        $this->command->info('🔄 Creando estados de usuario...');
        $this->call(EstadosSeeder::class);

        // 5. Especialidades
        $this->command->info('🎨 Creando especialidades...');
        $this->call(EspecialidadesSeeder::class);

        // 6. Roles del sistema
        $this->command->info('👑 Creando roles del sistema...');
        $this->call(RolesSeeder::class);

        // 7. Permisos del sistema
        $this->command->info('🔐 Creando permisos del sistema...');
        $this->call(PermisosSeeder::class);

        // 8. Asignación de permisos a roles
        $this->command->info('🔗 Asignando permisos a roles...');
        $this->call(RolesPermisosSeeder::class);

        // 9. Recursos académicos (salones, horarios, niveles)
        $this->command->info('🏫 Creando recursos académicos...');
        $this->call(RecursosAcademicosSeeder::class);

        // 10. Escuelas y programas
        $this->command->info('🎓 Creando escuelas y programas...');
        $this->call(EscuelasProgramasSeeder::class);

        $this->command->info('✅ ¡Datos básicos del sistema creados exitosamente!');
        $this->command->info('');
        $this->command->info('📊 Resumen de datos creados:');
        $this->command->info('   • Ubicaciones geográficas (países, departamentos, municipios)');
        $this->command->info('   • Tipos de documentos de identificación');
        $this->command->info('   • Géneros y estados de usuario');
        $this->command->info('   • Especialidades culturales y artísticas');
        $this->command->info('   • Sistema de roles y permisos');
        $this->command->info('   • Recursos académicos (espacios, horarios, niveles)');
        $this->command->info('   • Escuelas de formación y tipos de programa');
        $this->command->info('');
        $this->command->info('🔧 Para crear usuarios de prueba, ejecuta: php artisan db:seed --class=DatabaseSeeder');
    }
}