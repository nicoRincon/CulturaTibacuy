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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('id_curso');
            $table->string('curso', 100);
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_horario');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('objetivo', 255);
            $table->unsignedBigInteger('id_nivel');
            $table->integer('cupos');
            $table->integer('cantidad_alumnos')->default(0);
            $table->unsignedBigInteger('id_usuario'); // Instructor
            $table->timestamps();

            $table->foreign('id_recurso')->references('id_recurso')->on('recursos');
            $table->foreign('id_horario')->references('id_horario')->on('horarios');
            $table->foreign('id_nivel')->references('id_nivel')->on('niveles');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
