<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Retorna todos os usuários.
     */
    public function index()
    {
        return response()->json(Usuario::all());
    }

    /**
     * Cadastra um novo usuário.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6',
        ]);

        $data['senha'] = bcrypt($data['senha']);

        $usuario = Usuario::create($data);

        return response()->json($usuario, 201);
    }

    /**
     * Mostra um usuário específico.
     */
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);

        return response()->json($usuario);
    }

    /**
     * Atualiza um usuário.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'senha' => 'nullable|string|min:6',
        ]);

        if (!empty($data['senha'])) {
            $data['senha'] = bcrypt($data['senha']);
        } else {
            unset($data['senha']);
        }

        $usuario->update($data);

        return response()->json($usuario);
    }

    /**
     * Remove um usuário.
     */
    public function destroy($id)
    {
        Usuario::destroy($id);

        return response()->json(['message' => 'Usuário removido com sucesso.']);
    }
}
