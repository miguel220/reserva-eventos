<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1f2937; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        a { color: #2563eb; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Redefinir Senha</h1>

        <p class="text-gray-700 mb-4">Olá{{ isset($notifiable->name) ? ' ' . $notifiable->name : '' }},</p>

        <p class="text-gray-700 mb-4">Você recebeu este e-mail porque foi solicitada uma redefinição de senha para sua conta.</p>

        @if(isset($actionUrl))
            <div class="text-center mb-6">
                <a href="{{ $actionUrl }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Redefinir Senha</a>
            </div>
            <p class="text-gray-700 mb-4">Ou copie e cole este link no seu navegador: <a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
        @else
            <p class="text-red-600 mb-4">Erro: Link de redefinição não disponível. Entre em contato com o suporte.</p>
        @endif

        <p class="text-gray-700 mb-4">Este link de redefinição expirará em {{ config('auth.passwords.users.expire') }} minutos.</p>

        <p class="text-gray-700">Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>

        <p class="text-gray-700 text-center mt-6">Atenciosamente,<br><span class="font-semibold">{{ config('app.name') }}</span></p>
    </div>
</body>
</html>