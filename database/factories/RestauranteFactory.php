<?php

namespace Database\Factories;

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
            'direccion' => $this->faker->address,
            'precio_medio' => '$' . str_repeat('$', $this->faker->numberBetween(1, 3)), // Genera precios como $$ o $$$
            'tipo_cocina' => $this->faker->randomElement(['Italiana', 'Mexicana', 'Japonesa', 'Francesa', 'Española']),
        ];
    }
}