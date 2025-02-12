<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Importar el modelo Role

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'nombre' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Role::create([
            'nombre' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
