<div x-data="{ termo: '' }" class="space-y-6">

    {{-- Campo de busca em tempo real --}}
    <div class="flex items-center bg-white shadow rounded px-4 py-2">
        <input
            x-model="termo"
            type="text"
            placeholder="Procurar pedido..."
            class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
        />
        <span class="ml-2 text-gray-500 text-xl">🔍</span>
    </div>

    {{-- Lista filtrada em tempo real --}}
    @foreach ($itens as $pedido)
        <div
            x-show="termo === '' || '{{ strtolower($pedido->status) }}'.includes(termo.toLowerCase()) || '{{ strtolower($pedido->id) }}'.includes(termo.toLowerCase())"
            class="flex justify-between items-center bg-white p-4 rounded shadow transition"
        >
            <p>
                <strong>Pedido #{{ $pedido->id }}</strong> -
                R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
            </p>
            <button
                @click="$refs['detalhes{{ $pedido->id }}'].classList.toggle('hidden')"
                class="text-blue-600 hover:underline text-sm"
            >Ver mais</button>
        </div>

        {{-- Bloco de detalhes --}}
        <div x-ref="detalhes{{ $pedido->id }}" class="hidden bg-gray-50 border rounded p-4 text-sm text-gray-700 ml-2">
            <p><strong>Status:</strong> {{ $pedido->status }}</p>
            <p><strong>Data do pedido:</strong> {{ $pedido->data_pedido }}</p>
            <p><strong>Usuário:</strong> {{ $pedido->usuario->nome ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $pedido->usuario->email ?? '-' }}</p>
        </div>
    @endforeach

    {{-- Mensagem de vazio --}}
    <template x-if="
        {{ Js::from($itens->pluck('status')->toArray()) }}.filter(status =>
            status.toLowerCase().includes(termo.toLowerCase())
        ).length === 0
    ">
        <div class="text-gray-500 italic">Nenhum pedido encontrado.</div>
    </template>

    {{-- Paginação --}}
    <div class="flex justify-end mt-4">
        {{ $itens->onEachSide(1)->links('pagination::tailwind') }}
    </div>
</div>
