@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Conteúdo central --}}
    <main class="flex-1 p-8">
        <div class="max-w-xl mx-auto">

            {{-- Alerta de módulo atual --}}
            <div class="bg-red-200 text-red-800 text-sm text-center py-2 mb-4">
                Módulo atual: <strong>{{ $modulo }}</strong>
            </div>

            {{-- Renderização condicional para cada módulo --}}
            @if ($modulo === 'produtos')
                <livewire:produtos-lista-produto />

            @elseif ($modulo === 'carrinho')
                <h1 class="text-white text-2xl mb-4">🛒 Módulo do Carrinho</h1>
                <div class="bg-white p-4 rounded shadow text-gray-800">
                    [Conteúdo do carrinho será renderizado aqui]
                </div>

            @elseif ($modulo === 'cepmapa')
                @include('dashboard.cep')

            @else
                {{-- Módulos genéricos com barra de pesquisa --}}
                <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6">
                    <input type="text" placeholder="Procurar no módulo {{ ucfirst($modulo) }}..."
                        class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none" />
                    <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                </div>

                {{-- Lista de itens genérica --}}
                @foreach ($itens as $item)
                    <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-3">
                        <span class="text-gray-800">{{ $item }}</span>
                        <div class="flex gap-2">
                            <button class="text-yellow-500 hover:text-yellow-600">✏️</button>
                            <button class="text-red-500 hover:text-red-600">❌</button>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </main>
</div>
@endsection
