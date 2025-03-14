<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Confirmação de Presença - {{ $evento->nome }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">

        @if ($evento->imagem)
            <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->nome }}" style="max-width: 100%; height: auto; border-radius: 5px; margin: 10px 0;">
        @else
            <p style="text-align: center; color: #7f8c8d;">Sem imagem disponível</p>
        @endif

        <h1 style="text-align: center; color: #2c3e50;">Nova Confirmação de Presença</h1>
        
        <p>Olá, {{ $evento->responsibleUser->name ?? 'Responsável' }}!</p>
        
        <p>Uma nova pessoa confirmou presença no evento "{{ $evento->nome }}". Aqui estão os detalhes:</p>
        
        <p><strong>Descrição do Evento:</strong> {{ $evento->descricao }}</p>
        
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
        
        <h3 style="color: #2c3e50;">Dados do Participante:</h3>
        <p><strong>Nome:</strong> {{ $participantName }}</p>
        <p><strong>E-mail:</strong> {{ $participantEmail }}</p>
        <p><strong>Número de Contato:</strong> {{ $participantContact ?? 'Não informado' }}</p>
        
        <p><strong>Seus Contatos:</strong></p>
        <p><strong>E-mail:</strong> {{ $evento->responsibleUser->email ?? 'Não informado' }}</p>
        <p><strong>Telefone:</strong> {{ $responsiblePhone ?? 'Não informado' }}</p>
        
        <p>Por favor, entre em contato com o participante, se necessário, para confirmar o pagamento ou outras informações. Se houver dúvidas, entre em contato conosco.</p>
        
        <p style="text-align: center; color: #7f8c8d;">Atenciosamente,<br>Equipe do Sistema de Eventos</p>
    </div>
</body>
</html>