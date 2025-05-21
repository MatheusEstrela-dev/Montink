<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        return view('estoques.index', [
            'itens' => Estoque::with('produto')->get(),
            'produtos' => Produto::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:0',
            'localizacao' => 'nullable|string|max:255',
        ]);

        Estoque::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $estoque = Estoque::findOrFail($id);

        $data = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:0',
            'localizacao' => 'nullable|string|max:255',
        ]);

        $estoque->update($data);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Estoque::destroy($id);
        return redirect()->back();
    }
}
