<?php

namespace Database\Factories;

use App\Models\Foto;
use Illuminate\Database\Eloquent\Factories\Factory;

class FotoFactory extends Factory
{
    protected $model = Foto::class;

    public function definition()
    {
        return [
            'restaurante_id' => null,
            'ruta_imagen' => 'img/restaurante_' . $this->faker->numberBetween(1, 10) . '_' . $this->faker->randomNumber(4) . '.jpg',
        ];
    }
}

