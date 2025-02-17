<?php

namespace Database\Factories;

use App\Models\Valoracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValoracionFactory extends Factory
{
    public $model = Valoracion::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::all()->random()->id, // Selecciona un usuario existente aleatoriamente
            'restaurante_id' => \App\Models\Restaurante::all()->random()->id, 
            'puntuación' => $this->faker->numberBetween(1, 5), // Puntuación entre 1 y 5
            'comentario' => $this->faker->paragraph,
        ];
    }
}