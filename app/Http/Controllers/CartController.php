<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CartController extends Controller
{
    // … adicionar(), atualizar(), remover() ficam iguais

    /**
     * Transforma o carrinho da sessão num payload com
     * items[], subtotal, frete e total
     */
    public function transformCart(): array
    {
        $cart = session()->get('cart', []);
        $items = [];

        foreach ($cart as $key => $entry) {
            // 1) se for o formato novo ['id'=>…, 'quantidade'=>…]
            if (is_array($entry) && isset($entry['id'])) {
                $id        = (int)$entry['id'];
                $quantity  = (int)($entry['quantidade'] ?? 1);

                // 2) se for o formato antigo [ produto_id => quantidade ]
            } elseif (is_numeric($key)) {
                $id       = (int)$key;
                $quantity = is_numeric($entry) ? (int)$entry : 1;

                // 3) se for só uma lista de IDs [ 0=>id1, 1=>id2 … ]
            } else {
                $id       = (int)$entry;
                $quantity = 1;
            }

            // só inclui se o produto existir
            if (! $prod = Produto::find($id)) {
                continue;
            }

            $subtotal = $prod->preco * $quantity;
            $items[]  = [
                'produto'   => $prod,
                'quantidade' => $quantity,
                'subtotal'  => $subtotal,
            ];
        }

        $subtotal = array_sum(array_column($items, 'subtotal'));

        // regra de frete
        if ($subtotal >= 200) {
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
}
