<?php

namespace Database\Seeders;

use App\Models\Foto;
use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llama a otros seeders en el orden correcto
        $this->call([
            RolesSeeder::class,       // Crea roles primero
            UsuariosSeeder::class,   // Crea usuarios después de roles
            CiudadesSeeder::class,   // Crea ciudades
            TipocomidasSeeder::class, // Crea tipos de comida
            RestaurantesSeeder::class, // Crea restaurantes
            ValoracionesSeeder::class, // Crea valoraciones después de restaurantes
        ]);

    }
}

