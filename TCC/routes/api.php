<?php

use App\Http\Controllers\Api\EmpresaController;
//use App\Http\Controllers\Api\NotaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VtuberController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\VtuberUsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

Route::apiResource('vtubers', VtuberController::class)
->middleware('auth:sanctum');//todas protegidas (post, put, delete)



// Definindo o recurso de vtubers
Route::apiResource('vtubers', VtuberController::class)
->only(['index','show']);//sobreescreve a proteção de index e show

Route::get('vtubers-filtro', [VtuberController::class, 'filtro']);
//Route::get('/vtubers', [VtuberController::class, 'filtro']);

//Route::apiResource('notas', NotaController::class)
//->middleware('auth:sanctum');//todas protegidas 

//Route::apiResource('notas', NotaController::class)
//->only(['index', 'post', 'delete', 'show']); //sobreescreve a proteção de index, post, delete e show

Route::post('/usuarios', [UsuarioController::class, 'store']); // Permite o cadastro sem proteção
Route::apiResource('usuarios', UsuarioController::class)->except(['store'])
    ->middleware('auth:sanctum'); // Protege as demais operações


Route::post('/login', [LoginController::class, 'login']);

Route::apiResource('empresas', EmpresaController::class);

// Rota para criar ou atualizar uma avaliação de um Vtuber por um Usuário
Route::post('/usuarios/{usuarioId}/vtubers/{vtuberId}', [VtuberUsuarioController::class, 'store'])
    ->middleware('auth:sanctum');

// Rota para remover a avaliação de um Vtuber por um Usuário
Route::delete('/usuarios/{usuarioId}/vtubers/{vtuberId}', [VtuberUsuarioController::class, 'destroy'])
    ->middleware('auth:sanctum');

// Rota para listar avaliações de um Vtuber
Route::get('/vtubers/{vtuberId}/avaliacoes', [VtuberUsuarioController::class, 'showVtuberEvaluations']);

// Rota para listar avaliações de um Usuário
Route::get('/usuarios/{usuarioId}/avaliacoes', [VtuberUsuarioController::class, 'showUsuarioEvaluations']);

Route::get('/usuarios/{usuarioId}/avaliacoes', [VtuberUsuarioController::class, 'showUsuarioEvaluations']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});
