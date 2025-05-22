
<pre class="text-xs text-white bg-black p-2 rounded">
    {{ json_encode(
        $itens instanceof \Illuminate\Pagination\AbstractPaginator
            ? $itens->items()
            : $itens,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    ) }}
</pre>

<div
    x-data="{
        termo: '',
        todosEstoques: {{ Js::from(
            $itens instanceof \Illuminate\Pagination\AbstractPaginator
                ? $itens->items()
                : $itens
        ) }},
        get estoques() {
            if (this.termo === '') return this.todosEstoques;
            return this.todosEstoques.filter(e =>
                (e.nome_produto ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
                (e.localizacao ?? '').toLowerCase().includes(this.termo.toLowerCase())
            );
        }
    }"
    x-init="console.log('Estoque carregado:', todosEstoques)"
    class="space-y-4"
>

    {{-- Campo de busca --}}
    <input
        type="text"
        x-model="termo"
        placeholder="Buscar por produto ou local..."
        class="w-full px-4 py-2 rounded text-black"
    />

    {{-- Lista de itens --}}
    <template x-for="estoque in estoques" :key="estoque.id">
        <div class="bg-white p-4 rounded shadow">
            <p class="font-bold text-lg text-gray-800" x-text="estoque.nome_produto ?? 'Produto não encontrado'"></p>
            <p class="text-sm text-gray-600" x-text="'Quantidade: ' + estoque.quantidade"></p>
            <p class="text-sm text-gray-400" x-text="'Localização: ' + (estoque.localizacao ?? '-')"></p>
        </div>
    </template>

    {{-- Mensagem vazio --}}
    <template x-if="estoques.length === 0">
        <p class="text-gray-400 italic">Nenhum estoque encontrado.</p>
    </template>

    {{-- Paginação --}}
    <div class="mt-4">
        {{
            $itens instanceof \Illuminate\Pagination\AbstractPaginator
                ? $itens->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind')
                : ''
        }}
    </div>
</div>
