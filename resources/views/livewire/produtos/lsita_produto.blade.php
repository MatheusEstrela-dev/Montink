<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Produtos Cadastrados</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lista de produtos --}}
    <div class="space-y-2">
        @forelse($produtos as $produto)
            <div class="flex justify-between items-center bg-gray-800 text-white px-4 py-3 rounded shadow">
                <div>
                    <p class="font-semibold text-lg">{{ $produto->nome }}</p>
                    <p class="text-sm text-gray-300">R$ {{ number_format($produto->preco, 2, ',', '.') }} | {{ $produto->categoria }}</p>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="editar({{ $produto->id }})" class="text-yellow-400 hover:text-yellow-300">
                        ✏️
                    </button>
                    <button wire:click="excluir({{ $produto->id }})" class="text-red-400 hover:text-red-300">
                        ❌
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-400">Nenhum produto cadastrado ainda.</p>
        @endforelse
    </div>
</div>
