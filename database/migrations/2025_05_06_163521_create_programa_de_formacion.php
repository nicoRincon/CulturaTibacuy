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
        Schema::create('programa_de_formacion', function (Blueprint $table) {
            $table->id('id_programa');
            $table->unsignedBigInteger('id_tipo_escuela');
            $table->unsignedBigInteger('id_escuela');
            $table->unsignedBigInteger('id_ubicacion');
            $table->unsignedBigInteger('id_curso');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_tipo_escuela')->references('id_tipo_escuela')->on('tipos_escuela');
            $table->foreign('id_escuela')->references('id_escuela')->on('escuelas');
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('ubicaciones');
            $table->foreign('id_curso')->references('id_curso')->on('cursos');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_de_formacion');
    }
};
