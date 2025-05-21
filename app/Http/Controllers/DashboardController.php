<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Cupom;
use App\Models\Estoque;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $modulo = $request->query('modulo', 'pedidos');

        // Dados reais vindos do banco
        $dados = [
            'pedidos' => Pedido::all(),
            'produtos' => ['Gabinete Gamer', 'Cadeira'],
            'cupons' => Cupom::all(),
            'estoque' => Estoque::all(),
            'usuarios' => Usuario::all(), // ou Usuario::all()
            'carrinho' => [], // pode vir de sessão no futuro
            'cepmapa' => [],  // CEP usa lógica própria
        ];

        $itens = $dados[$modulo] ?? [];

        return view('dashboard.index', compact('modulo', 'itens'));
    }
}
