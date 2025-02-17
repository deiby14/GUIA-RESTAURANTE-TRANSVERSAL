<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crea roles ficticios
        Role::create(['name' => 'admin']); // Rol admin
        Role::create(['name' => 'user']);  // Rol user
    }
}