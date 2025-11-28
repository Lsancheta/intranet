<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acesso Negado</title>

    <!-- Tailwind via CDN (funciona em erro 403) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-sm text-center">
        <h1 class="text-5xl font-bold text-red-600">403</h1>

        <h2 class="text-xl font-semibold mt-3 text-gray-700">
            Acesso Negado
        </h2>

        <p class="text-gray-600 mt-2">
            Você não tem permissão para acessar esta página.
        </p>

        <a href="{{ url()->previous() }}"
           class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            Voltar
        </a>
    </div>

</body>
</html>
