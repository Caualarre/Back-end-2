<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company, // Nome da empresa gerado aleatoriamente
            'descricao' => $this->faker->text, // Descrição gerada aleatoriamente
        ];
    }
}
