<?php
namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();  
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');  
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'localizacao' => 'nullable',
        ]);

       
        Empresa::create($validated);
        return redirect()->route('empresas.index');
    }

    public function show(Empresa $empresa)
    {
        return view('empresas.show', compact('empresa'));  
    }

    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));  
    }

    public function update(Request $request, Empresa $empresa)
    {
        
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'localizacao' => 'nullable',
        ]);

     
        $empresa->update($validated);
        return redirect()->route('empresas.index');
    }

    public function destroy(Empresa $empresa)
    {
       
        $empresa->delete();
        return redirect()->route('empresas.index');
    }
}
