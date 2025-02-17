<?php

namespace Database\Factories;

use App\Models\Tipocomida;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipocomidaFactory extends Factory
{
    protected $model = Tipocomida::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->randomElement(['Italiana', 'Mexicana', 'Japonesa', 'Francesa', 'Española', 'India', 'Tailandesa']), 
        ];
    }
}