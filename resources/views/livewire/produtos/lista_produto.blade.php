<h1 class="text-white text-2xl mb-4">🎁 Lista de Produtos</h1>

{{-- Barra de pesquisa --}}
<div class="flex items-center bg-white shadow rounded px-4 py-2 mb-6">
    <input type="text" placeholder="Procurar produtos..."
        class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none" />
    <svg class="ml-2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
    </svg>
</div>

{{-- Lista de produtos --}}
@foreach ($itens as $produto)
    <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-3">
        <span class="text-gray-800 font-medium">{{ $produto }}</span>
        <div class="flex gap-2">
            <button class="text-yellow-500 hover:text-yellow-600">✏️</button>
            <button class="text-red-500 hover:text-red-600">❌</button>
        </div>
    </div>
@endforeach
