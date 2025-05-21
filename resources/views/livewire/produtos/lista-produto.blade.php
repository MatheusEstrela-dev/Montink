<div class="space-y-4">
    <h1 class="text-white text-2xl mb-4">🎁 Lista de Produtos</h1>

    {{-- Campo de busca --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-4">
        <input type="text" wire:model.debounce.300ms="busca" placeholder="Procurar produtos..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none" />
    </div>

    {{-- Lista dos produtos --}}
    @forelse ($produtos as $produto)
        <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-2">
            <span class="text-gray-800 font-medium">{{ $produto->nome }}</span>
            <div class="flex gap-2">
                <button wire:click="confirmarExclusao({{ $produto->id }})" class="text-yellow-500 hover:text-yellow-600">✏️</button>
                <button wire:click="confirmarExclusao({{ $produto->id }})" class="text-red-500 hover:text-red-600">❌</button>
            </div>
        </div>
    @empty
        <div class="text-gray-500 italic">Nenhum produto encontrado.</div>
    @endforelse

    {{-- Modal de confirmação --}}
    @if ($confirmarExclusaoId)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg text-center">
                <p class="mb-4">Tem certeza que deseja excluir este produto?</p>
                <div class="flex justify-center gap-4">
                    <button wire:click="excluirProduto" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Sim</button>
                    <button wire:click="$set('confirmarExclusaoId', null)" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
                </div>
            </div>
        </div>
    @endif
</div>
