<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação Enviada</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen">
        <div class="p-6 max-w-md w-full bg-white shadow-md rounded-lg text-center">
            <h1 class="text-3xl font-semibold mb-4 text-green-600">Obrigado!</h1>
            <p class="text-gray-700 mb-4">Sua confirmação foi enviada com sucesso.</p>
            @if (session('success'))
                <p class="text-green-500">{{ session('success') }}</p>
            @endif
        </div>
    </div>
</body>
</html>