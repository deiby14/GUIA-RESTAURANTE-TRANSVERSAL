<?php

namespace Database\Factories;

use App\Models\Ciudad;
use App\Models\Tipocomida;
use App\Models\Restaurante;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestauranteFactory extends Factory
{
    protected $model = Restaurante::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company, // Nombre del restaurante
            'descripcion' => $this->faker->paragraph, // Descripción ficticia
            'dirección' => $this->faker->address, // Dirección ficticia
            'precio_medio' => $this->faker->randomFloat(2, 10, 100), // Precio medio entre 10 y 100
            'ciudad_id' => \App\Models\Ciudad::factory(),
            'tipocomida_id' => \App\Models\Tipocomida::factory(),
        ];
    }
}