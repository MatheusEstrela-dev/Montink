@extends('layouts.app')
@section('content')

  {{-- … outras seções (pedidos, produtos, estoque etc) … --}}

@if($modulo === 'carrinho')
  @if(session('success'))
    <div class="bg-green-200 text-green-900 p-2 rounded shadow mb-4">
      {{ session('success') }}
    </div>
  @endif

  <div
    x-data="cartComponent()"
    x-init="init(@json($itens), {{ $subtotal }}, {{ $frete }}, {{ $total }})"
    class="space-y-4"
  >
    <h2 class="text-2xl font-semibold mb-4">🛒 Módulo do Carrinho</h2>

    {{-- Lista de itens --}}
    <template x-for="item in items" :key="item.produto.id">
      <div
        class="flex justify-between items-center bg-white p-4 rounded shadow border border-gray-200"
        :class="{ 'ring-2 ring-green-400': item.produto.id === recentlyAddedId }"
      >
        <div class="flex items-center space-x-4">
          <img
            :src="'/img/produtos/' + item.produto.id + '.jpg'"
            alt="Imagem do produto"
            class="w-16 h-16 rounded object-cover"
            onerror="this.src='/img/produtos/placeholder.png'"
          />
          <div>
            <p class="font-bold text-lg" x-text="item.produto.nome"></p>
            <p class="text-gray-500">
              R$ <span x-text="parseFloat(item.produto.preco).toFixed(2)"></span> ×
              <span x-text="item.quantidade"></span> =
              R$ <span x-text="item.subtotal.toFixed(2)"></span>
            </p>
          </div>
        </div>
        <div class="flex space-x-2">
          <button @click="atualizar(item.produto.id, -1)" class="px-2" aria-label="Diminuir quantidade">–</button>
          <button @click="atualizar(item.produto.id, +1)" class="px-2" aria-label="Aumentar quantidade">+</button>
          <button @click="remover(item.produto.id)" class="text-red-500" aria-label="Remover item">❌</button>
        </div>
      </div>
    </template>

    {{-- Resumo --}}
    <div class="bg-gray-800 p-4 rounded text-white">
      <p>Subtotal: R$ <span x-text="subtotal.toFixed(2)"></span></p>
      <p>Frete:    R$ <span x-text="frete.toFixed(2)"></span></p>
      <p>Total:    R$ <span x-text="total.toFixed(2)"></span></p>
    </div>
  </div>
@endif

    {{-- Componente Alpine --}}
    <script>
      function cartComponent() {
        return {
          items: [],
          subtotal: 0,
          frete: 0,
          total: 0,
          recentlyAddedId: null,

          init(serverItems, s, f, t) {
            this.items = serverItems
            this.subtotal = s
            this.frete = f
            this.total = t
            const added = sessionStorage.getItem('lastAddedId');
            if (added) {
              this.recentlyAddedId = parseInt(added);
              sessionStorage.removeItem('lastAddedId');
            }
          },

          async atualizar(id, delta) {
            try {
              const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

              const res = await fetch('/carrinho/atualizar', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ id, delta })
              })
              if (!res.ok) throw new Error
              const data = await res.json()
              this._refresh(data)
            } catch {
              alert('Erro ao atualizar quantidade.')
            }
          },

          async remover(id) {
            try {
              const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

              const res = await fetch('/carrinho/remover', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ id })
              })
              if (!res.ok) throw new Error
              const data = await res.json()
              this._refresh(data)
            } catch {
              alert('Erro ao remover item.')
            }
          },

          _refresh(data) {
            // reaplica tudo vindo do servidor
            this.items    = data.items
            this.subtotal = data.subtotal
            this.frete    = data.frete
            this.total    = data.total
          }
        }
      }
    </script>

@endsection
