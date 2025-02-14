<?php

namespace Database\Seeders;

use App\Models\Foto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Foto::create([
            'restaurante_id' => 1,
            'ruta_imagen' => 'storage/images/restaurantes/asador.jpg'
        ]);

        Foto::create([
            'restaurante_id' => 1,
            'ruta_imagen' => 'storage/images/restaurantes/carnes.jpg'
        ]);

        
        Foto::create([
            'restaurante_id' => 2,
            'ruta_imagen' => 'storage/images/restaurantes/sitio-suhi.jpg'
        ]);
        Foto::create([
            'restaurante_id' => 2,
            'ruta_imagen' => 'storage/images/restaurantes/sushi.jpg'
        ]);

        Foto::create([
            'restaurante_id' => 3,
            'ruta_imagen' => 'storage/images/restaurantes/sitio-italiano.jpg'
        ]);
        Foto::create([
            'restaurante_id' => 3,
            'ruta_imagen' => 'storage/images/restaurantes/comida-italiana.jpg'
        ]);
    }
}
