<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoProduto;
use App\Models\Pedido;
use App\Models\Produto;

class PedidoProdutoController extends Controller
{
    // Listar itens de um pedido
    public function index($pedidoId)
    {
        $itens = PedidoProduto::with('produto')
            ->where('pedido_id', $pedidoId)
            ->get();

        return response()->json($itens);
    }

    // Adicionar item ao pedido
    public function store(Request $request)
    {
        $data = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::findOrFail($data['produto_id']);

        $data['preco_unitario'] = $produto->preco;

        $item = PedidoProduto::create($data);

        return response()->json($item->load('produto'), 201);
    }

    // Atualizar quantidade
    public function update(Request $request, $id)
    {
        $item = PedidoProduto::findOrFail($id);

        $data = $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $item->update($data);

        return response()->json($item);
    }

    // Remover item do pedido
    public function destroy($id)
    {
        $item = PedidoProduto::findOrFail($id);
        $item->delete();

        return response()->json(['mensagem' => 'Item removido com sucesso.']);
    }
}
