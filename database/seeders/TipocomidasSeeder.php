<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipocomida;

class TipocomidasSeeder extends Seeder
{
    public function run()
    {
        // Crea 7 tipos de comida ficticios usando la fábrica
        Tipocomida::factory(7)->create();
    }
}