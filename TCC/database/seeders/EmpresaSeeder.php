<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        Empresa::create([
            'nome' => 'Hololive',
            'descricao' => 'Agência de VTubers focada em criar conteúdo diversificado.',
            'localizacao' => 'Japão',
        ]);

        Empresa::create([
            'nome' => 'Nijisanji',
            'descricao' => 'Uma das maiores agências de VTubers do mundo.',
            'localizacao' => 'Japão',
        ]);

        Empresa::create([
            'nome' => 'VShojo',
            'descricao' => 'Agência de VTubers popular nos Estados Unidos.',
            'localizacao' => 'Estados Unidos',
        ]);
    }
}

