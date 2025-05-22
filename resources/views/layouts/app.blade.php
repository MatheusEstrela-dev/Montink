<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montink ERP</title>

    {{-- Tailwind via CDN (ambiente de desenvolvimento) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Livewire estilos --}}
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    {{-- Container principal --}}
    <div class="flex min-h-screen">
        @include('dashboard.sidebar') {{-- Menu lateral fixo --}}
        <main class="flex-1 p-8">
            @yield('content') {{-- Renderiza o conteúdo principal --}}
        </main>
    </div>

    {{-- Livewire scripts --}}
    @livewireScripts

    {{-- Alpine.js (depois do Livewire!) --}}
    <script src="https://unpkg.com/alpinejs" defer></script>

    {{-- DEBUG opcional: verificar se Alpine está carregando --}}
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('✅ AlpineJS carregado corretamente!');
        });
    </script>
</body>
</html>
