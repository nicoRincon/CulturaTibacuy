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
        // Tabla de Países
        Schema::create('Pais', function (Blueprint $table) {
            $table->id('Id_Pais');
            $table->string('Pais', 50);
            $table->timestamps();
        });

        // Tabla de Departamentos
        Schema::create('Departamentos', function (Blueprint $table) {
            $table->id('Id_Dpto');
            $table->unsignedBigInteger('Id_Pais');
            $table->string('Departamento', 50);
            $table->timestamps();

            $table->foreign('Id_Pais')->references('Id_Pais')->on('Pais');
        });

        // Tabla de Municipios
        Schema::create('Municipios', function (Blueprint $table) {
            $table->id('Id_Mpio');
            $table->unsignedBigInteger('Id_Pais');
            $table->unsignedBigInteger('Id_Dpto');
            $table->string('Municipio', 50);
            $table->timestamps();

            $table->foreign('Id_Pais')->references('Id_Pais')->on('Pais');
            $table->foreign('Id_Dpto')->references('Id_Dpto')->on('Departamentos');
        });

        // Tabla de Lugar de Nacimiento
        Schema::create('Lugar_de_Nacimiento', function (Blueprint $table) {
            $table->id('Id_L_Nacimiento');
            $table->unsignedBigInteger('Id_Pais');
            $table->unsignedBigInteger('Id_Dpto');
            $table->unsignedBigInteger('Id_Mpio');
            $table->timestamps();

            $table->foreign('Id_Pais')->references('Id_Pais')->on('Pais');
            $table->foreign('Id_Dpto')->references('Id_Dpto')->on('Departamentos');
            $table->foreign('Id_Mpio')->references('Id_Mpio')->on('Municipios');
        });

        // Tabla de Documento de Identificación
        Schema::create('Documento_de_Identificacion', function (Blueprint $table) {
            $table->id('Id_Documento');
            $table->string('Tipo_Documento', 50);
            $table->timestamps();
        });

        // Tabla de Géneros
        Schema::create('Generos', function (Blueprint $table) {
            $table->id('Id_Genero');
            $table->string('Genero', 20);
            $table->timestamps();
        });

        // Tabla de Roles
        Schema::create('Roles', function (Blueprint $table) {
            $table->id('Id_Rol');
            $table->string('Rol', 50);
            $table->timestamps();
        });

        // Tabla de Contactos
        Schema::create('Contactos', function (Blueprint $table) {
            $table->id('Id_Contacto');
            $table->string('Telefono', 20);
            $table->string('Correo', 100)->unique();
            $table->string('Direccion', 150);
            $table->timestamps();
        });

        // Tabla de Especialidades
        Schema::create('Especialidades', function (Blueprint $table) {
            $table->id('Id_Especialidad');
            $table->string('Especialidad', 100);
            $table->timestamps();
        });

        // Tabla de Estados
        Schema::create('Estados', function (Blueprint $table) {
            $table->id('Id_Estado');
            $table->string('Estado', 50);
            $table->timestamps();
        });

        // Tabla de Usuarios
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id('Id_Usuario');
            $table->string('Primer_Nombre', 50);
            $table->string('Segundo_Nombre', 50)->nullable();
            $table->string('Primer_Apellido', 50);
            $table->string('Segundo_Apellido', 50)->nullable();
            $table->unsignedBigInteger('Id_Documento');
            $table->unsignedBigInteger('Id_Estado');
            $table->string('Num_Documento', 20)->unique();
            $table->date('Fecha_Nacimiento');
            $table->unsignedBigInteger('Id_L_Nacimiento');
            $table->unsignedBigInteger('Id_Genero');
            $table->unsignedBigInteger('Id_Rol');
            $table->unsignedBigInteger('Id_Contacto');
            $table->unsignedBigInteger('Id_Especialidad');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('Id_Documento')->references('Id_Documento')->on('Documento_de_Identificacion');
            $table->foreign('Id_Estado')->references('Id_Estado')->on('Estados');
            $table->foreign('Id_L_Nacimiento')->references('Id_L_Nacimiento')->on('Lugar_de_Nacimiento');
            $table->foreign('Id_Genero')->references('Id_Genero')->on('Generos');
            $table->foreign('Id_Rol')->references('Id_Rol')->on('Roles');
            $table->foreign('Id_Contacto')->references('Id_Contacto')->on('Contactos');
            $table->foreign('Id_Especialidad')->references('Id_Especialidad')->on('Especialidades');
        });

        // Tabla de Permisos
        Schema::create('Permisos', function (Blueprint $table) {
            $table->id('Id_Permiso');
            $table->string('Permiso', 100);
            $table->string('Descripcion', 255)->nullable();
            $table->timestamps();
        });

        // Tabla pivote Roles y Permisos
        Schema::create('Roles_Permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('Id_Rol');
            $table->unsignedBigInteger('Id_Permiso');
            $table->datetime('Fecha_Asignacion');
            $table->timestamps();

            $table->primary(['Id_Rol', 'Id_Permiso']);
            $table->foreign('Id_Rol')->references('Id_Rol')->on('Roles')->onDelete('cascade');
            $table->foreign('Id_Permiso')->references('Id_Permiso')->on('Permisos')->onDelete('cascade');
        });

        // Tabla de Recursos
        Schema::create('Recursos', function (Blueprint $table) {
            $table->id('Id_Recurso');
            $table->string('Recurso', 100);
            $table->timestamps();
        });

        // Tabla de Niveles
        Schema::create('Niveles', function (Blueprint $table) {
            $table->id('Id_Nivel');
            $table->string('Nivel', 50);
            $table->timestamps();
        });

        // Tabla de Horarios
        Schema::create('Horarios', function (Blueprint $table) {
            $table->id('Id_Horario');
            $table->string('Dia', 20);
            $table->time('Hora_Inicio');
            $table->time('Hora_Fin');
            $table->timestamps();
        });

        // Tabla de Cursos
        Schema::create('Cursos', function (Blueprint $table) {
            $table->id('Id_Curso');
            $table->string('Curso', 100);
            $table->unsignedBigInteger('Id_Recurso');
            $table->unsignedBigInteger('Id_Horario');
            $table->date('Fecha_Inicio');
            $table->date('Fecha_Fin');
            $table->string('Objetivo', 255);
            $table->unsignedBigInteger('Id_Nivel');
            $table->integer('Cupos');
            $table->integer('Cantidad_Alumnos')->default(0);
            $table->unsignedBigInteger('Id_Usuario'); // Instructor
            $table->timestamps();

            $table->foreign('Id_Recurso')->references('Id_Recurso')->on('Recursos');
            $table->foreign('Id_Horario')->references('Id_Horario')->on('Horarios');
            $table->foreign('Id_Nivel')->references('Id_Nivel')->on('Niveles');
            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
        });

        // Tabla de Inscripciones
        Schema::create('Inscripciones', function (Blueprint $table) {
            $table->id('Id_Inscripcion');
            $table->unsignedBigInteger('Id_Usuario');
            $table->unsignedBigInteger('Id_Curso');
            $table->date('Fecha_Inscripcion');
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
            $table->foreign('Id_Curso')->references('Id_Curso')->on('Cursos');
        });

        // Tabla de Evaluaciones
        Schema::create('Evaluaciones', function (Blueprint $table) {
            $table->id('Id_Evaluacion');
            $table->unsignedBigInteger('Id_Usuario');
            $table->unsignedBigInteger('Id_Curso');
            $table->date('Fecha_Evaluacion');
            $table->decimal('Nota', 5, 2);
            $table->string('Comentarios', 255)->nullable();
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
            $table->foreign('Id_Curso')->references('Id_Curso')->on('Cursos');
        });

        // Tabla de Nota Final
        Schema::create('Nota_Final', function (Blueprint $table) {
            $table->id('Id_Nota_Final');
            $table->unsignedBigInteger('Id_Usuario');
            $table->unsignedBigInteger('Id_Curso');
            $table->decimal('Nota_Final', 5, 2);
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
            $table->foreign('Id_Curso')->references('Id_Curso')->on('Cursos');
        });

        // Tabla de Escuelas
        Schema::create('Escuelas', function (Blueprint $table) {
            $table->id('Id_Escuela');
            $table->string('Nombre', 100);
            $table->string('Descripcion', 255)->nullable();
            $table->timestamps();
        });

        // Tabla de Tipos Escuela
        Schema::create('Tipos_Escuela', function (Blueprint $table) {
            $table->id('Id_Tipo_Escuela');
            $table->string('Tipos_Escuela', 100);
            $table->timestamps();
        });

        // Tabla de Ubicaciones
        Schema::create('Ubicaciones', function (Blueprint $table) {
            $table->id('Id_Ubicacion');
            $table->string('Ubicacion', 150);
            $table->timestamps();
        });

        // Tabla de Programa de Formación
        Schema::create('Programa_De_formacion', function (Blueprint $table) {
            $table->id('Id_Programa');
            $table->unsignedBigInteger('Id_Tipo_Escuela');
            $table->unsignedBigInteger('Id_Escuela');
            $table->unsignedBigInteger('Id_Ubicacion');
            $table->unsignedBigInteger('Id_Curso');
            $table->unsignedBigInteger('Id_Usuario');
            $table->timestamps();

            $table->foreign('Id_Tipo_Escuela')->references('Id_Tipo_Escuela')->on('Tipos_Escuela');
            $table->foreign('Id_Escuela')->references('Id_Escuela')->on('Escuelas');
            $table->foreign('Id_Ubicacion')->references('Id_Ubicacion')->on('Ubicaciones');
            $table->foreign('Id_Curso')->references('Id_Curso')->on('Cursos');
            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
        });

        // Tabla de Lista de Espera
        Schema::create('Lista_de_Espera', function (Blueprint $table) {
            $table->id('Id_Lista_Espera');
            $table->unsignedBigInteger('Id_Usuario');
            $table->unsignedBigInteger('Id_Curso');
            $table->date('Fecha_Solicitud');
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
            $table->foreign('Id_Curso')->references('Id_Curso')->on('Cursos');
        });

        // Tabla de Historial de Cambios
        Schema::create('Historial_de_Cambios', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Tabla', 50);
            $table->integer('Id_Registro');
            $table->string('Campo', 50);
            $table->string('Dato_Anterior', 255)->nullable();
            $table->string('Dato_Nuevo', 255)->nullable();
            $table->datetime('Fecha_Cambio');
            $table->unsignedBigInteger('Id_Usuario');
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
        });

        // Tabla de Seguridad
        Schema::create('Seguridad', function (Blueprint $table) {
            $table->id('Id');
            $table->unsignedBigInteger('Id_Usuario');
            $table->string('Accion', 100);
            $table->datetime('Fecha');
            $table->timestamps();

            $table->foreign('Id_Usuario')->references('Id_Usuario')->on('Usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar las tablas en orden inverso para evitar problemas de restricciones de clave foránea
        Schema::dropIfExists('Seguridad');
        Schema::dropIfExists('Historial_de_Cambios');
        Schema::dropIfExists('Lista_de_Espera');
        Schema::dropIfExists('Programa_De_formacion');
        Schema::dropIfExists('Ubicaciones');
        Schema::dropIfExists('Tipos_Escuela');
        Schema::dropIfExists('Escuelas');
        Schema::dropIfExists('Nota_Final');
        Schema::dropIfExists('Evaluaciones');
        Schema::dropIfExists('Inscripciones');
        Schema::dropIfExists('Cursos');
        Schema::dropIfExists('Horarios');
        Schema::dropIfExists('Niveles');
        Schema::dropIfExists('Recursos');
        Schema::dropIfExists('Roles_Permisos');
        Schema::dropIfExists('Permisos');
        Schema::dropIfExists('Usuarios');
        Schema::dropIfExists('Estados');
        Schema::dropIfExists('Especialidades');
        Schema::dropIfExists('Contactos');
        Schema::dropIfExists('Roles');
        Schema::dropIfExists('Generos');
        Schema::dropIfExists('Documento_de_Identificacion');
        Schema::dropIfExists('Lugar_de_Nacimiento');
        Schema::dropIfExists('Municipios');
        Schema::dropIfExists('Departamentos');
        Schema::dropIfExists('Pais');
    }
};