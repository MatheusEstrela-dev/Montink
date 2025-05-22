<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        $itens = Estoque::with('produto')->paginate(10);
        return view('estoques.index', compact('itens'));
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
}
