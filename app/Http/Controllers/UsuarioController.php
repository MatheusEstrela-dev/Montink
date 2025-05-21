<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuarios.index', [
            'itens' => Usuario::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
        ]);

        Usuario::create($data);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
        ]);

        $usuario->update($data);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Usuario::destroy($id);

        return redirect()->back();
    }
}
