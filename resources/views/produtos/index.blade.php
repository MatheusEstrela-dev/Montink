<div class="space-y-3">
    <h1 class="text-gray-800 text-xl font-bold mb-4">📦 Lista de Produtos</h1>

    {{-- Campo de busca visual (não funcional ainda) --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-4">
        <input type="text" placeholder="Procurar produtos..."
               class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none" />
        <span class="ml-2 text-gray-500 text-xl">🔍</span>
    </div>

    {{-- Lista de produtos --}}
    @forelse ($itens as $produto)
        <div class="flex justify-between items-center bg-white p-4 rounded shadow">
            <span class="text-gray-800 font-medium">{{ $produto->nome }}</span>
        </div>
    @empty
        <div class="text-gray-500 italic">Nenhum produto encontrado.</div>
    @endforelse
</div>
