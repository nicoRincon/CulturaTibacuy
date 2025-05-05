<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CursoController;
use App\Http\Controllers\API\InscripcionController;
use App\Http\Controllers\API\EvaluacionController;
use App\Http\Controllers\API\ProgramaFormacionController;
use App\Http\Controllers\API\EscuelaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rutas para la API RESTful del sistema de gestión escolar
|
*/

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Perfil y logout
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Cursos
    Route::get('/cursos', [CursoController::class, 'index']);
    Route::get('/cursos/{id}', [CursoController::class, 'show']);
    Route::middleware('role:Administrador|Instructor')->group(function () {
        Route::post('/cursos', [CursoController::class, 'store']);
        Route::put('/cursos/{id}', [CursoController::class, 'update']);
        Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);
    });
    
    // Inscripciones
    Route::get('/inscripciones', [InscripcionController::class, 'index']);
    Route::post('/inscripciones', [InscripcionController::class, 'store']);
    Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy']);
    
    // Evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index']);
    Route::get('/evaluaciones/{id}', [EvaluacionController::class, 'show']);
    Route::middleware('role:Administrador|Instructor')->group(function () {
        Route::post('/evaluaciones', [EvaluacionController::class, 'store']);
        Route::put('/evaluaciones/{id}', [EvaluacionController::class, 'update']);
        Route::delete('/evaluaciones/{id}', [EvaluacionController::class, 'destroy']);
    });
    
    // Programas de formación
    Route::get('/programas', [ProgramaFormacionController::class, 'index']);
    Route::get('/programas/{id}', [ProgramaFormacionController::class, 'show']);
    Route::middleware('role:Administrador')->group(function () {
        Route::post('/programas', [ProgramaFormacionController::class, 'store']);
        Route::put('/programas/{id}', [ProgramaFormacionController::class, 'update']);
        Route::delete('/programas/{id}', [ProgramaFormacionController::class, 'destroy']);
    });
    
    // Escuelas
    Route::get('/escuelas', [EscuelaController::class, 'index']);
    Route::get('/escuelas/{id}', [EscuelaController::class, 'show']);
    Route::middleware('role:Administrador')->group(function () {
        Route::post('/escuelas', [EscuelaController::class, 'store']);
        Route::put('/escuelas/{id}', [EscuelaController::class, 'update']);
        Route::delete('/escuelas/{id}', [EscuelaController::class, 'destroy']);
    });
});