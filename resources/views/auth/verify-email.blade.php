<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar E-mail</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .countdown {
            font-weight: bold;
            color: #dc2626;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Verificar Seu E-mail</h1>
        <p class="text-gray-600 text-center mb-4">
            Antes de prosseguir, por favor, verifique seu e-mail clicando no link de confirmação que enviamos. Verifique sua caixa de entrada ou pasta de spam.
            <br><br>
            Se você não recebeu o e-mail,
            <!-- Formulário de Reenvio do Email -->
            <form method="POST" action="{{ route('verification.resend') }}" class="text-center">
                @csrf
                <button 
                    type="submit" 
                    id="resendButton" 
                    class="bg-blue-500 text-white m-3 px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ session('wait_time') ? 'disabled' : '' }}>
                    Clique aqui para reenviar
                </button>
            </form>
        </p>
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('wait_time'))
            <p class="text-center text-gray-600 mt-2">
                Tempo restante: <span class="countdown" id="timer">{{ session('wait_time') }}</span> segundos.
            </p>
            <script>
                let timeLeft = {{ session('wait_time') }};
                const timerElement = document.getElementById('timer');
                const resendButton = document.getElementById('resendButton');

                const countdown = setInterval(() => {
                    if (timeLeft > 0) {
                        timeLeft--;
                        timerElement.textContent = timeLeft;
                    } else {
                        clearInterval(countdown);
                        timerElement.textContent = '0';
                        resendButton.disabled = false;
                    }
                }, 1000);
            </script>
        @endif
    </div>
</body>
</html>