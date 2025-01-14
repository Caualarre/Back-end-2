<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateVtuberRequest;
use App\Http\Requests\VtuberStoreRequest;
use App\Http\Resources\VtuberStoredResource;
use App\Http\Resources\VtuberResource;
use App\Models\Vtuber;
use Illuminate\Http\Request;
use App\Http\Resources\VtuberCollection;

use Exception;
use Illuminate\Validation\ValidationException;

class VtuberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // Retorna todos os VTubers com suas médias calculadas sem carregar os usuários
        $vtubers = Vtuber::withCount(['usuarios as media_nota' => function (Builder $query) {
            $query->select(DB::raw('avg(usuario_vtuber.nota)'));
        }])->get();
    
        return response()->json($vtubers);
    }
    
    public function filtro(Request $request)
    {
        
        // Obtendo os filtros diretamente da query string
        $name = $request->query('nome');
        $empresa = $request->query('empresa_id');
        $media = $request->query('media');
        
        // Começa com a consulta base
        $query = Vtuber::query();
    
        // Aplicando os filtros dinamicamente
        if ($name) {
            $query->filterByName($name);
        }
    
        if ($empresa) {
            $query->filterByEmpresa($empresa);
        }
    
        if ($media) {
            $query->filterByMedia($media);
        }
    
        // Executa a consulta com filtros aplicados
        $vtubers = $query->get();
    
        return response()->json($vtubers);
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     */
   // public function store(Request $request)
   // {
        // Comentários existentes foram mantidos
     //   $vtuber = $request->all();
        // $vtuber['nome'] = $request->has('nome');
//
     //   if (Vtuber::create($vtuber)) {
       //     return response()->json('Vtuber Criado!', 201);
      //  } else {
      //      return response()->json("Erro ao criar o vtuber", 500);
      //  }
   // }


    public function store(VtuberStoreRequest $request)
{
    try {
        // Validação dos dados pela classe VtuberStoreRequest
        $validatedData = $request->validated();
        if($request->file('imagem')){
            $fileName = $request->file('imagem')->hashName();
            if(!$request->file('imagem')->store('vtubers', 'public'))
            throw new Exception('Erro ao salvar a imagem');
        $validatedData['imagem'] = $fileName;

        }

        // Criando o novo VTuber com os dados validados
        $vtuber = Vtuber::create($validatedData);

        return response()->json([
            'message' => 'Vtuber Criado!',
            'data' => $vtuber
        ], 201);
    } catch (Exception $error) {
        return response()->json([
            'error' => $error->getMessage()
        ], 500);
    }
}


    //public function store(VtuberStoreRequest $request)
    // {
    //    try {
    //        return new VtuberStoredResource(Vtuber::create($request->validated()));
    //    } catch (Exception $error) {
    //        //$this->errorHandler("Erro ao criar Vtuber!!",$error);
    //    }
    // }

    /**
     * Display the specified resource.
     */
    public function show(Vtuber $vtuber)
    {
        // Calcula a média das notas diretamente com uma subconsulta
        $vtuber->loadCount(['usuarios as media_nota' => function (Builder $query) {
            $query->select(DB::raw('avg(usuario_vtuber.nota)'));
        }]);
    
        return response()->json($vtuber);
    }
    
    


    /**
     * Update the specified resource in storage.
     */

    
    public function update(UpdateVtuberRequest $request, Vtuber $vtuber)
    
    {
        try {
            $validatedData = $request->validated();
            // dd($validatedData);
            $vtuber->update($validatedData);
            return response()->json(['message' => 'Vtuber atualizada com sucesso', 'data' => $vtuber], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
        /*
    public function update(UpdateVtuberRequest $request, Vtuber $vtuber)
    {
        try {
            // Validando os dados da requisição
            $validatedData = $request->validated();
    
            // Verificando se foi enviado um arquivo de imagem
            if ($request->file('imagem')) {
                // Excluindo a imagem antiga, se ela existir
                if ($vtuber->imagem && Storage::disk('public')->exists("vtubers/{$vtuber->imagem}")) {
                    Storage::disk('public')->delete("vtubers/{$vtuber->imagem}");
                }
    
                // Salvando a nova imagem
                $fileName = $request->file('imagem')->hashName();
                if (!$request->file('imagem')->store('vtubers', 'public')) {
                    throw new \Exception('Erro ao salvar a imagem');
                }
                $validatedData['imagem'] = $fileName;
            }
    
            // Atualizando os dados do VTuber
            $vtuber->update($validatedData);
    
            return response()->json([
                'message' => 'VTuber atualizado com sucesso!',
                'data' => new VtuberResource($vtuber),
            ], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
    */

    // public function update(Request $request, Vtuber $vtuber)
    //{
    //     try {
    //         $vtuber->update($request->validated());
    //         return (new VtuberResource($vtuber))->additional(['message' => 'Vtuber atualizado com sucesso!!']);
    //     } catch (Exception $error) {
    //         return $this->errorHandler("Erro ao atualizar Vtuber!!", $error);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vtuber $vtuber)
    {
        try {
            // Verifica se o VTuber existe
            if (!$vtuber) {
                return response()->json(['message' => 'Vtuber não encontrada'], 404);
            }
    
            // Exclui o VTuber
            $vtuber->delete();
    
            // Retorna sucesso
            return response()->json(['message' => 'Vtuber deletada com sucesso'], 200);
        } catch (Exception $error) {
            // Retorna erro de exceção
            return response()->json(['error' => 'Erro ao excluir o VTuber: ' . $error->getMessage()], 500);
        }
    }
    

        //try {
        //  $vtuber->delete();
        //return (new VtuberResource($vtuber))->additional(["message" => "Vtuber removido!!!"]);
        //} catch (Exception $error) {
        // return $this->errorHandler("Erro ao remover Vtuber!!", $error);
        //}
        //}

        
}
