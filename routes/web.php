<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InicioAdminController;

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

// Rutas nuevas para registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);  

// Rutas protegidas para administración
Route::middleware(['auth'])->group(function () {
    Route::get('/inicio-admin', [InicioAdminController::class, 'index'])->name('inicio.admin');
    
    // Rutas para gestión de usuarios
    Route::get('/administrar', [AdminController::class, 'index'])->name('administrar');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Rutas para restaurantes
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
});


