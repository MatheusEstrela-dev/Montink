
<div x-data="{ termo: '', editando: null }">
    <h1 class="text-2xl font-bold text-purple-800 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c3.314 0 6.314 1.166 8.879 3.096M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Lista de Usuários
    </h1>

    {{-- Campo de busca --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6 w-full max-w-md">
        <input
            x-model="termo"
            type="text"
            placeholder="Buscar por nome ou e-mail..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
        <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
        </svg>
    </div>

    {{-- Lista de usuários --}}
    <template x-for="usuario in {{ Js::from($itens) }}" :key="usuario.id">
        <div
            x-show="termo === '' || usuario.nome.toLowerCase().includes(termo.toLowerCase()) || usuario.email.toLowerCase().includes(termo.toLowerCase())"
            class="flex justify-between items-center bg-gray-800 text-white p-4 rounded shadow mb-3"
        >
            <div class="flex-1">
                {{-- Formulário de edição inline --}}
                <template x-if="editando === usuario.id">
                    <form :action="`/usuarios/${usuario.id}`" method="POST" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nome" :value="usuario.nome" class="bg-gray-700 text-white px-2 py-1 rounded w-1/3">
                        <input type="email" name="email" :value="usuario.email" class="bg-gray-700 text-white px-2 py-1 rounded w-1/3">
                        <input type="password" name="senha" placeholder="Nova senha" class="bg-gray-700 text-white px-2 py-1 rounded w-1/3">
                        <button class="text-green-400 hover:text-green-500 text-xl" title="Salvar">💾</button>
                    </form>
                </template>

                {{-- Visualização padrão --}}
                <template x-if="editando !== usuario.id">
                    <div>
                        <p class="font-semibold" x-text="usuario.nome"></p>
                        <p class="text-sm text-gray-300" x-text="usuario.email"></p>
                    </div>
                </template>
            </div>

            {{-- Ações --}}
            <div class="flex gap-3 ml-4">
                <button @click="editando = (editando === usuario.id ? null : usuario.id)"
                        class="text-orange-400 hover:text-orange-500 text-xl">✏️</button>

                <form :action="`/usuarios/${usuario.id}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-pink-400 hover:text-pink-500 text-xl" title="Excluir">❌</button>
                </form>
            </div>
        </div>
    </template>
</div>
