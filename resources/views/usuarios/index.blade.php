<div x-data="{
    termo: '',
    editando: null,
    todosUsuarios: {{ Js::from($itens->items()) }},
    get usuariosFiltrados() {
        return this.todosUsuarios
            .filter(u => u.email !== 'admin@montink.com') // Oculta admin
            .filter(u =>
                (u.nome ?? '').toLowerCase().includes(this.termo.toLowerCase()) ||
                (u.email ?? '').toLowerCase().includes(this.termo.toLowerCase())
            );
    },
    salvar(id) {
        const usuario = this.todosUsuarios.find(u => u.id === id);
        fetch(`/usuarios/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                nome: usuario.nome,
                email: usuario.email,
                senha: usuario.senha ?? ''
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao salvar');
            this.editando = null;
            alert('Usuário atualizado!');
        })
        .catch(() => alert('Erro ao salvar.'));
    },
    excluir(id) {
        if (!confirm('Tem certeza que deseja excluir este usuário?')) return;
        fetch(`/usuarios/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao excluir');
            this.todosUsuarios = this.todosUsuarios.filter(u => u.id !== id);
            alert('Usuário excluído!');
        })
        .catch(() => alert('Erro ao excluir.'));
    }
}" class="space-y-4">

    {{-- Campo de busca --}}
    <input
        x-model="termo"
        type="text"
        placeholder="Buscar por nome ou e-mail..."
        class="w-full px-4 py-2 rounded shadow text-black"
    />

    {{-- Lista de usuários --}}
    <template x-for="usuario in usuariosFiltrados" :key="usuario.id">
        <div class="flex justify-between items-center bg-white p-4 rounded shadow">
            <div>
                <template x-if="editando !== usuario.id">
                    <div>
                        <p class="font-bold text-gray-800" x-text="usuario.nome"></p>
                        <p class="text-sm text-gray-500" x-text="usuario.email"></p>
                    </div>
                </template>
                <template x-if="editando === usuario.id">
                    <div class="space-y-1">
                        <input x-model="usuario.nome" class="w-full px-2 py-1 border rounded" />
                        <input x-model="usuario.email" class="w-full px-2 py-1 border rounded" />
                        <input x-model="usuario.senha" type="password" class="w-full px-2 py-1 border rounded" placeholder="Nova senha" />
                    </div>
                </template>
            </div>

            <div class="flex items-center space-x-2">
                <template x-if="editando !== usuario.id">
                    <button @click="editando = usuario.id" class="text-orange-600 hover:text-orange-800 text-xl">✏</button>
                </template>
                <template x-if="editando === usuario.id">
                    <button @click="salvar(usuario.id)" class="text-green-600 hover:text-green-800 text-xl">💾</button>
                </template>
                <button @click="excluir(usuario.id)" class="text-pink-600 hover:text-pink-800 text-xl">❌</button>
            </div>
        </div>
    </template>

    {{-- Paginação --}}
    <div class="mt-4 flex justify-end">
       {{ $itens->appends(['modulo' => $modulo])->links('pagination::tailwind') }}
    </div>
</div>
