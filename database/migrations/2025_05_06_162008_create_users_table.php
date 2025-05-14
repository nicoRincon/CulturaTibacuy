<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->unsignedBigInteger('id_documento');
            $table->unsignedBigInteger('id_estado');
            $table->string('num_documento', 20)->unique();
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('id_lugar_nacimiento');
            $table->unsignedBigInteger('id_genero');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_contacto');
            $table->unsignedBigInteger('id_especialidad');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_documento')->references('id_documento')->on('documento_de_identificacion');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
            $table->foreign('id_lugar_nacimiento')->references('id_lugar_nacimiento')->on('lugar_de_nacimiento');
            $table->foreign('id_genero')->references('id_genero')->on('generos');
            $table->foreign('id_rol')->references('id_rol')->on('roles');
            $table->foreign('id_contacto')->references('id_contacto')->on('contactos');
            $table->foreign('id_especialidad')->references('id_especialidad')->on('especialidades');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};