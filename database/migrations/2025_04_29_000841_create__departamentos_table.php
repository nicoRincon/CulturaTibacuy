<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id('Id_Dpto'); // Campo Id_Dpto como clave primaria
            $table->unsignedBigInteger('Id_País'); // Llave foránea a la tabla País
            $table->string('Departamento', 50); // Nombre del departamento con un máximo de 50 caracteres

            // Definición de la llave foránea
            $table->foreign('Id_País')->references('Id_País')->on('pais')->onDelete('cascade');

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}