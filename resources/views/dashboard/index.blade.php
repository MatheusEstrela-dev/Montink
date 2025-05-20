@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar lateral --}}
    <aside class="w-64 bg-white shadow-md p-4">
        <h2 class="text-2xl font-bold text-center mb-6"><Marquee></Marquee>Montink</h2>

        <nav class="flex flex-col gap-2">
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
                   class="flex items-center gap-2 px-3 py-2 rounded {{ $moduloAtual === $modulo ? 'bg-blue-500 text-white' : 'hover:bg-blue-100 text-gray-700' }}">
                    <span class="text-xl">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 text-red-600 hover:text-red-700 text-sm">
                ⛔️ Sair
            </button>
        </form>
    </aside>

    {{-- Conteúdo central --}}
    <main class="flex-1 p-8">
        <div class="max-w-xl mx-auto">
            <div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6">
                <input type="text" placeholder="Procurar no módulo {{ ucfirst($modulo) }}..."
                       class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none" />
                <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                </svg>
            </div>

            @foreach ($itens as $item)
                <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-3">
                    <span class="text-gray-800">{{ $item }}</span>
                    <div class="flex gap-2">
                        <button class="text-yellow-500 hover:text-yellow-600">✏️</button>
                        <button class="text-red-500 hover:text-red-600">❌</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection
