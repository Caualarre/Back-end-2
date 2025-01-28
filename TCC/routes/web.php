<?php


use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

// Rota para listar as empresas (Index)
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');

// Rota para exibir o formulário de criação (Create)
Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');

// Rota para armazenar a nova empresa (Store)
Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');

// Rota para exibir uma empresa específica (Show)
Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');

// Rota para exibir o formulário de edição (Edit)
Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');

// Rota para atualizar os dados de uma empresa (Update)
Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');

// Rota para deletar uma empresa (Destroy)
Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
