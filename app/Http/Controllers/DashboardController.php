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
            'pedidos' => Pedido::when($busca, fn($q) => $q->where('id', 'like', "%$busca%"))
                ->orderBy('id')->paginate(9),

            'produtos' => Produto::when($busca, fn($q) => $q->where('nome', 'ilike', "%$busca%"))
                ->orderBy('id')->paginate(5),

            'cupons' => Cupom::paginate(5),

            'estoques' => Estoque::with('produto')
                ->when($busca, fn($q) => $q->where('localizacao', 'ilike', "%$busca%"))
                ->orderBy('id')->paginate(5),

            'usuarios' => Usuario::paginate(5),
            'carrinho' => [],
            'cepmapa' => [],
        ];

        $itens = $dados[$modulo] ?? [];


        return view('dashboard.index', compact('modulo', 'itens'));
    }
}
