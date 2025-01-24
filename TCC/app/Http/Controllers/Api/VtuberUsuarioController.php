<?php

namespace App\Http\Controllers\Api;

use App\Models\Vtuber;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VtuberUsuarioController extends Controller
{
    // Criar ou atualizar avaliação
    public function store(Request $request, $usuarioId, $vtuberId)
    {
        $request->validate([
            'nota' => 'required|integer|min:1|max:10',
            'comentario' => 'nullable|string|max:255',
        ]);

        $usuario = Usuario::findOrFail($usuarioId);
        $vtuber = Vtuber::findOrFail($vtuberId);

        // Atribuir ou atualizar a avaliação, assim garantindo ligação única entre usuario e vtuber
        $usuario->vtubers()->syncWithoutDetaching([
            $vtuber->id => [
                'nota' => $request->nota,
                'comentario' => $request->comentario
            ]
        ]);

        return response()->json(['message' => 'Avaliação registrada com sucesso!'], 200);
    }

    // Remover avaliação
    public function destroy($usuarioId, $vtuberId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $vtuber = Vtuber::findOrFail($vtuberId);

        // Remover a avaliação da tabela pivot
        $usuario->vtubers()->detach($vtuber->id);

        return response()->json(['message' => 'Avaliação removida com sucesso!'], 200);
    }

    // Listar avaliações de um Vtuber
    public function showVtuberEvaluations($vtuberId)
    {
        $vtuber = Vtuber::with('usuarios')->findOrFail($vtuberId);
        return response()->json($vtuber->usuarios()->withPivot('nota', 'comentario')->get());
    }

    // Listar avaliações de um Usuario
    public function showUsuarioEvaluations($usuarioId)
    {
        $usuario = Usuario::with('vtubers')->findOrFail($usuarioId);
        return response()->json($usuario->vtubers()->withPivot('nota', 'comentario')->get());
    }
}
