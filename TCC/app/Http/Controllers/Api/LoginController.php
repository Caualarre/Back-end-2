<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try{
            $usuario=$request->usuario;
            $token = $usuario->createToken($usuario)->plainTextToken;
            return compact('token');
        }catch(Exception $error){
            $this->errorHandler('Erro ao realizar login', $error, 401);
        }
    }

    public function logout(Request $request)
    {
        try{
            $request->usuario()->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso']);
        }catch(Exception $error){
            $this->errorHandler('Erro ao realizar logout', $error, 401);
        }
    }
}