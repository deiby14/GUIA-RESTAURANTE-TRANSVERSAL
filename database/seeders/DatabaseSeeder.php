<?php

namespace Database\Seeders;

use App\Models\Restaurante; 
use App\Models\Foto;        
use App\Models\User;        
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama a otros seeders si es necesario
        $this->call([
            RolesTableSeeder::class,
            UsuariosTableSeeder::class,
            RestaurantesTableSeeder::class,
            ValoracionesTableSeeder::class,
            FotosTableSeeder::class,
        ]);

        Restaurante::factory(50)->create()->each(function ($restaurante) {
            Foto::factory(rand(1, 3))->create(['restaurante_id' => $restaurante->id]);
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'rol_id' => 1, // ID del rol admin (número, no string)
        ]);
    }
}