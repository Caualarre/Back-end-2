<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the notes.
     */
    public function index()
    {
    
        return response()->json(Nota::all(), 200);
    }

    /**
     * Store a newly created note.
     */
    public function store(Request $request)
    {
     
        $request->validate([
            'valor' => 'required|string|max:255',
        ]);

        
        $nota = Nota::create($request->all());

        return response()->json(['message' => 'Nota criada com sucesso!', 'data' => $nota], 201);
    }

    /**
     * Display the specified note.
     */
    public function show(Nota $nota)
    {
        
        return response()->json($nota, 200);
    }

    /**
     * Update the specified note.
     */
    public function update(Request $request, Nota $nota)
    {
     
        $request->validate([
            'valor' => 'nullable|string|max:255',
        ]);

  
        $nota->update($request->only(['valor']));

        return response()->json(['message' => 'Nota atualizada com sucesso!', 'data' => $nota], 200);
    }

    /**
     * Remove the specified note.
     */
    public function destroy(Nota $nota)
    {

        $nota->delete();

        return response()->json(['message' => 'Nota deletada com sucesso!'], 200);
    }
}
