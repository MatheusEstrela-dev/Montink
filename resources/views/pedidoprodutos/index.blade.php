@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Itens de Pedido</h2>

    <a href="{{ route('pedidoprodutos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-4 inline-block">
        Novo Item
    </a>

    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Pedido ID</th>
                <th class="px-4 py-2">Produto ID</th>
                <th class="px-4 py-2">Qtd</th>
                <th class="px-4 py-2">Preço Unit.</th>
                <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidoprodutos as $item)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $item->id }}</td>
                    <td class="px-4 py-2">{{ $item->pedido_id }}</td>
                    <td class="px-4 py-2">{{ $item->produto_id }}</td>
                    <td class="px-4 py-2">{{ $item->quantidade }}</td>
                    <td class="px-4 py-2">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('pedidoprodutos.edit', $item) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('pedidoprodutos.destroy', $item) }}" method="POST" onsubmit="return confirm('Deseja excluir?')">
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
        {{ $pedidoprodutos->links() }}
    </div>
</div>
@endsection
