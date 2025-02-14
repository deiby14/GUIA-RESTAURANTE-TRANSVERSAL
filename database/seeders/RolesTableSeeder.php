<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'admin',
        ]);

        Role::create([
            'id' => 2,
            'name' => 'user',
        ]);
    }
}
