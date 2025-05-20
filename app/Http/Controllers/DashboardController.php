<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $modulo = $request->query('modulo', 'pedidos'); // padrão: pedidos

        // Simula dados de cada módulo
        $dados = [
            'pedidos' => ['Fone Edifier', 'Monitor AOC', 'Mouse Razer', 'Teclado Redragon'],
            'produtos' => ['Cadeira Gamer', 'Gabinete ATX', 'Processador Ryzen'],
            'cupons' => ['CUPOM10', 'BLACKFRIDAY', 'WELCOME5'],
            'estoque' => ['Estoque Central', 'Filial RJ', 'Filial SP'],
            'usuarios' => ['Admin', 'Gerente', 'Vendedor']
        ];

        return view('dashboard.index', [
            'modulo' => $modulo,
            'itens' => $dados[$modulo] ?? []
        ]);
    }
}
