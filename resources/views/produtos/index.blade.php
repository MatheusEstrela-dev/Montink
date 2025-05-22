<div x-data="{
    termo: '',
    editando: null,
    todosProdutos: {{ Js::from($itens->items()) }},
    get produtosFiltrados() {
        if (this.termo === '') return this.todosProdutos;
        return this.todosProdutos.filter(p =>
            (p.nome ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (p.categoria ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    },
    salvar(id) {
        const produto = this.todosProdutos.find(p => p.id === id);
        fetch(`/produtos/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                nome: produto.nome,
                categoria: produto.categoria,
                preco: produto.preco
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao salvar');
            this.editando = null;
            alert('Produto atualizado!');
        })
        .catch(() => alert('Erro ao salvar.'));
    },
    excluir(id) {
        if (!confirm('Tem certeza que deseja excluir este produto?')) return;
        fetch(`/produtos/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao excluir');
            this.todosProdutos = this.todosProdutos.filter(p => p.id !== id);
            alert('Produto excluído!');
        })
        .catch(() => alert('Erro ao excluir.'));
    }
}" class="space-y-4">
    {{-- Campo de busca --}}
    <input
        x-model="termo"
        type="text"
        placeholder="Buscar por nome ou categoria..."
        class="w-full px-4 py-2 rounded shadow text-black"
    />

    {{-- Lista de produtos --}}
    <template x-for="produto in produtosFiltrados" :key="produto.id">
        <div class="flex justify-between items-center bg-white p-4 rounded shadow">
            <div>
                <template x-if="editando !== produto.id">
                    <div>
                        <p class="font-bold text-gray-800" x-text="produto.nome"></p>
                        <p class="text-sm text-gray-500" x-text="produto.categoria"></p>
                        <p class="text-green-600">R$ <span x-text="Number(produto.preco).toFixed(2).replace('.', ',')"></span></p>
                    </div>
                </template>
                <template x-if="editando === produto.id">
                    <div class="space-y-1">
                        <input x-model="produto.nome" class="w-full px-2 py-1 border rounded" />
                        <input x-model="produto.categoria" class="w-full px-2 py-1 border rounded" />
                        <input x-model="produto.preco" type="number" step="0.01" class="w-full px-2 py-1 border rounded" />
                    </div>
                </template>
            </div>

            <div class="flex items-center space-x-2">
                <template x-if="editando !== produto.id">
                    <button @click="editando = produto.id" class="text-orange-600 hover:text-orange-800 text-xl">✏</button>
                </template>
                <template x-if="editando === produto.id">
                    <button @click="salvar(produto.id)" class="text-green-600 hover:text-green-800 text-xl">💾</button>
                </template>
                <button @click="excluir(produto.id)" class="text-pink-600 hover:text-pink-800 text-xl">❌</button>
            </div>
        </div>
    </template>

    {{-- Paginação --}}
    <div class="mt-4 flex justify-end">
        {{ $itens->appends(['modulo' => $modulo])->links('pagination::tailwind') }}
    </div>
</div>
