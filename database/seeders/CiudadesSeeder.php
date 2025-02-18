<?php

namespace Database\Seeders;

use App\Models\Ciudad;
use Illuminate\Database\Seeder;

class CiudadesSeeder extends Seeder
{
    public function run()
    {
        $ciudades = [
            'Madrid',
            'Barcelona',
            'Valencia',
            'Sevilla',
            'Bilbao'
        ];

        foreach ($ciudades as $nombreCiudad) {
            Ciudad::create([
                'nombre' => $nombreCiudad
            ]);
        }
    }
}