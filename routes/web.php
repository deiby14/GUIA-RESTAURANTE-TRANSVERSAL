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
use App\Http\Controllers\ValoracionController;


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
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');

// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas de administración
Route::get('/inicio-admin', [InicioAdminController::class, 'index'])->name('inicio.admin');
Route::get('/administrar', [AdminController::class, 'index'])->name('administrar');
Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/users', [AdminController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.delete');

// Rutas de restaurantes
Route::get('/administrar-restaurantes', [RestaurantesController::class, 'index'])->name('administrar.restaurantes');
Route::get('/restaurantes/create', [RestaurantesController::class, 'createRestaurante'])->name('restaurantes.create');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
Route::get('/restaurantes/{id}/edit', [RestaurantesController::class, 'editRestaurante'])->name('restaurantes.edit');
Route::put('/restaurantes/{id}', [RestaurantesController::class, 'updateRestaurante'])->name('restaurantes.update');
Route::delete('/restaurantes/{id}', [RestaurantesController::class, 'deleteRestaurante'])->name('restaurantes.delete');

Route::post('/restaurantes/rate', [RestauranteController::class, 'rate'])->name('restaurantes.rate');

Route::resource('restaurantes', RestauranteController::class);

Route::middleware(['auth'])->group(function () {
    Route::post('/restaurantes/{restaurante}/valoraciones', [ValoracionController::class, 'store'])->name('valoraciones.store');
    Route::put('/valoraciones/{valoracion}', [ValoracionController::class, 'update'])->name('valoraciones.update');
    Route::delete('/valoraciones/{valoracion}', [ValoracionController::class, 'destroy'])->name('valoraciones.destroy');
    Route::put('/valoraciones/{valoracion}/reset', [ValoracionController::class, 'reset'])->name('valoraciones.reset');
    Route::get('/administrar', [AdminController::class, 'index'])->name('administrar');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.delete');
    Route::get('/restaurantes/{restaurante}', [RestauranteController::class, 'show'])->name('restaurantes.show');
});