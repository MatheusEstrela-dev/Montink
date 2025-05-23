<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::firstOrCreate(
            ['email' => 'admin@montink.com'],
            [
                'nome' => 'Admin',
                'senha' => bcrypt('montink'),
                'tipo' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
