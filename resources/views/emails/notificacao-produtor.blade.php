<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Confirmação de Voluntário</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Inclui o CSS do Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Inclui o JavaScript do Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- Inclui o CSS do Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> <!-- Inclui o JavaScript do Select2 -->
    <style>
        /* Estilos inline para garantir consistência no e-mail */
        body {
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        a {
            color: #2563eb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Atualização de Confirmação de Voluntário</h1>

        <p class="text-gray-700 mb-4">Olá <span class="font-semibold">{{ $notifiable->name }}</span>,</p>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <p class="text-gray-700">O voluntário <span class="font-semibold">{{ $voluntario->name }}</span> {{ $confirmado ? 'confirmou' : 'recusou' }} sua presença no evento.</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Detalhes do Evento</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li><strong>Evento:</strong> {{ $escala->evento->nome }}</li>
                <li><strong>Data:</strong> {{ $escala->data->format('d/m/Y') }}</li>
                <li><strong>Setor:</strong> {{ $escala->setor->nome }}</li>
            </ul>
        </div>

        @if (!$confirmado && $motivo)
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Motivo da Ausência</h2>
                <p class="text-gray-700">{{ $motivo }}</p>
            </div>
        @endif

        <p class="text-gray-700 text-center mt-6">Atenciosamente,<br><span class="font-semibold">Sistema de Gerenciamento de Eventos</span></p>
    </div>
</body>
</html>