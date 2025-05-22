<div x-data="{
    termo: '',
    todosProdutos: {{ Js::from($itens->items()) }},
    get produtos() {
        if (this.termo === '') return this.todosProdutos;
        return this.todosProdutos.filter(p =>
            (p.nome ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (p.categoria ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    }
}" class="space-y-4">

    {{-- Campo de busca --}}
    <input
        type="text"
        x-model="termo"
        placeholder="Buscar por nome ou categoria..."
        class="w-full px-4 py-2 rounded shadow text-black"
    />

    {{-- Lista --}}
    <template x-for="produto in produtos" :key="produto.id">
        <div class="bg-white p-4 rounded shadow">
            <p class="font-bold text-lg text-gray-800" x-text="produto.nome"></p>
            <p class="text-sm text-gray-500" x-text="produto.categoria"></p>
            <p class="text-green-600 font-semibold">R$ <span x-text="Number(produto.preco).toFixed(2).replace('.', ',')"></span></p>
        </div>
    </template>

    {{-- Vazio --}}
    <template x-if="produtos.length === 0">
        <p class="text-gray-400 italic">Nenhum produto encontrado.</p>
    </template>

    {{-- Paginação --}}
    <div class="mt-4">
        {{-- Limita exibição lateral a 2 páginas de cada lado (1 + 2 à esquerda + 2 à direita = 5 páginas) --}}
        {{ $itens->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}

    </div>
</div>
