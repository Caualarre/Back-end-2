<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Vtuber;
use Illuminate\Database\Seeder;

class UsuarioVtuberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pegando os usuários e vtubers que já foram criados nas seeders anteriores
        $usuarios = Usuario::all(); // Pegando todos os usuários criados
        $vtubers = Vtuber::all(); // Pegando todos os vtubers criados

        // Criando as associações entre usuários e vtubers
        foreach ($usuarios as $usuario) {
            foreach ($vtubers as $vtuber) {
                $usuario->vtubers()->attach($vtuber->id, [
                    'nota' => rand(1, 5), 
                    'comentario' => 'Comentário de teste ' . $vtuber->nome
                ]);
            }
        }
    }
}


