<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        return Produto::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
        ]);

        return Produto::create($data);
    }

    public function show($id)
    {
        $produto = Produto::with('estoque')->findOrFail($id);
        return view('produtos.show', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'preco' => 'required|numeric',
        ]);

        $produto->update($data);

        return response()->json($produto);
    }

    public function destroy($id)
    {
        Produto::findOrFail($id)->delete();

        return response()->json(['mensagem' => 'Produto deletado com sucesso.']);
    }
}
