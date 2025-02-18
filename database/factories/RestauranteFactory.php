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
            'precio_medio' => '$' . str_repeat('$', $this->faker->numberBetween(1, 3)), // Genera precios como $$ o $$$
            'ciudad_id' => \App\Models\Ciudad::factory(),
            'tipocomida_id' => \App\Models\Tipocomida::factory(),

        ];
    }
}
