<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Cupom;
use App\Models\Estoque;
use App\Models\Usuario;
use App\Http\Controllers\CartController;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $modulo = $request->query('modulo', 'pedidos');
        $busca  = $request->query('busca');

        // Dados dos demais módulos
        $dados = [
            'pedidos'  => Pedido::when($busca, fn($q) => $q->where('id', 'like', "%{$busca}%"))
                ->orderBy('id')->paginate(10),

            'produtos' => Produto::when($busca, fn($q) => $q->where('nome', 'ilike', "%{$busca}%"))
                ->orderBy('id')->paginate(5),

            'cupons'   => Cupom::paginate(5),

            'estoques' => Estoque::with('produto')
                ->when($busca, fn($q) => $q->where('localizacao', 'ilike', "%{$busca}%"))
                ->orderBy('id')->paginate(6),

            'usuarios' => Usuario::paginate(5),

            // não usamos aqui para carrinho: será tratado abaixo
            'cepmapa'  => [],
        ];

        // produtos para os selects de criar/update
        $todosProdutos = Produto::select('id', 'nome')
            ->orderBy('nome')
            ->get();

        // Módulo padrão: itens vindos do paginator
        $itens = $dados[$modulo] ?? [];

        // Se estiver no carrinho, refazemos tudo via CartController
        if ($modulo === 'carrinho') {
            // pega do session('cart') e transforma com a sua lógica
            $cartData = (new \App\Http\Controllers\CartController)->transformCart();

            return view('dashboard.index', [
                'modulo'        => $modulo,
                'itens'         => $cartData['items'],
                'todosProdutos' => $todosProdutos,
            ])->with($cartData); // isso vai criar as variáveis $items, $subtotal, $frete e $total na view
        }

        // para os demais módulos
        return view('dashboard.index', compact('modulo', 'itens', 'todosProdutos'));
    }
}
