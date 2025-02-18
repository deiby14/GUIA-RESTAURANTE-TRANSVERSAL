<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InicioAdminController;
use App\Http\Controllers\RestaurantesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\FavoriteController;



// ✅ Ruta para la página de inicio
Route::get('/', function () {
    return view('home'); // Cambia 'home' por el nombre de tu vista 
})->name('home');

// ✅ Rutas de autenticación (Login / Register / Logout)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ✅ Ruta para el home después de iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ✅ Rutas de Restaurantes
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');
Route::post('/restaurantes/rate', [RestauranteController::class, 'rate'])->name('restaurantes.rate');

// ✅ Rutas de administración de restaurantes (CRUD)
Route::prefix('restaurantes')->group(function () {
    Route::get('/create', [RestaurantesController::class, 'createRestaurante'])->name('restaurantes.create');
    Route::post('/', [RestaurantesController::class, 'storeRestaurante'])->name('restaurantes.store');
    Route::get('/{id}/edit', [RestaurantesController::class, 'editRestaurante'])->name('restaurantes.edit');
    Route::put('/{id}', [RestaurantesController::class, 'updateRestaurante'])->name('restaurantes.update');
    Route::delete('/{id}', [RestaurantesController::class, 'deleteRestaurante'])->name('restaurantes.delete');
});

// ✅ Rutas de administración general
Route::get('/inicio-admin', [InicioAdminController::class, 'index'])->name('inicio.admin');
Route::get('/administrar', [AdminController::class, 'index'])->name('administrar');

// ✅ Rutas de gestión de usuarios (Admin)
Route::prefix('users')->group(function () {
    Route::get('/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/', [AdminController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('users.delete');
});

// ✅ Ruta para favoritos
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

// ✅ Ruta para la administración de restaurantes (vista general)
Route::get('/administrar-restaurantes', [RestaurantesController::class, 'index'])->name('administrar.restaurantes');

