<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Valoracion;

class ValoracionesSeeder extends Seeder
{
    public function run()
    {
        // Opcional: Limpiar la tabla valoraciones antes de sembrar
        \Illuminate\Support\Facades\DB::table('valoraciones')->truncate();

        // Crea 10 valoraciones ficticias usando la fábrica
        Valoracion::factory(10)->create();
    }
}