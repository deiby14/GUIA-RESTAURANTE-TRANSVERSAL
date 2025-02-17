<?php

namespace Database\Factories;

use App\Models\Ciudad;
use Illuminate\Database\Eloquent\Factories\Factory;

class CiudadFactory extends Factory
{
    public $model = Ciudad::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->city, // Genera un nombre de ciudad ficticio
        ];
    }
}