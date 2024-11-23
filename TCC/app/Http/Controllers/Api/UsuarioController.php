<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return new UsuarioCollection(Usuario::all());
    }

    public function store(UsuarioStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']); 

        if (Usuario::create($data)) {
            return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
        }

        return response()->json(['error' => 'Erro ao criar usuário.'], 500);
    }

    public function show(Usuario $usuario)
    {
        return new UsuarioResource($usuario);
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        try {
            $data = $request->validated();

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $usuario->update($data);

            return response()->json(['message' => 'Usuário atualizado com sucesso!', 'data' => $usuario], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso!'], 200);
    }
}

