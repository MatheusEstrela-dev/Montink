<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Estoque;

class CarrinhoController extends Controller
{
    public function adicionar(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
        ]);

        $produto = Produto::findOrFail($data['produto_id']);
        $estoque = Estoque::where('produto_id', $produto->id)->first();

        // pega o carrinho da sessão (product_id => detalhes)
        $cart = session()->get('cart', []);

        $quantNoCarrinho = data_get($cart, "{$produto->id}.quantidade", 0);

        // checa estoque
        if ($estoque && $quantNoCarrinho + 1 > $estoque->quantidade) {
            return response()->json([
                'error' => 'Não há estoque suficiente para esse produto.'
            ], 400);
        }

        // incrementa ou adiciona
        if (isset($cart[$produto->id])) {
            $cart[$produto->id]['quantidade']++;
            $cart[$produto->id]['subtotal'] = $cart[$produto->id]['quantidade'] * $produto->preco;
        } else {
            $cart[$produto->id] = [
                'produto_id' => $produto->id,
                'nome'       => $produto->nome,
                'preco'      => $produto->preco,
                'quantidade' => 1,
                'subtotal'   => $produto->preco,
            ];
        }

        // salva de volta na sessão
        session()->put('cart', $cart);

        // recalcula totais
        $subtotal = array_sum(array_column($cart, 'subtotal'));
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15;
        } elseif ($subtotal > 200) {
            $frete = 0;
        } else {
            $frete = 20;
        }
        $total = $subtotal + $frete;

        return response()->json([
            'cart'     => array_values($cart),
            'subtotal' => number_format($subtotal, 2, ',', '.'),
            'frete'    => number_format($frete,    2, ',', '.'),
            'total'    => number_format($total,    2, ',', '.'),
        ]);
    }
}
