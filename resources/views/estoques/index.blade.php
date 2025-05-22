<div x-data="{
    termo: '',
    editando: null,
    todosEstoques: {{ Js::from($itens->items()) }},
    get estoques() {
        return this.todosEstoques.filter(e =>
            this.termo === '' ||
            (e.produto?.nome || '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (e.localizacao || '').toLowerCase().includes(this.termo.toLowerCase())
        );
    }
}">
    <h1 class="text-2xl font-bold text-yellow-500 mb-6">📦 Estoque</h1>

    {{-- Campo de busca --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6 w-full max-w-md">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por produto ou local..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
    </div>

    {{-- Lista de estoques --}}
    <template x-for="estoque in estoques" :key="estoque.id">
        <div class="flex justify-between items-center bg-gray-800 text-white p-4 rounded shadow mb-3">
            <div class="flex-1">
                {{-- Formulário de edição inline --}}
                <template x-if="editando === estoque.id">
                    <form :action="`/estoques/${estoque.id}`" method="POST" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantidade" :value="estoque.quantidade" class="bg-gray-700 text-white px-2 py-1 rounded w-1/4">
                        <input type="text" name="localizacao" :value="estoque.localizacao" class="bg-gray-700 text-white px-2 py-1 rounded w-1/2">
                        <button class="text-green-400 hover:text-green-500 text-xl" title="Salvar">💾</button>
                    </form>
                </template>

                {{-- Visualização padrão --}}
                <template x-if="editando !== estoque.id">
                    <div>
                        <p class="font-semibold text-lg" x-text="estoque.produto?.nome || 'Produto não encontrado'"></p>
                        <p class="text-sm">Quantidade: <span x-text="estoque.quantidade"></span></p>
                        <p class="text-sm text-gray-300">Localização: <span x-text="estoque.localizacao || 'N/A'"></span></p>
                    </div>
                </template>
            </div>

            {{-- Botões --}}
            <div class="flex gap-3 ml-4">
                <button @click="editando = (editando === estoque.id ? null : estoque.id)"
                        class="text-orange-400 hover:text-orange-500 text-xl" title="Editar">✏️</button>

                <form :action="`/estoques/${estoque.id}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-pink-400 hover:text-pink-500 text-xl" title="Excluir">❌</button>
                </form>
            </div>
        </div>
    </template>

    {{-- Paginação padrão (Tailwind) --}}
    @if ($itens instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-6 flex justify-end">
            {{ $itens->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    @endif
</div>
