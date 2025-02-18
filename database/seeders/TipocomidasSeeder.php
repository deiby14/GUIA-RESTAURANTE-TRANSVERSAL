<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipocomida;

class TipocomidasSeeder extends Seeder
{
    public function run()
    {
        $tiposComida = [
            'Italiana',
            'Japonesa',
            'Mexicana',
            'China',
            'Española',
            'India',
            'Mediterránea'
        ];

        foreach ($tiposComida as $tipo) {
            Tipocomida::create([
                'nombre' => $tipo
            ]);
        }
    }
}
///gvfggv