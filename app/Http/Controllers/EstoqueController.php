<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        return Estoque::with('produto')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:0',
            'localizacao' => 'nullable|string|max:255',
        ]);

        return Estoque::create($data);
    }

    public function show($id)
    {
        return Estoque::with('produto')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $estoque = Estoque::findOrFail($id);

        $data = $request->validate([
            'produto_id' => 'sometimes|exists:produtos,id',
            'quantidade' => 'sometimes|integer|min:0',
            'localizacao' => 'nullable|string|max:255',
        ]);

        $estoque->update($data);

        return $estoque;
    }

    public function destroy($id)
    {
        $estoque = Estoque::findOrFail($id);
        $estoque->delete();

        return response()->json(['mensagem' => 'Estoque removido com sucesso.']);
    }
}
