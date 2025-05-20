<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function consultar($cep)
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful() && !$response->json('erro')) {
            return response()->json($response->json());
        }

        return response()->json(['erro' => 'CEP inválido'], 400);
    }
}
