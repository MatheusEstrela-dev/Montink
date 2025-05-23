<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CartController extends Controller
{
    public function transformCart(): array
    {
        $cart = session()->get('cart', []);
        $items = [];

        // Cada entrada do carrinho está armazenada com a chave sendo o ID do produto
        foreach ($cart as $produtoId => $entry) {
            $quantity = isset($entry['quantidade']) ? (int) $entry['quantidade'] : 1;

            $product = Produto::find($produtoId);
            if (! $product) {
                continue;
            }

            $subtotalItem = $product->preco * $quantity;
            $items[] = [
                'produto'   => $product,
                'quantidade'=> $quantity,
                'subtotal'  => $subtotalItem,
            ];
        }

        // Cálculo do subtotal geral
        $subtotal = array_sum(array_column($items, 'subtotal'));

        // Regras de frete conforme faixa de valor
        if ($subtotal > 200) {
            $frete = 0;
        } elseif ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        return [
            'items'    => $items,
            'subtotal' => $subtotal,
            'frete'    => $frete,
            'total'    => $subtotal + $frete,
        ];
    }

    public function adicionar(Request $request)
    {
        try {
            $produtoId = $request->input('produto_id');
            $quantidade = max(1, (int) $request->input('quantidade', 1));

            $produto = Produto::findOrFail($produtoId);

            $cart = session()->get('cart', []);

            if (isset($cart[$produtoId])) {
                $cart[$produtoId]['quantidade'] += $quantidade;
            } else {
                $cart[$produtoId] = [
                    'produto_id'  => $produtoId,
                    'nome'        => $produto->nome,
                    'preco'       => (float) $produto->preco,
                    'quantidade'  => $quantidade,
                ];
            }

            session()->put('cart', $cart);

            return back()->with('success', "{$produto->nome} adicionado ao carrinho.");
        } catch (\Exception $e) {
            return back()->withErrors('Erro ao adicionar ao carrinho: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $dados = $this->transformCart();
        return view('carrinho.index', $dados);
    }
}
