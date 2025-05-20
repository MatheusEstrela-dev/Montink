<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoProdutoController;
use App\Http\Livewire\Produtos\Index;

// Tela de login (sessão tradicional)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Grupo protegido por sessão (autenticado)
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('usuarios', UsuarioController::class);
    // Route::resource('produtos', ProdutoController::class);
    Route::resource('estoques', EstoqueController::class);
    Route::resource('cupoms', CupomController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('pedido-produtos', PedidoProdutoController::class);
});

// Rota Livewire para Produtos
Route::middleware(['auth'])->group(function () {
    Route::get('/produtos', Index::class)->name('produtos.index');
});
