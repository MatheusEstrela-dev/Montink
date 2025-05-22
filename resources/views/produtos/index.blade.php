<div x-data="estoqueData()" class="space-y-4">
  <div class="relative">
    <input
      x-model="termo"
      type="text"
      placeholder="Buscar por nome ou categoria..."
      class="w-full pl-10 pr-4 py-2 rounded bg-gray-800 text-gray-200 placeholder-gray-400"
    />
    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
    </svg>
  </div>

  {{-- Novo Produto --}}
  <div class="bg-gray-800 p-4 rounded flex space-x-2 text-gray-200">
    <input x-model="novo.nome"      type="text"     placeholder="Nome"      class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <input x-model="novo.categoria" type="text"     placeholder="Categoria" class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <input x-model.number="novo.preco" type="number" step="0.01" placeholder="Preço" class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <button @click="criar()"        class="bg-green-600 hover:bg-green-700 px-4 rounded">Criar</button>
  </div>

  {{-- Listagem e Edição Inline --}}
  <template x-for="p in produtosFiltrados" :key="p.id">
    <div class="bg-white p-4 rounded shadow flex items-center space-x-4">

      <div class="flex-1 grid grid-cols-[2fr,2fr,1fr] gap-2 items-center">
        {{-- leitura --}}
        <template x-if="editando !== p.id">
          <div class="grid grid-cols-[2fr,2fr,1fr] gap-2">
            <p class="font-bold" x-text="p.nome"></p>
            <p class="text-gray-500" x-text="p.categoria"></p>
            <p class="text-green-600">R$ <span x-text="Number(p.preco).toFixed(2).replace('.',',')"></span></p>
          </div>
        </template>
        {{-- edição --}}
        <template x-if="editando === p.id">
          <div class="grid grid-cols-[2fr,2fr,1fr] gap-2">
            <input x-model="p.nome"      type="text" class="px-2 py-1 border rounded w-full" />
            <input x-model="p.categoria" type="text" class="px-2 py-1 border rounded w-full" />
            <input x-model.number="p.preco" type="number" step="0.01" class="px-2 py-1 border rounded w-full" />
          </div>
        </template>
      </div>

      {{-- ações --}}
      <div class="flex items-center space-x-2">
        <template x-if="editando !== p.id">
          <button @click="editando = p.id" class="text-orange-600 text-xl">✏️</button>
        </template>
        <template x-if="editando === p.id">
          <button @click="salvar(p.id)" class="text-green-600 text-xl">💾</button>
        </template>
        <button @click="excluir(p.id)" class="text-pink-600 text-xl">❌</button>
        <a
          @click.prevent="adicionarAoCarrinho(p.id)"
          class="text-green-500 hover:text-green-700 ml-2 text-xl cursor-pointer"
          title="Adicionar ao carrinho"
        >
          🛒
        </a>
      </div>
    </div>
  </template>

  {{-- Paginação --}}
  <div class="mt-4 flex justify-end">
    {{ $itens->appends(['modulo'=>$modulo])->onEachSide(1)->links('pagination::tailwind') }}
  </div>
</div>

<script>
function estoqueData() {
  return {
    termo: '',
    editando: null,
    novo: { nome: '', categoria: '', preco: 0 },
    todosProdutos: {{ Js::from(
        $itens instanceof \Illuminate\Pagination\AbstractPaginator
            ? $itens->items()
            : $itens
    ) }},
    get produtosFiltrados() {
        return this.todosProdutos.filter(p =>
            (p.nome      ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
            (p.categoria ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    },
    criar() {
        fetch('/produtos', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify(this.novo)
        })
        .then(r => r.json())
        .then(p => {
            this.todosProdutos.unshift(p);
            this.novo = { nome:'', categoria:'', preco:0 };
        })
        .catch(()=>alert('Erro ao criar produto.'));
    },
    salvar(id) {
        const p = this.todosProdutos.find(x=>x.id===id);
        fetch(`/produtos/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nome: p.nome,
                categoria: p.categoria,
                preco: p.preco
            })
        })
        .then(r => {
            if (!r.ok) throw new Error();
            this.editando = null;
            alert('Produto atualizado!');
        })
        .catch(()=>alert('Erro ao atualizar produto.'));
    },
    excluir(id) {
        if (!confirm('Excluir este produto?')) return;
        fetch(`/produtos/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}' }
        })
        .then(r => {
            if (!r.ok) throw new Error();
            this.todosProdutos = this.todosProdutos.filter(x=>x.id!==id);
        })
        .catch(()=>alert('Erro ao excluir produto.'));
    },
    async adicionarAoCarrinho(id) {
      try {
        const res = await fetch('{{ route('carrinho.adicionar') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: JSON.stringify({ produto_id: id, quantidade: 1 })
        });
        if (!res.ok) throw new Error('Erro ao adicionar ao carrinho');
        const cartData = await res.json();
        alert(
          `Adicionado!\nSubtotal: R$${Number(cartData.subtotal).toFixed(2)}\nFrete: R$${Number(cartData.frete).toFixed(2)}\nTotal: R$${Number(cartData.total).toFixed(2)}`
        );
      } catch (e) {
        console.error(e);
        alert('Erro ao adicionar ao carrinho.');
      }
    },
  }
}

document.addEventListener('alpine:init', () => {
  Alpine.data('estoqueData', estoqueData);
});
</script>
