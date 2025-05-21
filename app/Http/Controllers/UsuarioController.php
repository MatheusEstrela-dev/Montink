<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

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
            'senha' => 'nullable|string|min:4',
        ]);

        // Criptografa a senha se fornecida
        if (!empty($data['senha'])) {
            $data['senha'] = Hash::make($data['senha']);
        } else {
            unset($data['senha']); // Evita sobrescrever com NULL
        }

        $usuario->update($data);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Usuario::destroy($id);

        return redirect()->back();
    }
}
