{{-- resources/views/usuarios/index.blade.php --}}

<div x-data="{
    termo: '',
    editando: null,
    novo: { nome: '', email: '', senha: '' },
    todosUsuarios: {{ Js::from(
        $itens instanceof \Illuminate\Pagination\AbstractPaginator
            ? $itens->items()
            : $itens
    ) }},
    get usuariosFiltrados() {
        return this.todosUsuarios
            .filter(u => u.email !== 'admin@montink.com') // oculta o admin
            .filter(u =>
                (u.nome  ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
                (u.email ?? '').toLowerCase().includes(this.termo.toLowerCase())
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
        .then(res => res.json())
        .then(u => {
            this.todosUsuarios.unshift(u);
            this.novo = { nome:'', email:'', senha:'' };
        })
        .catch(()=>alert('Erro ao criar usuário.'));
    },
    salvar(id) {
        const u = this.todosUsuarios.find(x=>x.id===id);
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
        .then(res => {
            if (!res.ok) throw new Error();
            this.editando = null;
            alert('Usuário atualizado!');
        })
        .catch(()=>alert('Erro ao atualizar usuário.'));
    },
    excluir(id) {
        if (!confirm('Tem certeza que deseja excluir este usuário?')) return;
        fetch(`/usuarios/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}' }
        })
        .then(res => {
            if (!res.ok) throw new Error();
            this.todosUsuarios = this.todosUsuarios.filter(x=>x.id!==id);
            alert('Usuário excluído!');
        })
        .catch(()=>alert('Erro ao excluir usuário.'));
    }
}" class="space-y-6 text-gray-800">

    {{-- Busca Dinâmica --}}
    <div class="relative">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por nome ou e-mail..."
            class="w-full pl-10 pr-4 py-2 rounded bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none"
        />
        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
        </svg>
    </div>

    {{-- Formulário de Criação --}}
    <div class="bg-gray-800 p-4 rounded flex space-x-2 text-gray-200">
        <input x-model="novo.nome"  type="text"     placeholder="Nome"  class="flex-1 p-2 bg-gray-700 rounded text-black"/>
        <input x-model="novo.email" type="email"    placeholder="E-mail"class="flex-1 p-2 bg-gray-700 rounded text-black"/>
        <input x-model="novo.senha" type="password" placeholder="Senha" class="flex-1 p-2 bg-gray-700 rounded text-black"/>
        <button @click="criar()"    class="bg-green-600 hover:bg-green-700 px-4 rounded">Criar</button>
    </div>

    {{-- Lista e Edição Inline --}}
    <template x-for="usuario in usuariosFiltrados" :key="usuario.id">
      <div class="bg-white p-4 rounded shadow flex items-center space-x-4">

        {{-- Nome + E-mail ou Inputs de edição --}}
        <div class="flex-1 grid grid-cols-[2fr,2fr,1fr] gap-2 items-center">

          {{-- Modo leitura --}}
          <template x-if="editando !== usuario.id">
            <>
              <p class="font-bold" x-text="usuario.nome"></p>
              <p class="text-gray-500" x-text="usuario.email"></p>
              <div></div>
            </>
          </template>

          {{-- Modo edição --}}
          <template x-if="editando === usuario.id">
            <>
              <input
                x-model="usuario.nome"
                type="text"
                class="w-full px-2 py-1 border rounded"
              />
              <input
                x-model="usuario.email"
                type="email"
                class="w-full px-2 py-1 border rounded"
              />
              <input
                x-model="usuario.senha"
                type="password"
                placeholder="Nova senha"
                class="w-full px-2 py-1 border rounded"
              />
            </>
          </template>

        </div>

        {{-- Ações --}}
        <div class="flex items-center space-x-2">
          <template x-if="editando !== usuario.id">
            <button @click="editando = usuario.id"
                    class="text-orange-600 hover:text-orange-800 text-xl">✏️</button>
          </template>
          <template x-if="editando === usuario.id">
            <button @click="salvar(usuario.id)"
                    class="text-green-600 hover:text-green-800 text-xl">💾</button>
          </template>
          <button @click="excluir(usuario.id)"
                  class="text-pink-600 hover:text-pink-800 text-xl">❌</button>
        </div>

      </div>
    </template>

    {{-- Paginação --}}
    <div class="mt-4 flex justify-end">
        {{ $itens->appends(['modulo'=>$modulo])->onEachSide(1)->links('pagination::tailwind') }}
    </div>
</div>
