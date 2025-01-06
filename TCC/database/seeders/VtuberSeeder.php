<?php

namespace Database\Seeders;

use App\Models\Vtuber;
use Illuminate\Database\Seeder;

class VtuberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vtuber::create([
            'nome' => 'Gawr Gura',
            'descricao' => 'VTuber da Hololive, famosa por seu carisma e talento musical.',
            'imagem' => 'gawr_gura.png',
        ]);

        Vtuber::create([
            'nome' => 'Calliope Mori',
            'descricao' => 'Uma VTuber reaper apaixonada por música e arte.',
            'imagem' => 'calliope_mori.png',
        ]);

        Vtuber::create([
            'nome' => 'Ironmouse',
            'descricao' => 'VTuber da VShojo conhecida por sua energia e humor.',
            'imagem' => 'ironmouse.png',
        ]);
    }
}
