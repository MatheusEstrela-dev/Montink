@extends('layouts.app')
@livewireStyles
@section('content')
<div class="bg-gradient-to-r from-blue-100 to-indigo-100 py-12 shadow-inner">
    <div class="max-w-6xl mx-auto text-center px-4">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-3">
            Bem-vindo ao <span class="text-blue-700">Montink ERP</span>
        </h1>
        <p class="text-lg text-gray-700">Painel administrativo com acesso rápido aos módulos principais</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @php
            $cards = [
                ['icon' => '📦', 'title' => 'Produtos', 'desc' => 'Gerencie o catálogo e preços.'],
                ['icon' => '📊', 'title' => 'Estoques', 'desc' => 'Controle de localização e quantidades.'],
                ['icon' => '📝', 'title' => 'Pedidos', 'desc' => 'Acompanhe status e entregas.'],
                ['icon' => '🎟', 'title' => 'Cupons', 'desc' => 'Configure códigos promocionais.'],
                ['icon' => '👤', 'title' => 'Usuários', 'desc' => 'Gerencie permissões e perfis.'],
                ['icon' => '⚙️', 'title' => 'Configurações', 'desc' => 'Ajustes do sistema.'],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg border-t-4 border-indigo-400 transition-all duration-200 hover:-translate-y-1">
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-3xl mb-4 shadow-inner mx-auto">
                {{ $card['icon'] }}
            </div>
            <h2 class="text-center text-xl font-bold text-indigo-700">{{ $card['title'] }}</h2>
            <p class="text-center text-sm text-gray-600 mt-2">{{ $card['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

@endsection
@livewireStyles
