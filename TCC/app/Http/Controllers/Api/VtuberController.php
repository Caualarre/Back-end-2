<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return new VtuberCollection(Vtuber::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
     $vtuber = $request->all();
    // $vtuber['name'] = $request->has('name');

     if (Vtuber::create($vtuber)) {
         return response()->json('Vtuber Criado!', 201);
     } else {
         return response()->json("Erro ao criar o vtuber", 500);
     }
}
    //public function store(VtuberStoreRequest $request)
   // {
    //    try {
      //      return new VtuberStoredResource(Vtuber::create($request->validated()));
      //  } catch (Exception $error) {
    //        //$this->errorHandler("Erro ao criar Vtuber!!",$error);
    //    }
   // }

    /**
     * Display the specified resource.
     */
    public function show(Vtuber $vtuber)
    {
        return new VtuberResource($vtuber);
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(UpdateVtuberRequest $request, Vtuber $vtuber){
        try{
            $validatedData = $request->validated();
            // dd($validatedData);
            $vtuber->update($validatedData);
            return response()->json(['message'=>'Vtuber atualizada com sucesso', 'data' =>$vtuber], 200);

        }catch(\Exception $error ) {
            return response()->json(['error'=> $error->getMessage()],500);
        }
     }





   // public function update(Request $request, Vtuber $vtuber)
    //{
   //     try {
      //      $vtuber->update($request->validated());
      //      return (new VtuberResource($vtuber))->additional(['message' => 'Vtuber atualizado com sucesso!!']);
      //  } catch (Exception $error) {
     //       return $this->errorHandler("Erro ao atualizar Vtuber!!", $error);
      //  }
   // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vtuber $vtuber)
    {
        {
            $vtuber->delete();
            return response()->json(['Vtuber deletada com sucesso'], 200);
        }
        //try {
          //  $vtuber->delete();
            //return (new VtuberResource($vtuber))->additional(["message" => "Vtuber removido!!!"]);
        //} catch (Exception $error) {
           // return $this->errorHandler("Erro ao remover Vtuber!!", $error);
        //}
    //}
}



}