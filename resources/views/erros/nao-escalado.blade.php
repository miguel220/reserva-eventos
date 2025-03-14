<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro de Confirmação</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen">
        <div class="p-6 max-w-md w-full bg-white shadow-md rounded-lg text-center">
            <h1 class="text-3xl font-semibold mb-4 text-red-600">Erro</h1>
            <p class="text-gray-700 mb-4">Você não está escalado para este evento.</p>
            @if (session('error'))
                <p class="text-red-500">{{ session('error') }}</p>
            @endif
            <a href="/" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Voltar à Página Inicial</a>
        </div>
    </div>
</body>
</html>