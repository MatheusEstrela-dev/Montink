<div class="space-y-3">
    <h1 class="text-gray-800 text-xl font-bold mb-4">👤 Lista de Usuários</h1>

    @forelse ($itens as $usuario)
        <div class="flex justify-between items-center bg-white p-4 rounded shadow">
            <span class="text-gray-800 font-medium">{{ $usuario->nome }}</span>
            <span class="text-sm text-gray-500">{{ $usuario->email }}</span>
            <div class="flex gap-2">
                <button class="text-yellow-500 hover:text-yellow-600">✏️</button>
                <button class="text-red-500 hover:text-red-600">❌</button>
            </div>
        </div>
    @empty
        <div class="text-gray-500 italic">Nenhum usuário encontrado.</div>
    @endforelse
</div>
