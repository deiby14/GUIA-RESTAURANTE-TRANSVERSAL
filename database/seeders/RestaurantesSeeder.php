<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurante;

class RestaurantesSeeder extends Seeder
{
    public function run()
    {
        // Crea 20 restaurantes ficticios usando la fábrica
        Restaurante::factory(20)->create();
    }
}