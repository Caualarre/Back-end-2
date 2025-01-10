<?php

namespace Database\Seeders;

use App\Models\Vtuber;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class VtuberSeeder extends Seeder
{
    public function run(): void
    {
        $hololive = Empresa::where('nome', 'Hololive')->first();
        $nijisanji = Empresa::where('nome', 'Nijisanji')->first();

        Vtuber::create([
            'nome' => 'Gawr Gura',
            'empresa_id' => $hololive->id, 
            'descricao' => 'VTuber da Hololive, famosa por seu carisma e talento musical.',
            'imagem' => 'gawr_gura.png',
        ]);

        Vtuber::create([
            'nome' => 'Kizuna AI',
            'empresa_id' => $nijisanji->id, 
            'descricao' => 'Pioneira dos VTubers, conhecida por sua energia e simpatia.',
            'imagem' => 'kizuna_ai.png',
        ]);

        Vtuber::factory(6)->create();
    }
}


