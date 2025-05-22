{{-- resources/views/estoques/index.blade.php --}}

<div x-data="{
    termo: '',
    editando: null,
    novo: { produto_id: null, quantidade: 0, localizacao: '' },
    // paginador → array puro
    todosEstoques: {{ Js::from(
        $itens instanceof \Illuminate\Pagination\AbstractPaginator
          ? $itens->items()
          : $itens
    ) }},
    // uso a lista de todos os produtos para o select
    produtosOptions: {{ Js::from($todosProdutos) }},
    get filtrados() {
        if (this.termo === '') return this.todosEstoques;
        return this.todosEstoques.filter(e =>
            e.produto.nome.toLowerCase().includes(this.termo.toLowerCase()) ||
            (e.localizacao ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    },
    criar() {
        fetch('/estoques', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify(this.novo)
        })
        .then(r=>r.json())
        .then(e=>{
            // injetar no topo da lista
            this.todosEstoques.unshift({
              ...e,
              produto: this.produtosOptions.find(p=>p.id===e.produto_id)
            });
            this.novo = { produto_id: null, quantidade:0, localizacao:'' };
        })
        .catch(()=>alert('Erro ao criar estoque.'));
    },
    salvar(id) {
        const e = this.todosEstoques.find(x=>x.id===id);
        fetch(`/estoques/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                produto_id: e.produto_id,
                quantidade:  e.quantidade,
                localizacao: e.localizacao
            })
        })
        .then(r=>{
            if(!r.ok) throw new Error();
            this.editando = null;
            alert('Estoque atualizado!');
        })
        .catch(()=>alert('Erro ao atualizar estoque.'));
    },
    excluir(id) {
        if(!confirm('Excluir este registro de estoque?')) return;
        fetch(`/estoques/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}' }
        })
        .then(r=>{
            if(!r.ok) throw new Error();
            this.todosEstoques = this.todosEstoques.filter(x=>x.id!==id);
        })
        .catch(()=>alert('Erro ao excluir estoque.'));
    }
}" class="space-y-6">

  {{-- Busca --}}
  <div class="relative">
    <input
      x-model="termo"
      type="text"
      placeholder="Buscar por produto ou local..."
      class="w-full pl-10 pr-4 py-2 rounded bg-gray-800 text-gray-200 placeholder-gray-400"
    />
    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" viewBox="0 0 24 24" stroke="currentColor" fill="none">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
    </svg>
  </div>

  {{-- Formulário de criação --}}
  <div class="bg-gray-800 p-4 rounded flex space-x-2 text-gray-200">
    <select
      x-model.number="novo.produto_id"
      class="flex-1 p-2 bg-gray-700 rounded text-black"
    >
      <option value="">-- Produto --</option>
      <template x-for="p in produtosOptions" :key="p.id">
        <option :value="p.id" x-text="p.nome"></option>
      </template>
    </select>
    <input
      x-model.number="novo.quantidade"
      type="number" min="0"
      class="w-32 p-2 bg-gray-700 rounded text-black"
      placeholder="Qtd"
    />
    <input
      x-model="novo.localizacao"
      type="text"
      class="flex-1 p-2 bg-gray-700 rounded text-black"
      placeholder="Localização"
    />
    <button @click="criar()" class="bg-green-600 hover:bg-green-700 px-4 rounded">Criar</button>
  </div>

  {{-- Lista / Edição inline --}}
  <template x-for="e in filtrados" :key="e.id">
    <div class="bg-white p-4 rounded shadow flex items-center space-x-4">

      {{-- Coluna principal --}}
      <div class="flex-1">
        {{-- leitura --}}
        <template x-if="editando !== e.id">
          <div class="grid grid-cols-[2fr,1fr,2fr] gap-2 items-center">
            <p class="font-bold" x-text="e.produto.nome"></p>
            <p>Qtd: <span x-text="e.quantidade"></span></p>
            <p class="text-gray-500" x-text="e.localizacao ?? '-'"></p>
          </div>
        </template>

        {{-- edição --}}
        <template x-if="editando === e.id">
          <div class="grid grid-cols-[2fr,1fr,2fr] gap-2 items-center">
            <select
              x-model.number="e.produto_id"
              class="px-2 py-1 border rounded w-full"
            >
              <template x-for="p in produtosOptions" :key="p.id">
                <option :value="p.id" x-text="p.nome"></option>
              </template>
            </select>
            <input
              x-model.number="e.quantidade"
              type="number" min="0"
              class="px-2 py-1 border rounded w-full"
            />
            <input
              x-model="e.localizacao"
              type="text"
              class="px-2 py-1 border rounded w-full"
            />
          </div>
        </template>
      </div>

      {{-- botões --}}
      <div class="flex items-center space-x-2">
        <template x-if="editando !== e.id">
          <button @click="editando = e.id" class="text-orange-600 text-xl">✏️</button>
        </template>
        <template x-if="editando === e.id">
          <button @click="salvar(e.id)" class="text-green-600 text-xl">💾</button>
        </template>
        <button @click="excluir(e.id)" class="text-pink-600 text-xl">❌</button>
      </div>

    </div>
  </template>

  {{-- Paginação --}}
  <div class="mt-4 flex justify-end">
    {{ $itens->appends(['modulo'=>$modulo])->onEachSide(1)->links('pagination::tailwind') }}
  </div>
</div>
