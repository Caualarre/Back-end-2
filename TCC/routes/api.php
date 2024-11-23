<?php

use App\Http\Controllers\Api\NotaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VtuberController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

Route::apiResource('vtubers', VtuberController::class);

Route::apiResource('notas', NotaController::class);

Route::apiResource('usuarios', UsuarioController::class);