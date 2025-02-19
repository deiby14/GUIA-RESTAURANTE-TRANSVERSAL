<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\Foto;
use Illuminate\Database\Seeder;

class FotosSeeder extends Seeder
{
    public function run()
    {
        $fotos = [
            'La Macarena' => 'img/restaurante_1_0000.jpg',
            'Sakura Sushi' => 'img/restaurante_1_0001.jpg',
            'Bella Italia' => 'img/restaurante_1_0002.jpg',
            'El Jalapeño' => 'img/restaurante_1_0003.jpg',
            'Taj Mahal' => 'img/restaurante_1_0004.jpg',
            'Dragón de Oro' => 'img/restaurante_1_0005.jpg',
            'El Mediterráneo' => 'img/restaurante_1_0006.jpg',
            'Casa Paco' => 'img/restaurante_1_0007.jpg',
            'Little Italy' => 'img/restaurante_1_0008.jpg',
            'Sushi Master' => 'img/restaurante_1_0009.jpg',
        ];

        foreach ($fotos as $nombreRestaurante => $rutaFoto) {
            $restaurante = Restaurante::where('nombre', $nombreRestaurante)->first();
            if ($restaurante) {
                Foto::create([
                    'restaurante_id' => $restaurante->id,
                    'ruta_imagen' => $rutaFoto,
                ]);
            }
        }
    }
}