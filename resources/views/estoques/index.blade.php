<pre class="text-white bg-black p-4 rounded">{{ json_encode($itens, JSON_PRETTY_PRINT) }}</pre>

<div x-data="{
    termo: '',
    todosEstoques: {{ Js::from($itens instanceof \Illuminate\Pagination\AbstractPaginator ? $itens->items() : $itens) }},
    get estoques() {
        if (this.termo === '') return this.todosEstoques;
        return this.todosEstoques.filter(e =>
            (e.produto?.nome ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (e.localizacao ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    }
}" class="space-y-4">

    <input type="text" x-model="termo" placeholder="Buscar por produto ou local..." class="w-full px-4 py-2 rounded text-black" />

    <template x-for="estoque in estoques" :key="estoque.id">
        <div class="bg-white p-4 rounded shadow">
            <p class="font-bold text-lg text-gray-800" x-text="estoque.produto?.nome ?? 'Produto não encontrado'"></p>
            <p class="text-sm text-gray-600" x-text="'Quantidade: ' + estoque.quantidade"></p>
            <p class="text-sm text-gray-400" x-text="'Localização: ' + (estoque.localizacao ?? '-')"></p>
        </div>
    </template>

    <template x-if="estoques.length === 0">
        <p class="text-gray-400 italic">Nenhum estoque encontrado.</p>
    </template>

    <div class="mt-4">
        {{ $itens instanceof \Illuminate\Pagination\AbstractPaginator
            ? $itens->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind')
            : '' }}
    </div>
</div>
