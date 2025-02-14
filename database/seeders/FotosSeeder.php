<?php

use App\Models\Restaurante;
use App\Models\Foto;
use Illuminate\Database\Seeder;

class FotosSeeder extends Seeder
{
    public function run()
    {
        $restaurantes = Restaurante::all(); // Obtén todos los restaurantes

        foreach ($restaurantes as $restaurante) {
            // Asigna una foto aleatoria a cada restaurante
            Foto::create([
                'restaurante_id' => $restaurante->id,
                'ruta_imagen' => 'images/restaurantes/restaurante_' . rand(1, 10) . '_' . rand(1000, 9999) . '.jpg',
            ]);
        }
    }
}