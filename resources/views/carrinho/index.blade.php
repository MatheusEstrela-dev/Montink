@extends('layouts.app')
@section('content')

  {{-- … outras seções (pedidos, produtos, estoque etc) … --}}

  @if($modulo === 'carrinho')
    <div
      x-data="cartComponent()"
      x-init="init(@json($items), {{ $subtotal }}, {{ $frete }}, {{ $total }})"
      class="space-y-4"
    >
      <h2 class="text-2xl font-semibold mb-4">🛒 Módulo do Carrinho</h2>

      {{-- Lista de itens --}}
      <template x-for="item in items" :key="item.produto.id">
        <div class="flex justify-between bg-gray-800 p-4 rounded text-white">
          <div>
            <p class="font-bold" x-text="item.produto.nome"></p>
            <p>R$ <span x-text="item.produto.preco.toFixed(2)"></span>
              × <span x-text="item.quantidade"></span>
              = R$ <span x-text="item.subtotal.toFixed(2)"></span>
            </p>
          </div>
          <div class="flex items-center space-x-2">
            <button @click="atualizar(item.produto.id, -1)" class="px-2">–</button>
            <button @click="atualizar(item.produto.id, +1)" class="px-2">+</button>
            <button @click="remover(item.produto.id)" class="px-2 text-red-400">❌</button>
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

    {{-- Componente Alpine --}}
    <script>
      function cartComponent() {
        return {
          items: [],
          subtotal: 0,
          frete: 0,
          total: 0,

          init(serverItems, s, f, t) {
            this.items = serverItems
            this.subtotal = s
            this.frete = f
            this.total = t
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
  @endif

@endsection
