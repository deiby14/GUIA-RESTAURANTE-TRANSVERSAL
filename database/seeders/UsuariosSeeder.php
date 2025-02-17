<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Crea un usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('qweQWE123'),
            'rol_id' => 1, // ID del rol admin
        ]);

        // Crea un usuario normal
        User::create([
            'name' => 'Kilian',
            'email' => 'kilian@gmail.com', // Corrección: gmail -> gmail
            'password' => Hash::make('qweQWE123'),
            'rol_id' => 2, // ID del rol user
        ]);
    }
}