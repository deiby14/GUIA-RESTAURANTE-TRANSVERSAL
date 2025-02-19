<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurante;
use App\Models\Ciudad;
use App\Models\Tipocomida;

class RestaurantesSeeder extends Seeder
{
    public function run()
    {
        $restaurantes = [
            [
                'nombre' => 'La Macarena',
                'descripcion' => 'Auténtica cocina española con un ambiente acogedor y tradicional.',
                'dirección' => 'Calle Mayor 15',
                'precio_medio' => '$$',
                'ciudad_id' => Ciudad::where('nombre', 'Madrid')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Española')->first()->id,
            ],
            [
                'nombre' => 'Sakura Sushi',
                'descripcion' => 'El mejor sushi de la ciudad con pescado fresco diario.',
                'dirección' => 'Avenida del Puerto 45',
                'precio_medio' => '$$$',
                'ciudad_id' => Ciudad::where('nombre', 'Valencia')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Japonesa')->first()->id,
            ],
            [
                'nombre' => 'Bella Italia',
                'descripcion' => 'Pasta fresca y pizzas artesanales en un ambiente romántico.',
                'dirección' => 'Plaza Mayor 8',
                'precio_medio' => '$$',
                'ciudad_id' => Ciudad::where('nombre', 'Barcelona')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Italiana')->first()->id,
            ],
            [
                'nombre' => 'El Jalapeño',
                'descripcion' => 'Auténtica cocina mexicana con recetas tradicionales.',
                'dirección' => 'Calle del Sol 23',
                'precio_medio' => '$',
                'ciudad_id' => Ciudad::where('nombre', 'Sevilla')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Mexicana')->first()->id,
            ],
            [
                'nombre' => 'Taj Mahal',
                'descripcion' => 'Sabores de la India en un ambiente exótico.',
                'dirección' => 'Avenida Principal 67',
                'precio_medio' => '$$',
                'ciudad_id' => Ciudad::where('nombre', 'Madrid')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'India')->first()->id,
            ],
            [
                'nombre' => 'Dragón de Oro',
                'descripcion' => 'La mejor cocina china con ingredientes importados.',
                'dirección' => 'Calle Nueva 12',
                'precio_medio' => '$',
                'ciudad_id' => Ciudad::where('nombre', 'Barcelona')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'China')->first()->id,
            ],
            [
                'nombre' => 'El Mediterráneo',
                'descripcion' => 'Cocina mediterránea con productos frescos del mercado.',
                'dirección' => 'Paseo Marítimo 34',
                'precio_medio' => '$$$',
                'ciudad_id' => Ciudad::where('nombre', 'Valencia')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Mediterránea')->first()->id,
            ],
            [
                'nombre' => 'Casa Paco',
                'descripcion' => 'Tapas tradicionales españolas en ambiente familiar.',
                'dirección' => 'Plaza España 5',
                'precio_medio' => '$$',
                'ciudad_id' => Ciudad::where('nombre', 'Sevilla')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Española')->first()->id,
            ],
            [
                'nombre' => 'Little Italy',
                'descripcion' => 'Auténtica pizza napolitana y pasta casera.',
                'dirección' => 'Rambla Catalunya 89',
                'precio_medio' => '$$',
                'ciudad_id' => Ciudad::where('nombre', 'Barcelona')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Italiana')->first()->id,
            ],
            [
                'nombre' => 'Sushi Master',
                'descripcion' => 'Fusión japonesa moderna con toques creativos.',
                'dirección' => 'Gran Vía 123',
                'precio_medio' => '$$$$',
                'ciudad_id' => Ciudad::where('nombre', 'Madrid')->first()->id,
                'tipocomida_id' => Tipocomida::where('nombre', 'Japonesa')->first()->id,
            ],
        ];

        foreach ($restaurantes as $restaurante) {
            Restaurante::create($restaurante);
        }
    }
}