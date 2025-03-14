<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Presença no Evento</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { background-color: #4B5563; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .footer { font-size: 12px; color: #666; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmação de Presença no Evento</h1>

        @if(isset($notifiable) && $notifiable->name)
            <p>Olá {{ $notifiable->name }}!</p>
        @else
            <p>Olá!</p>
        @endif

        <p>Você foi escalado para o evento <strong>{{ $escala->evento->nome }}</strong> no dia {{ $escala->data->format('d/m/Y') }} no setor {{ $escala->setor->nome }}.</p>

        <p>Por favor, confirme sua presença clicando no botão abaixo:</p>

        @if(isset($confirmationUrl))
            <p><a href="{{ $confirmationUrl }}" class="button">Confirmar Presença</a></p>
            <p>Ou copie e cole este link no seu navegador: <a href="{{ $confirmationUrl }}">{{ $confirmationUrl }}</a></p>
        @else
            <p style="color: red;">Erro: Link de confirmação não disponível. Entre em contato com o suporte.</p>
        @endif

        <p>O link expira em 24 horas. Se você não puder comparecer, poderá informar o motivo na próxima tela.</p>

        <p>Atenciosamente,<br>
        {{ config('app.name') }}</p>

        <div class="footer">
            Entre em contato conosco em support@exemplo.com
        </div>
    </div>
</body>
</html>
