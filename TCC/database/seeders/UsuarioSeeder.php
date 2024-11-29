<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuários criados manualmente
        Usuario::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'admin_avatar.png',
        ]);

        Usuario::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'user_avatar.png',
        ]);

        // Criação de usuários adicionais via fábrica
        Usuario::factory(10)->create();
    }
}
