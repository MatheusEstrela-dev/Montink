<div>
    <h2>Debug Estoques:</h2>
    <pre class="text-white bg-black p-4 rounded">{{ json_encode($itens, JSON_PRETTY_PRINT) }}</pre>
</div>

<div x-data="{
    termo: '',
    todosEstoques: {{ Js::from($itens) }},
    get estoques() {
        if (this.termo === '') return this.todosEstoques;
        return this.todosEstoques.filter(e =>
            (e.produto?.nome ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (e.localizacao ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    }
}" class="space-y-4">

    {{-- Campo de busca --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por produto ou local..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
    </div>

    {{-- Lista de estoques --}}
    <template x-for="estoque in estoques" :key="estoque.id">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold" x-text="estoque.produto?.nome ?? 'Produto não encontrado'"></h2>
            <p class="text-gray-700">Quantidade: <span x-text="estoque.quantidade"></span></p>
            <p class="text-gray-500">Localização: <span x-text="estoque.localizacao"></span></p>
        </div>
    </template>

    <template x-if="estoques.length === 0">
        <p class="text-gray-500 italic">Nenhum estoque encontrado.</p>
    </template>
</div>
