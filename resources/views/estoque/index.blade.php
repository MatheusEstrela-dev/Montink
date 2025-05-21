{{-- resources/views/estoques/index.blade.php --}}
<div x-data="{ termo: '', editando: null }">
    <h1 class="text-2xl font-bold text-blue-800 mb-6 flex items-center gap-2">
        📦 Lista de Estoques
    </h1>

    {{-- Formulário de criação --}}
    <form method="POST" action="{{ route('estoques.store') }}" class="mb-6 bg-white p-4 rounded shadow max-w-3xl">
        @csrf
        <div class="grid grid-cols-3 gap-4">
            <select name="produto_id" class="border p-2 rounded" required>
                <option value="">Selecione um produto</option>
                @foreach ($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
            <input name="quantidade" type="number" min="0" placeholder="Quantidade" class="border p-2 rounded" required>
            <input name="localizacao" placeholder="Localização" class="border p-2 rounded">
        </div>
        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Adicionar Estoque</button>
    </form>

    {{-- Campo de busca --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6 w-full max-w-md">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por produto ou local..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
        <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
        </svg>
    </div>

    {{-- Lista de estoques --}}
    <template x-for="item in {{ Js::from($itens) }}" :key="item.id">
        <div
            x-show="termo === '' || item.produto.nome.toLowerCase().includes(termo.toLowerCase()) || (item.localizacao || '').toLowerCase().includes(termo.toLowerCase())"
            class="flex justify-between items-center bg-gray-800 text-white p-4 rounded shadow mb-3"
        >
            <div class="flex-1">
                {{-- Edição --}}
                <template x-if="editando === item.id">
                    <form :action="`/estoques/${item.id}`" method="POST" class="grid grid-cols-3 gap-2">
                        @csrf
                        @method('PUT')
                        <select name="produto_id" class="bg-gray-700 text-white p-1 rounded" required>
                            @foreach ($produtos as $produto)
                                <option :value="{{ $produto->id }}" x-bind:selected="item.produto_id === {{ $produto->id }}">
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="quantidade" :value="item.quantidade" class="bg-gray-700 p-1 rounded text-white">
                        <input type="text" name="localizacao" :value="item.localizacao" class="bg-gray-700 p-1 rounded text-white">
                        <button class="text-green-400 hover:text-green-500 text-xl">💾</button>
                    </form>
                </template>

                {{-- Visualização padrão --}}
                <template x-if="editando !== item.id">
                    <div>
                        <p><strong>Produto:</strong> <span x-text="item.produto.nome"></span></p>
                        <p><strong>Quantidade:</strong> <span x-text="item.quantidade"></span></p>
                        <p><strong>Localização:</strong> <span x-text="item.localizacao ?? '—'"></span></p>
                    </div>
                </template>
            </div>

            <div class="flex gap-3 ml-4">
                <button @click="editando = (editando === item.id ? null : item.id)"
                        class="text-orange-400 hover:text-orange-500 text-xl">✏️</button>

                <form :action="`/estoques/${item.id}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-pink-400 hover:text-pink-500 text-xl">❌</button>
                </form>
            </div>
        </div>
    </template>
</div>
