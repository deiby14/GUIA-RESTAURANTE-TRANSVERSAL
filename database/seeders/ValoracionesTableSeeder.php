<?php

namespace Database\Seeders;

use App\Models\Valoracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValoracionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Valoracion::create([
            'user_id' => 15, // ID del usuario admin
            'restaurante_id' => 1, // ID del primer restaurante
            'puntuación' => 4.5,
            'comentario' => 'Excelente servicio y comida deliciosa',
        ]);

        Valoracion::create([
            'user_id' => 15, // ID del usuario normal
            'restaurante_id' => 1, // ID del primer restaurante
            'puntuación' => 4.0,
            'comentario' => 'Muy buena experiencia, repetiré',
        ]);

        Valoracion::create([
            'user_id' => 15, // ID del usuario admin
            'restaurante_id' => 2, // ID del segundo restaurante
            'puntuación' => 3.5,
            'comentario' => 'Buena comida pero el servicio puede mejorar',
        ]);

        Valoracion::create([
            'user_id' => 15, // ID del usuario normal
            'restaurante_id' => 3, // ID del tercer restaurante
            'puntuación' => 5.0,
            'comentario' => '¡Increíble! La mejor pasta que he probado y la mejor experiencia',
        ]);
    }
}
