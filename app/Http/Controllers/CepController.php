<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function consultar($cep)
    {
        // 1) Busca no ViaCEP
        $resp = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        if ($resp->failed() || isset($resp['erro'])) {
            return response()->json(['erro' => 'CEP não encontrado'], 404);
        }

        $data = $resp->json();

        // 2) Monta string pra geocoding
        $endereco = trim("{$data['logradouro']}, {$data['bairro']}, {$data['localidade']}, {$data['uf']}, Brasil");

        // 3) Geocode via Nominatim (no back)
        $geo = Http::get('https://nominatim.openstreetmap.org/search', [
            'format' => 'json',
            'q'      => $endereco,
            'limit'  => 1,
        ]);

        if ($geo->ok() && count($geo->json()) > 0) {
            $place = $geo->json()[0];
            $data['lat'] = $place['lat'];
            $data['lon'] = $place['lon'];
        } else {
            // fallback: centro de Brasil
            $data['lat'] = -15.7801;
            $data['lon'] = -47.9292;
        }

        return response()->json($data);
    }
}
