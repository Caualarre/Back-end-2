<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = Usuario::where('email', $this->email)->first();
            if(!$usuario || !Hash::check($this->password, $usuario->password))
                throw new Exception('Credenciais inválidas');
        $this->merge(['usuario'=>$usuario]);
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
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(){
        return [
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'password.required' => 'O campo senha é obrigatório',
            //'password.string' => 'O campo senha deve ser uma string',
        ];
    }
}
