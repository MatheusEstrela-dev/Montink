<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        $itens = Estoque::with('produto')->paginate(5);
        return view('estoques.index', compact('itens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id'  => 'required|exists:produtos,id',
            'quantidade'  => 'required|integer|min:0',
            'localizacao' => 'nullable|string|max:255',
        ]);

        $estoque = Estoque::create($data);
        return response()->json($estoque->load('produto'));
    }

    public function update(Request $request, Estoque $estoque)
    {
        $data = $request->validate([
            'quantidade'  => 'sometimes|integer|min:0',
            'localizacao' => 'sometimes|string|max:255',
        ]);

        $estoque->update($data);
        return response()->json($estoque->load('produto'));
    }

    public function destroy(Estoque $estoque)
    {
        $estoque->delete();
        return response()->json(['deleted' => true]);
    }
}
