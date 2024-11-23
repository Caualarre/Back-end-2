<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVtuberRequest extends FormRequest {

    public function authorize(){
        return true;
    }

    public function rules(){
        return[
              'name' =>'nullable | string|max:255',
              'empresa' =>'nullable | string|max:255',
              'descricao' =>'nullable| string|max:255',
              'imagem' =>'nullable | string | max:255',
        ];
    }
}