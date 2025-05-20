@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detalhes do Produto</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
            <div>
                <strong>🆔 ID:</strong>
                <p>{{ $produto->id }}</p>
            </div>
            <div>
                <strong>📦 Nome:</strong>
                <p>{{ $produto->nome }}</p>
            </div>
            <div>
                <strong>💰 Preço:</strong>
                <p>R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            </div>
            <div>
                <strong>🏷️ Categoria:</strong>
                <p>{{ $produto->categoria }}</p>
            </div>
            <div class="col-span-1 sm:col-span-2">
                <strong>📝 Descrição:</strong>
                <p>{{ $produto->descricao }}</p>
            </div>
            <div class="col-span-1 sm:col-span-2">
                <strong>📦 Estoque:</strong>
                @if ($produto->estoque)
                    <p>{{ $produto->estoque->quantidade }} unidades ({{ $produto->estoque->localizacao }})</p>
                @else
                    <p class="text-red-500">Sem informação de estoque</p>
                @endif
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('            <?', $produto->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">✏️ Editar</a>
            <a href="{{ route('produtos.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">⬅️ Voltar</a>
        </div>
    </div>
@endsection
