@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Conteúdo central --}}
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-5xl mx-auto">

            {{-- Alerta do módulo ativo --}}
            <div class="bg-red-200 text-red-800 text-sm text-center py-2 mb-4 rounded shadow">
                Módulo atual: <strong>{{ ucfirst($modulo) }}</strong>
            </div>

            {{-- Renderização por módulo --}}
            @if ($modulo === 'produtos')
                {{-- Blade: Produtos --}}
                @include('produtos.index')

            @elseif ($modulo === 'carrinho')
                <h1 class="text-gray-800 text-2xl mb-4">🛒 Módulo do Carrinho</h1>
                <div class="bg-white p-4 rounded shadow text-gray-800">
                    [Conteúdo do carrinho será renderizado aqui]
                </div>

            @elseif ($modulo === 'cepmapa')
                {{-- Include para consulta de CEP --}}
                @include('dashboard.cep')

            @elseif ($modulo === 'usuarios')
                @include('usuarios.index')

            @elseif ($modulo === 'cupons')
                @include('cupom.cupons', ['cupons' => $itens])

            @elseif ($modulo === 'pedidos')
                @include('pedidos.index')

            @else
                {{-- Módulo genérico: renderiza itens recebidos --}}
                <div x-data="{ termo: '' }">
                    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6">
                        <input
                            x-model="termo"
                            type="text"
                            placeholder="Procurar no módulo {{ ucfirst($modulo) }}..."
                            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
                        />
                        <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                        </svg>
                    </div>

                    {{-- Renderizar lista filtrada --}}
                    <template x-for="item in {{ Js::from($itens) }}" :key="item.id ?? item">
                        <div
                            x-show="termo === '' || JSON.stringify(item).toLowerCase().includes(termo.toLowerCase())"
                            class="bg-white p-4 rounded shadow mb-3 text-gray-800"
                        >
                            <template x-if="'id' in item">
                                <div>
                                    <div class="flex justify-between items-center">
                                        <p>
                                            <strong x-text="'Pedido #' + item.id"></strong>
                                            - R$ <span x-text="Number(item.valor_total).toFixed(2).replace('.', ',')"></span>
                                        </p>
                                        <button @click="item.aberto = !item.aberto" class="text-blue-600 hover:underline text-sm">
                                            <span x-show="!item.aberto">Ver mais</span>
                                            <span x-show="item.aberto">Ver menos</span>
                                        </button>
                                    </div>
                                    <div x-show="item.aberto" class="mt-2 text-sm space-y-1" x-transition>
                                        <p><strong>Status:</strong> <span x-text="item.status"></span></p>
                                        <p><strong>Data:</strong> <span x-text="item.data_pedido"></span></p>
                                        <p><strong>Usuário ID:</strong> <span x-text="item.usuario_id"></span></p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!('id' in item)">
                                <span x-text="typeof item === 'object' ? JSON.stringify(item) : item"></span>
                            </template>
                        </div>
                    </template>
                </div>
            @endif

        </div>
    </main>
</div>
@endsection
