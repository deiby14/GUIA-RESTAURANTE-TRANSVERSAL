<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesTableSeeder::class,
            UsuariosTableSeeder::class,
        ]);

        // Cambiamos 'admin' por 1 que es el ID del rol admin
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'rol_id' => 1, // ID del rol admin (número, no string)
        ]);
    }
}
