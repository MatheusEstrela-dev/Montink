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
        $busca = $request->query('busca');

        $dados = [
            'pedidos' => \App\Models\Pedido::when($busca, fn($q) => $q->where('id', 'like', "%$busca%"))
                ->orderBy('id', 'asc')
                ->paginate(9),
            'produtos' => ['Gabinete Gamer', 'Cadeira'],
            'cupons' => \App\Models\Cupom::all(),
            'estoque' => \App\Models\Estoque::all(),
            'usuarios' => \App\Models\Usuario::all(),
            'carrinho' => [],
            'cepmapa' => [],
        ];

        $itens = $dados[$modulo] ?? [];

        return view('dashboard.index', compact('modulo', 'itens'));
    }
}
