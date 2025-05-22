{{-- resources/views/estoques/index.blade.php --}}
@php
    $produtos = \App\Models\Produto::orderBy('nome')->get(['id','nome']);
@endphp

<div x-data="{
    termo: '',
    novo: { produto_id: null, quantidade: 0, localizacao: '' },
    todos: {{ Js::from($itens->items()) }},
    editando: null,
    get lista() {
        if (this.termo === '') return this.todos;
        return this.todos.filter(e =>
            e.nome_produto.toLowerCase().includes(this.termo.toLowerCase()) ||
            (e.localizacao ?? '').toLowerCase().includes(this.termo.toLowerCase())
        );
    },
    criar() { /* ... */ },
    salvar(id) { /* ... */ },
    excluir(id) { /* ... */ }
}" class="space-y-6">

    {{-- Campo de Busca Dinâmica --}}
    <div class="relative">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por produto ou local..."
            class="w-full pl-10 pr-4 py-2 rounded bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none"
        />
        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
        </svg>
    </div>

    {{-- Novo Estoque --}}
    <div class="bg-gray-800 p-4 rounded space-y-2 text-gray-200">
        <h2 class="font-semibold">➕ Adicionar Estoque</h2>
        <div class="grid grid-cols-3 gap-2">
            <select x-model="novo.produto_id" class="p-2 bg-gray-700 rounded">
                <option value="">-- Produto --</option>
                @foreach($produtos as $p)
                    <option value="{{ $p->id }}">{{ $p->nome }}</option>
                @endforeach
            </select>
            <input type="number" x-model.number="novo.quantidade" min="0" placeholder="Quantidade"
                   class="p-2 bg-gray-700 rounded text-black"/>
            <input type="text" x-model="novo.localizacao" placeholder="Localização"
                   class="p-2 bg-gray-700 rounded text-black"/>
            <button @click="criar()" class="col-span-3 bg-green-600 hover:bg-green-700 p-2 rounded">Criar</button>
        </div>
    </div>

    {{-- Lista de Estoques --}}
    <template x-for="e in lista" :key="e.id">
        <div class="bg-white p-4 rounded shadow flex justify-between items-start space-x-4">
            <div class="flex-1 space-y-1">
                <p class="font-bold" x-text="e.nome_produto"></p>

                <template x-if="editando!==e.id">
                    <div class="text-sm">
                        <p>Qtd: <span x-text="e.quantidade"></span></p>
                        <p>Local: <span x-text="e.localizacao"></span></p>
                    </div>
                </template>

                <template x-if="editando===e.id">
                    <div class="space-y-1">
                        <input type="number" x-model.number="e.quantidade" min="0"
                               class="w-full p-1 border rounded"/>
                        <input type="text" x-model="e.localizacao"
                               class="w-full p-1 border rounded"/>
                    </div>
                </template>
            </div>

            <div class="flex items-center space-x-2">
                <template x-if="editando!==e.id">
                    <button @click="editando=e.id" class="text-yellow-600 hover:text-yellow-800">✏️</button>
                </template>
                <template x-if="editando===e.id">
                    <button @click="salvar(e.id)" class="text-green-600 hover:text-green-800">💾</button>
                </template>
                <button @click="excluir(e.id)" class="text-red-600 hover:text-red-800">❌</button>
            </div>
        </div>
    </template>

    {{-- Mensagem vazio --}}
    <template x-if="lista.length === 0">
        <p class="text-gray-400 italic">Nenhum estoque encontrado.</p>
    </template>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $itens->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
    </div>
</div>
