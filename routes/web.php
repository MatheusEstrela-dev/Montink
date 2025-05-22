<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoProdutoController;
use App\Http\Controllers\CepController;

// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas por sessão
Route::middleware(['web'])->group(function () {

    // Dashboard principal com Livewire renderizando dentro
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Consulta CEP
    Route::get('/consulta-cep/{cep}', [CepController::class, 'consultar']);

    // Recursos tradicionais
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('estoques', EstoqueController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::resource('cupoms', CupomController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('produtos', ProdutoController::class);

    // Rota customizada para listar produtos de um pedido específico
    Route::get('/pedido-produtos/pedido/{pedidoId}', [PedidoProdutoController::class, 'index'])->name('pedido-produtos.por-pedido');

    // Resource limitado para adicionar, atualizar e remover produtos de pedidos
    Route::resource('pedido-produtos', PedidoProdutoController::class)->only(['store', 'update', 'destroy']);
});
