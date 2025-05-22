<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('{{ asset('images/montink-bg.png') }}') no-repeat center center fixed;
            background-size: cover;
            background-color: #000; /* fallback */
        }

        .login-form {
            background-color: rgba(0, 0, 0, 0.7); /* para destacar o formulário sobre o fundo */
            padding: 2rem;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">

    <form method="POST" action="{{ route('login.perform') }}" class="login-form w-96">
        @csrf
        <h1 class="text-2xl font-bold mb-4 text-center text-white">Login</h1>

        @if ($errors->any())
            <div class="bg-red-100 p-2 mb-4 rounded text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <label class="block mb-2 text-white">Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded mb-4" required>

        <label class="block mb-2 text-white">Senha</label>
        <input type="password" name="password" class="w-full border p-2 rounded mb-4" required>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Entrar</button>
    </form>

    {{-- Rodapé --}}
    <footer class="mt-10 text-sm text-gray-500 text-center">
        Desenvolvido por <strong>Matheus Estrela</strong> · 💻 TI & Inovação · 📍 Belo Horizonte – MG <br>
        🔗 <a href="https://www.linkedin.com/in/matheus-estrela-32072a104/" target="_blank" class="text-blue-600 hover:underline">
            LinkedIn
        </a>
        ·
        🔗 <a href="https://github.com/MatheusEstrela-dev" target="_blank" class="text-gray-800 hover:underline">
            GitHub
        </a>
    </footer>

</body>
</html>
