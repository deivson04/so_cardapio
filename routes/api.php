<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);




// -------------------------------------------------------------------------
// GRUPO DE ROTAS PROTEGIDAS PELO SANCTUM
// -------------------------------------------------------------------------
// Todas as rotas abaixo só funcionarão se houver um usuário autenticado.
// Adicionamos o 'can:admin' para o seu caso específico.
Route::middleware(['auth:sanctum'])->group(function () {

    // Rotas de Usuário Autenticado (Protegidas)
    // Para obter o usuário logado e fazer logout.
    Route::get('/user', [MainController::class, 'user']);
    Route::post('/logout', [MainController::class, 'logout']);



    Route::get('/usuarios', [MainController::class, 'index']);
    Route::post('/inserir', [MainController::class, 'store']);
    Route::get('/usuarios/buscar/{id}', [MainController::class, 'show']);
    Route::put('/usuarios/atualizar/{id}', [MainController::class, 'update']);
    Route::delete('/usuarios/remover/{id}', [MainController::class, 'destroy']);

});  


