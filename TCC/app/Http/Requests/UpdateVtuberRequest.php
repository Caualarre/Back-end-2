<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVtuberRequest extends FormRequest {

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'nome' => 'nullable|string|max:255',
            'empresa_id' => 'nullable|exists:empresas,id', // Verifica se o ID da empresa existe na tabela empresas
            'descricao' => 'nullable|string|max:255',
            'imagem' => 'nullable|string|max:255',
        ];
    }
}