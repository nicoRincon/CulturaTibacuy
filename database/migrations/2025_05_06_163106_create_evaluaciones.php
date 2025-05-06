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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_curso');
            $table->date('fecha_evaluacion');
            $table->decimal('nota', 5, 2);
            $table->string('comentarios', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_curso')->references('id_curso')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
