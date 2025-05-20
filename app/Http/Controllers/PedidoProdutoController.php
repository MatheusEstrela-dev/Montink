<?php

namespace App\Http\Controllers;

use App\Models\PedidoProduto;
use Illuminate\Http\Request;

class PedidoProdutoController extends Controller
{
    public function index()
    {
        return PedidoProduto::with(['pedido', 'produto'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'preco_unitario' => 'required|numeric|min:0',
        ]);

        return PedidoProduto::create($data);
    }

    public function show($id)
    {
        return PedidoProduto::with(['pedido', 'produto'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = PedidoProduto::findOrFail($id);

        $data = $request->validate([
            'pedido_id' => 'sometimes|exists:pedidos,id',
            'produto_id' => 'sometimes|exists:produtos,id',
            'quantidade' => 'sometimes|integer|min:1',
            'preco_unitario' => 'sometimes|numeric|min:0',
        ]);

        $registro->update($data);

        return $registro;
    }

    public function destroy($id)
    {
        $registro = PedidoProduto::findOrFail($id);
        $registro->delete();

        return response()->json(['mensagem' => 'Item do pedido removido com sucesso.']);
    }
}
