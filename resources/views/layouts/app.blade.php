<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Montink ERP</title>

  {{-- Tailwind (dev) --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- aqui entrará o CSS do Leaflet ou outros estilos que você 'push' --}}
  @stack('styles')

  @livewireStyles
</head>
<body class="h-screen overflow-hidden bg-gray-100 text-gray-900 antialiased">

  {{-- Flex container full-height --}}
  <div class="flex h-full">
    {{-- Sidebar fixa full-height --}}
    @include('dashboard.sidebar')

    {{-- Main scrollável internamente --}}
    <main class="flex-1 h-full overflow-y-auto p-8">
      @yield('content')
    </main>
  </div>

  @livewireScripts

  {{-- Alpine deve vir depois --}}
  <script src="https://unpkg.com/alpinejs" defer></script>

  {{-- aqui entrarão os scripts do Leaflet e do seu componente Alpine --}}
  @stack('scripts')
</body>
</html>
