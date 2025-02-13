<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\FavoriteController;

// Ruta para la página de bienvenida
Route::get('/', function () {
    return view('home'); // Cambia 'home' por el nombre de tu vista 
})->name('home');


// Ruta para mostrar el formulario de inicio de sesión
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el inicio de sesión
Route::post('login', [LoginController::class, 'login']);

// Ruta para cerrar sesión
Route::post('logout', [LoginController::class, 'logout'])->name('logout');  

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta para la lista de restaurantes
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');

// Ruta para la lista de favoritos
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
