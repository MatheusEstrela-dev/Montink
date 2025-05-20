<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['erro' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'token' => $token,
            'tipo' => 'bearer',
            'expira_em' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['mensagem' => 'Logout realizado com sucesso']);
    }
}
