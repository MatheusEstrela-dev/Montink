<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6',
        ]);

        // criptografa a senha no mesmo campo 'senha'
        $data['senha'] = bcrypt($data['senha']);

        // garanta que no seu Model Usuario você tenha:
        // protected $fillable = ['nome','email','senha'];
        $user = Usuario::create($data);

        // devolve o JSON do usuário e status 201 (Created)
        return response()->json($user, 201);
    }

    public function show($id)
    {
        return Usuario::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'senha' => 'nullable|string|min:4',
        ]);

        if (!empty($data['senha'])) {
            $data['senha'] = bcrypt($data['senha']);
        } else {
            unset($data['senha']);
        }

        $usuario->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['success' => true]);
    }
}
