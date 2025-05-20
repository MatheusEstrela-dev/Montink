<div class="w-64 bg-white shadow-md flex flex-col justify-between h-screen">
    {{-- Topo com título --}}
    <div>
        <h2 class="text-center text-2xl font-bold py-6 text-gray-800">ERP</h2>

        {{-- Navegação --}}
        <nav class="flex flex-col gap-3 px-4">
            @php
                $moduloAtual = request('modulo');
                $menus = [
                    'pedidos' => ['📦', 'Pedidos'],
                    'produtos' => ['🎁', 'Produtos'],
                    'cupons' => ['🛍️', 'Cupons'],
                    'estoque' => ['🏷️', 'Estoque'],
                    'usuarios' => ['👤', 'Usuários'],
                ];
            @endphp

            @foreach ($menus as $modulo => [$icon, $label])
                <a href="{{ route('dashboard', ['modulo' => $modulo]) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg relative transition-all duration-150 ease-in-out
                          {{ $moduloAtual === $modulo
                              ? 'bg-blue-500 text-white shadow-md'
                              : 'bg-gray-100 text-gray-700 hover:bg-blue-100' }}">
                    {{-- Indicador lateral do ativo --}}
                    @if ($moduloAtual === $modulo)
                        <div class="absolute left-0 top-0 h-full w-1 bg-blue-700 rounded-r"></div>
                    @endif

                    <span class="text-xl">{{ $icon }}</span>
                    <span class="font-semibold">{{ $label }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Rodapé com avatar e botão de logout --}}
    <div class="p-4 flex flex-col items-center gap-3">
        <div class="rounded-full w-12 h-12 bg-gray-200 flex items-center justify-center text-gray-600 text-xl">
            👤
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium">
                ⛔ <span>Sair</span>
            </button>
        </form>
    </div>
</div>
