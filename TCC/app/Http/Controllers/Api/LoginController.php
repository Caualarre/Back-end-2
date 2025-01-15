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
        try {
            $user = $request->user(); // Obtém o usuário autenticado pelo token
            if ($user) {
                $user->tokens()->delete(); // Remove os tokens do usuário
                return response()->json(['message' => 'Logout realizado com sucesso']);
            }
    
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Erro ao realizar logout',
                'error' => $error->getMessage(),
                'trace' => $error->getTrace(),
            ], 500);
        }
    }
    
}