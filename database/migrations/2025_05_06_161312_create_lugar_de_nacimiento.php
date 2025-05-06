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
        Schema::create('lugar_de_nacimiento', function (Blueprint $table) {
            $table->id('id_lugar_nacimiento');
            $table->unsignedBigInteger('id_pais');
            $table->unsignedBigInteger('id_dpto');
            $table->unsignedBigInteger('id_mpio');
            $table->timestamps();

            $table->foreign('id_pais')->references('id_pais')->on('pais');
            $table->foreign('id_dpto')->references('id_dpto')->on('departamentos');
            $table->foreign('id_mpio')->references('id_mpio')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lugar_de_nacimiento');
    }
};
