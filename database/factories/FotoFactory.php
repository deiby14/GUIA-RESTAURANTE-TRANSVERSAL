<?php

namespace Database\Factories;

use App\Models\Foto;
use App\Models\Restaurante;
use Illuminate\Database\Eloquent\Factories\Factory;

class FotoFactory extends Factory
{
    protected $model = Foto::class;

    public function definition()
    {
        // Obtener todos los restaurantes existentes
        $restaurantes = Restaurante::all();

        return [
            'restaurante_id' => $restaurantes->random()?->id, // Asigna un restaurante aleatorio
            'ruta_imagen' => 'img/restaurante_1_'. str_pad(rand(0, 9), 4, '0', STR_PAD_LEFT) . '.jpg', // Ruta de la imagen
        ];
    }
}