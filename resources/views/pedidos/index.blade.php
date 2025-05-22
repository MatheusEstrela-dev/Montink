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
