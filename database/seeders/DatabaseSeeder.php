<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Iniciando el proceso de seeding...');
        
        // 1. Ejecutar datos básicos del sistema
        $this->command->info('=== CREANDO DATOS BÁSICOS DEL SISTEMA ===');
        $this->call(BasicDataSeeder::class);
        
        // 2. Crear SuperAdmin (tu seeder existente que ya funciona)
        $this->command->info('=== CREANDO SUPERADMIN ===');
        $this->call(SuperAdminSeeder::class);
        
        $this->command->info('');
        $this->command->info('✅ ¡Base de datos inicializada exitosamente!');
        $this->command->info('');
        $this->command->info('📧 Credenciales del SuperAdmin:');
        $this->command->info('   Email: superadmin@culturatibacuy.com');
        $this->command->info('   Documento: 1000000000');
        $this->command->info('   Contraseña: SuperAdmin123!');
        $this->command->info('');
        $this->command->info('💡 Para crear datos de ejemplo adicionales, puedes ejecutar:');
        $this->command->info('   php artisan db:seed --class=SampleDataSeeder');
    }
}