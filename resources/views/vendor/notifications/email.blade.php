<!-- resources/views/vendor/notifications/email.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Verifique Seu Endereço de E-mail</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { background-color: #4B5563; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .footer { font-size: 12px; color: #666; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifique Seu Endereço de E-mail</h1>
 
        @if(isset($notifiable) && $notifiable->name)
            <p>Olá {{ $notifiable->name }}!</p>
        @else
            <p>Olá!</p>
        @endif

        <p>Seu e-mail ainda não foi confirmado. Por favor, clique no link ou botão abaixo para verificar seu endereço de e-mail e ativar sua conta.</p>

        @if(isset($url))
            <p><a href="{{ $url }}" class="button">Verificar E-mail</a></p>
            <p>Ou copie e cole este link no seu navegador: <a href="{{ $url }}">{{ $url }}</a></p>
        @else
            <p style="color: red;">Erro: Link de verificação não disponível. Entre em contato com o suporte.</p>
        @endif

        <p>Se você não criou uma conta, nenhuma ação adicional é necessária.</p>

        <div class="footer">
            Atenciosamente,<br>
            {{ config('app.name') }}
        </div>
    </div>
</body>
</html>