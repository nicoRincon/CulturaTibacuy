<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\EscuelaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformeController;



// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('web')->group(function () {
    Auth::routes();
});

// Ruta del Home y Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Rutas para Usuarios
Route::middleware(['auth'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::get('/departamentos/{id_pais}', [UsuarioController::class, 'getDepartamentos'])->name('departamentos');
    Route::get('/municipios/{id_dpto}', [UsuarioController::class, 'getMunicipios'])->name('municipios');
});

// Rutas para Cursos
Route::middleware(['auth'])->group(function () {
    Route::resource('cursos', CursoController::class);
});

// Rutas para Inscripciones
Route::middleware(['auth'])->group(function () {
    Route::resource('inscripciones', InscripcionController::class);
});

// Rutas para Evaluaciones
Route::middleware(['auth'])->group(function () {
    Route::resource('evaluaciones', EvaluacionController::class);
    Route::get('/estudiantes/{id_curso}', [EvaluacionController::class, 'getEstudiantes'])->name('estudiantes');
});

// Rutas para Programas de Formación
Route::middleware(['auth'])->group(function () {
    Route::resource('programas', ProgramaFormacionController::class);
});

// Rutas para Escuelas
Route::middleware(['auth'])->group(function () {
    Route::resource('escuelas', EscuelaController::class);
});

// Rutas para Informes
Route::middleware(['auth'])->prefix('informes')->group(function () {
    Route::get('/', [InformeController::class, 'index'])->name('informes.index');
    
    // Informes para Administradores e Instructores
    Route::middleware(['auth'])->group(function () {
        Route::post('/usuarios', [InformeController::class, 'usuariosInforme'])->name('informes.usuarios');
        Route::post('/cursos', [InformeController::class, 'cursosInforme'])->name('informes.cursos');
        Route::post('/inscripciones', [InformeController::class, 'inscripcionesInforme'])->name('informes.inscripciones');
        Route::post('/evaluaciones', [InformeController::class, 'evaluacionesInforme'])->name('informes.evaluaciones');
        Route::post('/programas', [InformeController::class, 'programasInforme'])->name('informes.programas');
    });
    
    // Informe para Estudiantes
    Route::middleware(['auth'])->group(function () {
        Route::get('/mi-informe', [InformeController::class, 'estudianteInforme'])->name('informes.estudiante');
        Route::get('/mi-informe-excel', [InformeController::class, 'estudianteInformeExcel'])->name('informes.estudiante.excel');
    });
});