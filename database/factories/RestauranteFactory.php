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
            'nombre' => $this->faker->company,
            'descripcion' => $this->faker->paragraph,
            'dirección' => $this->faker->address,
            'precio_medio' => '$' . str_repeat('$', $this->faker->numberBetween(0, 3)), // Genera entre $ y $$$$
            'ciudad_id' => Ciudad::inRandomOrder()->first()->id,
            'tipocomida_id' => Tipocomida::inRandomOrder()->first()->id, // Cambiado aquí
        ];
    }
}