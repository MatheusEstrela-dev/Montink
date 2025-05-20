@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detalhes do Produto</h2>

    <div class="bg-white p-6 rounded shadow">
        <p><strong>Nome:</strong> {{ $produto->nome }}</p>
        <p><strong>Descrição:</strong> {{ $produto->descricao }}</p>
        <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
        <p><strong>Categoria:</strong> {{ $produto->categoria }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('produtos.edit', $produto) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Editar</a>
        <a href="{{ route('produtos.index') }}" class="text-gray-600 hover:underline">Voltar</a>
    </div>
</div>
@endsection
