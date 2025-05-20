<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Illuminate\Http\Request;

class CupomController extends Controller
{
    public function index()
    {
        return Cupom::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|unique:cupoms,codigo|max:255',
            'tipo' => 'required|in:percentual,fixo',
            'valor' => 'required|numeric|min:0',
            'data_validade' => 'nullable|date',
            'ativo' => 'required|boolean',
        ]);

        return Cupom::create($data);
    }

    public function show($id)
    {
        return Cupom::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cupom = Cupom::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'sometimes|string|unique:cupoms,codigo,' . $id,
            'tipo' => 'sometimes|in:percentual,fixo',
            'valor' => 'sometimes|numeric|min:0',
            'data_validade' => 'nullable|date',
            'ativo' => 'sometimes|boolean',
        ]);

        $cupom->update($data);

        return $cupom;
    }

    public function destroy($id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->delete();

        return response()->json(['mensagem' => 'Cupom removido com sucesso.']);
    }
}
