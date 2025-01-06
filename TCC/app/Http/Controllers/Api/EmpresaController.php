<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Http\Requests\EmpresaStoreRequest;
use App\Http\Requests\EmpresaUpdateRequest;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Empresa::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpresaStoreRequest $request)
    {
        try {
            $empresa = Empresa::create($request->validated());
            return response()->json(['message' => 'Empresa criada com sucesso!', 'data' => $empresa], 201);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        return response()->json($empresa, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpresaUpdateRequest $request, Empresa $empresa)
    {
        try {
            $empresa->update($request->validated());
            return response()->json(['message' => 'Empresa atualizada com sucesso!', 'data' => $empresa], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        try {
            $empresa->delete();
            return response()->json(['message' => 'Empresa deletada com sucesso'], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
