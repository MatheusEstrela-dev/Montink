<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montink ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">
    <div class="flex min-h-screen">
        @include('dashboard.sidebar') {{-- Fixo no layout --}}
        <main class="flex-1 p-8">
            @yield('content') {{-- Só atualiza a parte central --}}
        </main>
    </div>
    @livewireScripts
</body>
</html>
