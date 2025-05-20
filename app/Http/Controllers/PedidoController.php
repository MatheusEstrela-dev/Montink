<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return Pedido::with(['usuario', 'cupom', 'pedidoProdutos'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'cupom_id' => 'nullable|exists:cupoms,id',
            'data_pedido' => 'required|date',
            'valor_total' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
        ]);

        return Pedido::create($data);
    }

    public function show($id)
    {
        return Pedido::with(['usuario', 'cupom', 'pedidoProdutos'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $data = $request->validate([
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'cupom_id' => 'nullable|exists:cupoms,id',
            'data_pedido' => 'sometimes|date',
            'valor_total' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|max:255',
        ]);

        $pedido->update($data);

        return $pedido;
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['mensagem' => 'Pedido removido com sucesso.']);
    }
}
