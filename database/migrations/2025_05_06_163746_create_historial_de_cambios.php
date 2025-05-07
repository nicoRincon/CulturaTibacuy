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
        Schema::create('historial_de_cambios', function (Blueprint $table) {
            $table->id('id_historial');
            $table->string('tabla', 50);
            $table->integer('id_registro');
            $table->string('campo', 50);
            $table->string('dato_anterior', 255)->nullable();
            $table->string('dato_nuevo', 255)->nullable();
            $table->datetime('fecha_cambio');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_de_cambios');
    }
};
