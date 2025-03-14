<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Presença - {{ $evento->nome }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Confirmar Presença</h1>

        <div class="mb-6">
            @if ($evento->imagem)
                <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->nome }}" class="w-full h-48 object-cover rounded-lg mb-4">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg mb-4">Sem imagem</div>
            @endif
            <p class="text-gray-800 text-lg font-semibold text-center mb-2">Evento: {{ $evento->nome }}</p>
            <p class="text-gray-600 text-center mb-2">
                Preço: 
                @if ($evento->is_paid)
                    @if ($evento->promo_price && $evento->promo_start_date && $evento->promo_end_date && now()->between($evento->promo_start_date, $evento->promo_end_date))
                        <span class="text-green-600">R$ {{ number_format($evento->promo_price, 2, ',', '.') }} (Promoção até {{ $evento->promo_end_date->format('d/m/Y H:i') }})</span>
                        <br><span class="text-gray-500 line-through">R$ {{ number_format($evento->price, 2, ',', '.') }}</span>
                    @else
                        R$ {{ number_format($evento->price, 2, ',', '.') }}
                    @endif
                @else
                    Gratuito
                @endif
            </p>
            @if ($evento->dias->isNotEmpty())
                <p class="text-gray-600 text-center mb-2">
                    Início: {{ $evento->dias->first()->data->format('d/m/Y') }} às {{ $evento->dias->first()->hora_inicio }}
                </p>
                <p class="text-gray-600 text-center mb-4">
                    Fim: {{ $evento->dias->last()->data->format('d/m/Y') }} às {{ $evento->dias->last()->hora_fim }}
                </p>
                <div class="border-t pt-2">
                    <h3 class="text-gray-700 font-semibold mb-2">Dias do Evento:</h3>
                    <ul class="list-disc pl-5 text-gray-600">
                        @foreach ($evento->dias as $dia)
                            <li>{{ $dia->data->format('d/m/Y') }} - {{ $dia->hora_inicio }} às {{ $dia->hora_fim }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-600 text-center">Sem datas definidas</p>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('payment'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ $errors->first('payment') }}
            </div>
        @endif

        <form method="POST" action="{{ route('evento.store.presenca', [$evento->id, $token]) }}">
            @csrf

            <div class="mb-4">
                <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                <input 
                    id="nome" 
                    type="text" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-500 @enderror" 
                    name="nome" 
                    value="{{ old('nome') }}" 
                    required 
                >
                @error('nome')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                <input 
                    id="email" 
                    type="email" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                >
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact_number" class="block text-gray-700 text-sm font-bold mb-2">Número de Contato (Opcional)</label>
                <input 
                    id="contact_number" 
                    type="text" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contact_number') border-red-500 @enderror" 
                    name="contact_number" 
                    value="{{ old('contact_number') }}" 
                    placeholder="(XX) XXXX-XXXX"
                >
                @error('contact_number')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="equipe_id" class="block text-gray-700 text-sm font-bold mb-2">Equipe</label>
                <select name="equipe_id" id="equipe_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecione uma equipe</option>
                    @foreach (\App\Models\Equipe::all() as $equipe)
                        <option value="{{ $equipe->id }}">{{ $equipe->nome }}</option>
                    @endforeach
                </select>
            </div>

            @if ($evento->is_paid)
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 text-sm font-bold mb-2">Forma de Pagamento</label>
                    <select 
                        id="payment_method" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_method') border-red-500 @enderror" 
                        name="payment_method" 
                        required 
                    >
                        <option value="church" {{ old('payment_method') == 'church' ? 'selected' : '' }}>Na Igreja</option>
                        
                        {{-- <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online (Pix)</option> --}}
                        
                    </select>
                    @error('payment_method')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            @endif
            <div class="flex justify-center">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Confirmar Presença
                </button>
            </div>
        </form>
    </div>
</body>
</html>