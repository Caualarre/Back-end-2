<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VtuberStoreRequest extends FormRequest
{
    //classe criada com o comando: php artisan make:request ProdutoStoreRequest
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'empresa_id' => 'required|exists:empresas,id', 
            'descricao' => 'required|string|max:255',
            'imagem' => 'required|image',
        ];
    }

    protected function prepareForValidation(): void
    {
       // $this->merge([
          //  'name'=>$this->has('name')
        //]);
    }
}
