@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Lista de Produtos</h2>
        <a href="{{ route('produtos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Novo Produto
        </a>
    </div>

    <form method="GET" action="{{ route('produtos.index') }}" class="mb-6 flex gap-2">
        <input type="text" name="buscar" value="{{ request('buscar') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" placeholder="Buscar por nome ou categoria">
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">Buscar</button>
    </form>

    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">Categoria</th>
                <th class="px-4 py-2">Preço</th>
                <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $produto->id }}</td>
                    <td class="px-4 py-2">{{ $produto->nome }}</td>
                    <td class="px-4 py-2">{{ $produto->categoria }}</td>
                    <td class="px-4 py-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('produtos.show', $produto) }}" class="text-indigo-600 hover:underline">Ver</a>
                        <a href="{{ route('produtos.edit', $produto) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('produtos.destroy', $produto) }}" method="POST" onsubmit="return confirm('Deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $produtos->appends(['buscar' => request('buscar')])->links() }}
    </div>
</div>
@endsection
