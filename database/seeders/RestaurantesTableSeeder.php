<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurante::create([
            'nombre' => 'La Parrilla argenta',
            'descripcion' => 'Restaurante especializado en carnes a la parrilla',
            'direccion' => 'Calle Mayor 123, Barcelona',
            'precio_medio' => 25.50,
            'tipo_cocina' => 'Parrilla',
        ]);

        Restaurante::create([
            'nombre' => 'Sushi Master',
            'descripcion' => 'El mejor sushi de la ciudad con ingredientes unicos',
            'direccion' => 'Avenida del Mar 45, Barcelona',
            'precio_medio' => 30.00,
            'tipo_cocina' => 'Japonesa',
        ]);

        Restaurante::create([
            'nombre' => 'Pasta Bella di mundi',
            'descripcion' => 'Auténtica cocina italiana con pasta fresca hecha a mano',
            'direccion' => 'Plaza Italia 78, Valencia',
            'precio_medio' => 20.00,
            'tipo_cocina' => 'Italiana',
        ]);
    }
}
