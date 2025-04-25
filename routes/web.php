<?php 
//es el encargado de recibir todas las peticiones de nuestra pagina web

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

route::get('/posts', function () {
    return "Aqui se veran todos los posts";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
