@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Produto</h2>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="descricao" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">{{ old('descricao', $produto->descricao) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Preço</label>
            <input type="number" name="preco" step="0.01" value="{{ old('preco', $produto->preco) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Categoria</label>
            <input type="text" name="categoria" value="{{ old('categoria', $produto->categoria) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Atualizar
            </button>
            <a href="{{ route('produtos.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
