@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Novo Item de Pedido</h2>

    <form action="{{ route('pedidoprodutos.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Pedido ID</label>
            <input type="number" name="pedido_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Produto ID</label>
            <input type="number" name="produto_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Quantidade</label>
            <input type="number" name="quantidade" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Preço Unitário</label>
            <input type="number" step="0.01" name="preco_unitario" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Salvar
            </button>
            <a href="{{ route('pedidoprodutos.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
