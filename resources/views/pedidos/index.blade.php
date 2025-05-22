<div x-data="{
        termo: '',
        todosPedidos: {{ Js::from($itens->items()) }},
        get pedidos() {
            if (this.termo === '') return this.todosPedidos;
            return this.todosPedidos.filter(p =>
                String(p.id).includes(this.termo) ||
                p.status.toLowerCase().includes(this.termo.toLowerCase()) ||
                String(p.valor_total).includes(this.termo)
            );
        }
    }"
    class="space-y-3"
>

    {{-- Campo de busca dinâmica --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2">
        <input
            type="text"
            placeholder="Procurar pedido..."
            x-model="termo"
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
        <span class="ml-2 text-gray-500 text-xl"></span>
    </div>

    {{-- Lista dinâmica --}}
    <template x-for="pedido in pedidos" :key="pedido.id">
        <div x-data="{ aberto: false }" class="bg-white rounded shadow px-4 py-3">
            <div class="flex justify-between items-center">
                <p class="text-gray-800 font-semibold">
                    Pedido #<span x-text="pedido.id"></span> - R$
                    <span x-text="Number(pedido.valor_total).toFixed(2).replace('.', ',')"></span>
                </p>
                <button @click="aberto = !aberto" class="text-blue-600 hover:underline text-sm">
                    <span x-show="!aberto">Ver mais</span>
                    <span x-show="aberto">Fechar</span>
                </button>
            </div>

            <div x-show="aberto" class="mt-3 text-sm space-y-1" x-transition>
                <p><strong>Status:</strong> <span x-text="pedido.status"></span></p>
                <p><strong>Data do pedido:</strong> <span x-text="new Date(pedido.data_pedido).toLocaleDateString('pt-BR')"></span></p>
                <template x-if="pedido.usuario">
                    <div>
                        <p><strong>Usuário:</strong> <span x-text="pedido.usuario.name"></span></p>
                        <p><strong>Email:</strong> <span x-text="pedido.usuario.email"></span></p>
                    </div>
                </template>
                <template x-if="!pedido.usuario">
                    <p><strong>Usuário:</strong> N/A</p>
                </template>
            </div>
        </div>
    </template>

    {{-- Resultado vazio --}}
    <template x-if="pedidos.length === 0">
        <div class="text-gray-500 italic">Nenhum pedido encontrado.</div>
    </template>

    {{-- Paginação única no canto inferior direito --}}
    @if ($itens instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-6 flex justify-end">
            {{ $itens->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    @endif

</div>
