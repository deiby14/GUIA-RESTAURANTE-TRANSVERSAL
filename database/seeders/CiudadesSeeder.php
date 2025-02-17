<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadesSeeder extends Seeder
{
    public function run()
    {
        // Crea 10 ciudades ficticias usando la fábrica
        Ciudad::factory(10)->create();
    }
}