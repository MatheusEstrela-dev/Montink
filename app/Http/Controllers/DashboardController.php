<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $modulo = $request->query('modulo', 'pedidos');

        $dados = [
            'pedidos' => ['Fone Edifier', 'Monitor AOC'],
            'produtos' => ['Gabinete Gamer', 'Cadeira'],
            'cupons' => ['CUPOM10', 'DESCONTO20'],
            'estoque' => ['Central', 'Filial SP'],
            'usuarios' => ['Admin', 'Usuário comum'],
            'carrinho' => [],
            'cepmapa' => [],
        ];

        // ✅ Define $itens de forma segura SEMPRE
        $itens = $dados[$modulo] ?? [];

        // ✅ Envia as variáveis para a view
        return view('dashboard.index', compact('modulo', 'itens'));
    }
}
