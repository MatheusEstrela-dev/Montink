{{-- resources/views/usuarios/index.blade.php --}}

<div x-data="{
    termo: '',
    editando: null,
    novo: { nome: '', email: '', senha: '' },
    todos: {{ Js::from(
        $itens instanceof \Illuminate\Pagination\AbstractPaginator
            ? $itens->items()
            : $itens
    ) }},
    get filtrados() {
        return this.todos
            .filter(u => u.email !== 'admin@montink.com')
            .filter(u =>
                u.nome.toLowerCase().includes(this.termo.toLowerCase()) ||
                u.email.toLowerCase().includes(this.termo.toLowerCase())
            );
    },
    criar() {
        fetch('/usuarios', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify(this.novo)
        })
        .then(r=>r.json())
        .then(u=>{
            this.todos.unshift(u);
            this.novo = { nome:'', email:'', senha:'' };
        })
        .catch(()=>alert('Erro ao criar usuário.'));
    },
    salvar(id) {
        const u = this.todos.find(x=>x.id===id);
        fetch(`/usuarios/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nome: u.nome,
                email: u.email,
                senha: u.senha ?? ''
            })
        })
        .then(r=>{
            if(!r.ok) throw new Error();
            this.editando = null;
            alert('Usuário atualizado!');
        })
        .catch(()=>alert('Erro ao atualizar.'));
    },
    excluir(id) {
        if(!confirm('Excluir este usuário?')) return;
        fetch(`/usuarios/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}' }
        })
        .then(r=>{
            if(!r.ok) throw new Error();
            this.todos = this.todos.filter(x=>x.id!==id);
        })
        .catch(()=>alert('Erro ao excluir.'));
    }
}" class="space-y-4 text-gray-800">

  {{-- Busca --}}
  <div class="relative">
    <input
      x-model="termo"
      type="text"
      placeholder="Buscar por nome ou e-mail..."
      class="w-full pl-10 pr-4 py-2 rounded bg-gray-800 text-gray-200 placeholder-gray-400"
    />
    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" viewBox="0 0 24 24" stroke="currentColor" fill="none">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
    </svg>
  </div>

  {{-- Criar Usuário --}}
  <div class="bg-gray-800 p-4 rounded flex space-x-2 text-gray-200">
    <input x-model="novo.nome"  type="text"     placeholder="Nome"  class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <input x-model="novo.email" type="email"    placeholder="E-mail"class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <input x-model="novo.senha" type="password" placeholder="Senha" class="flex-1 p-2 bg-gray-700 rounded text-black"/>
    <button @click="criar()"    class="bg-green-600 hover:bg-green-700 px-4 rounded">Criar</button>
  </div>

  {{-- Listagem / Edição Inline --}}
  <template x-for="u in filtrados" :key="u.id">
    <div class="bg-white p-4 rounded shadow flex items-center space-x-4">

      {{-- nome + email ou inputs --}}
      <div class="flex-1">
        <template x-if="editando !== u.id">
          <div class="grid grid-cols-[2fr,2fr,1fr] gap-2 items-center">
            <p class="font-bold" x-text="u.nome"></p>
            <p class="text-gray-500" x-text="u.email"></p>
            <div></div>
          </div>
        </template>
        <template x-if="editando === u.id">
          <div class="grid grid-cols-[2fr,2fr,1fr] gap-2 items-center">
            <input x-model="u.nome"  type="text"     class="px-2 py-1 border rounded w-full" />
            <input x-model="u.email" type="email"    class="px-2 py-1 border rounded w-full" />
            <input x-model="u.senha" type="password" placeholder="Nova senha"
                   class="px-2 py-1 border rounded w-full" />
          </div>
        </template>
      </div>

      {{-- botões --}}
      <div class="flex items-center space-x-2">
        <template x-if="editando !== u.id">
          <button @click="editando = u.id" class="text-orange-600 text-xl">✏️</button>
        </template>
        <template x-if="editando === u.id">
          <button @click="salvar(u.id)" class="text-green-600 text-xl">💾</button>
        </template>
        <button @click="excluir(u.id)" class="text-pink-600 text-xl">❌</button>
      </div>
    </div>
  </template>

  {{-- Paginação --}}
  <div class="mt-4 flex justify-end">
    {{ $itens->appends(['modulo' => $modulo])->onEachSide(1)->links('pagination::tailwind') }}
  </div>
</div>
