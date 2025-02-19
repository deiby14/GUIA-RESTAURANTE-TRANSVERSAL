<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Valoracion;
use App\Models\Restaurante;
use App\Models\User;

class ValoracionesSeeder extends Seeder
{
    public function run()
    {
        \DB::table('valoraciones')->truncate();

        $restaurantes = Restaurante::all();
        $users = User::all();

        foreach ($restaurantes as $restaurante) {
            // Crear entre 3 y 5 valoraciones por restaurante
            $numValoraciones = rand(3, 5);
            
            for ($i = 0; $i < $numValoraciones; $i++) {
                Valoracion::create([
                    'user_id' => $users->random()->id,
                    'restaurante_id' => $restaurante->id,
                    'puntuación' => rand(3, 5), // Puntuaciones entre 3 y 5 para que sean positivas
                    'comentario' => $this->getRandomComentario(),
                ]);
            }
        }
    }

    private function getRandomComentario()
    {
        $comentarios = [
            'Excelente servicio y comida deliciosa.',
            'Muy buena relación calidad-precio.',
            'El ambiente es muy agradable.',
            'La comida estaba muy bien preparada.',
            'Definitivamente volveré.',
            'Una experiencia gastronómica única.',
            'Muy recomendable.',
            'El servicio fue excepcional.',
            'Los platos son muy originales.',
            'La mejor experiencia culinaria en mucho tiempo.'
        ];

        return $comentarios[array_rand($comentarios)];
    }
}