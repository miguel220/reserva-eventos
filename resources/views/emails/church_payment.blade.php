<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Presença - {{ $evento->nome }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">

        @if ($evento->imagem)
            <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->nome }}" style="max-width: 100%; height: auto; border-radius: 5px; margin: 10px 0;">
        @else
            <p style="text-align: center; color: #7f8c8d;">Sem imagem disponível</p>
        @endif

        <h1 style="text-align: center; color: #2c3e50;">Confirmação de Presença</h1>
        
        <p>Olá, {{ $nome }}!</p>
        
        <p>Você confirmou sua presença no evento abaixo. O pagamento deve ser realizado na igreja diretamente com o responsável:</p>
        <p>Ou via Pix: eventoscasadeadoracao@gmail.com</p>
        
        <h2 style="color: #2c3e50;">Evento: {{ $evento->nome }}</h2>
        
        <p><strong>Descrição:</strong> {{ $evento->descricao }}</p>

        <p><strong>Dias do Evento:</strong></p>
        @if ($evento->dias->isNotEmpty())
            <ul style="list-style-type: disc; padding-left: 20px; color: #333;">
                @foreach ($evento->dias as $dia)
                    <li>{{ $dia->data->format('d/m/Y') }} - {{ $dia->hora_inicio }} às {{ $dia->hora_fim }}</li>
                @endforeach
            </ul>
        @else
            <p style="color: #7f8c8d;">Sem datas definidas</p>
        @endif
        
        <p><strong>Preço:</strong> 
            @if ($evento->is_paid)
                @if ($evento->promo_price && $evento->promo_start_date && $evento->promo_end_date && now()->between($evento->promo_start_date, $evento->promo_end_date))
                    <span style="color: #27ae60;">R$ {{ number_format($evento->promo_price, 2, ',', '.') }} (Promoção até {{ $evento->promo_end_date->format('d/m/Y H:i') }})</span>
                    <br><span style="text-decoration: line-through; color: #7f8c8d;">R$ {{ number_format($evento->price, 2, ',', '.') }}</span>
                @else
                    R$ {{ number_format($evento->price, 2, ',', '.') }}
                @endif
            @else
                Gratuito
            @endif
        </p>
        
        <p><strong>Responsável:</strong> {{ $responsible ?? 'Não informado' }}</p>
        <p><strong>Contato do Responsável:</strong> {{ $phone_number ?? 'Não informado' }}</p>
        
        <p>Por favor, entre em contato com o responsável para confirmar o pagamento na igreja.</p>
        <p>Se foi realizado via Pix o pagamento, encaminhar o comprovante no Whatsap do responsavel. Se houver dúvidas, entre em contato conosco.</p>
        
        <p style="text-align: center; color: #7f8c8d;">Atenciosamente,<br>Equipe do Sistema de Eventos</p>
    </div>
</body>
</html>