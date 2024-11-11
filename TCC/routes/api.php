<?php

use App\Http\Controllers\Api\NotaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VtuberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('vtubers', VtuberController::class);
Route::apiResource('notas', NotaController::class);
Route::apiResource('users', UserController::class);