<div class="w-64 bg-white shadow-md flex flex-col justify-between h-full">

  {{-- Logo + menu --}}
  <div>
    <h2 class="text-center text-2xl font-bold py-6 text-gray-800">Montink</h2>
    <nav class="flex flex-col gap-3 px-4">
      @php
        $moduloAtual = request('modulo');
        $menus = [
          'pedidos'  => ['📦','Pedidos'],
          'produtos' => ['🎁','Produtos'],
          'cupons'   => ['🛍️','Cupons'],
          'estoques' => ['🏷️','Estoque'],
          'usuarios' => ['👤','Usuários'],
          'carrinho' => ['🛒','Carrinho'],
          'cepmapa'  => ['🗺️','Verificar CEP'],
        ];
      @endphp

      @foreach($menus as $modulo => [$icon,$label])
        <button
          onclick="if('{{ $moduloAtual }}'!=='{{ $modulo }}') window.location='{{ route('dashboard',['modulo'=>$modulo]) }}'"
          class="flex items-center gap-3 w-full px-4 py-3 rounded-lg transition
                 {{ $moduloAtual=== $modulo
                     ? 'bg-blue-500 text-white shadow'
                     : 'bg-gray-100 text-gray-700 hover:bg-blue-100' }}">
          <span class="text-xl">{{ $icon }}</span>
          <span class="font-semibold">{{ $label }}</span>
        </button>
      @endforeach
    </nav>
  </div>

  {{-- Rodapé fixo da sidebar --}}
  <div class="p-4 bg-gray-800 text-gray-300 flex flex-col items-center gap-3">
    {{-- Avatar --}}
    <div class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center text-white text-xl">
      👤
    </div>
    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="w-full">
      @csrf
      <button
        type="submit"
        class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2 rounded-md transition"
      >
        {{-- Heroicon Logout --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V7" />
        </svg>
        <span>Sair</span>
      </button>
    </form>
  </div>
</div>
