<?php

use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\NotaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VtuberController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

Route::apiResource('vtubers', VtuberController::class)
->middleware('auth:sanctum');//todas protegidas (post, put, delete)

Route::apiResource('vtubers', VtuberController::class)
->only(['index','show']);//sobreescreve a proteção de index e show

Route::apiResource('notas', NotaController::class)
->middleware('auth:sanctum');//todas protegidas 

Route::apiResource('notas', NotaController::class)
->only(['index', 'post', 'delete', 'show']); //sobreescreve a proteção de index, post, delete e show

Route::post('/usuarios', [UsuarioController::class, 'store']); // Permite o cadastro sem proteção
Route::apiResource('usuarios', UsuarioController::class)->except(['store'])
    ->middleware('auth:sanctum'); // Protege as demais operações


Route::post('/login', [LoginController::class, 'login']);

Route::apiResource('empresas', EmpresaController::class);