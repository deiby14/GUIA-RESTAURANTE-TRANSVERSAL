<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('qweQWE123'),
            'rol_id' => 1, // ID del rol admin
        ]);

        User::create([
            'name' => 'Kilian',
            'email' => 'kilian@gamil.com',
            'password' => Hash::make('qweQWE123'),
            'rol_id' => 2, // ID del rol user
        ]);
    }
}
