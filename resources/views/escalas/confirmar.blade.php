<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Presença</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen">
        <div class="p-6 max-w-md w-full bg-white shadow-md rounded-lg">
            <h1 class="text-3xl font-semibold text-center mb-6">Confirmar Presença</h1>

            <div class="text-center">
                <h2 class="text-xl font-semibold mb-4">Evento: {{ $escala->evento->nome }}</h2>
                <p class="mb-2"><strong>Data:</strong> {{ $escala->data->format('d/m/Y') }}</p>
                <p class="mb-4"><strong>Setor:</strong> {{ $escala->setor->nome }}</p>
            </div>

            <form method="POST" action="{{ route('escalas.responder', ['escala' => $escala->id, 'voluntario' => $voluntario->id]) }}" class="space-y-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2 text-center">Você poderá comparecer?</label>
                    <div class="flex justify-center space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="confirmado" value="1" class="form-radio text-blue-600" required>
                            <span class="ml-2">Sim</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="confirmado" value="0" class="form-radio text-blue-600" required>
                            <span class="ml-2">Não</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4" id="motivo-ausencia" style="display: none;">
                    <label for="motivo" class="block text-gray-700 text-sm font-bold mb-2 text-center">Motivo da Ausência</label>
                    <textarea name="motivo" id="motivo" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Explique o motivo da sua ausência" rows="4"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="confirmado"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                document.getElementById('motivo-ausencia').style.display = this.value == '0' ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>