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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('id_mpio');
            $table->unsignedBigInteger('id_pais');
            $table->unsignedBigInteger('id_dpto');
            $table->string('municipio', 50);
            $table->timestamps();

            $table->foreign('id_pais')->references('id_pais')->on('pais');
            $table->foreign('id_dpto')->references('id_dpto')->on('departamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
