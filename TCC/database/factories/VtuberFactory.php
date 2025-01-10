<?php

namespace Database\Factories;

use App\Models\Vtuber;
use App\Models\Empresa; // Importando o modelo Empresa se for necessário
use Illuminate\Database\Eloquent\Factories\Factory;

class VtuberFactory extends Factory
{
    protected $model = Vtuber::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->text,
            'imagem' => 'images/avatars/' . $this->faker->word . '.jpg',
            'empresa_id' => Empresa::factory(), // Criando uma empresa associada ou usando um ID de empresa existente
        ];
    }
}
