@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Eventos</h1>
    </div>

    <div class="mb-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Lista de Eventos</h2>
            <a href="{{ route('admin.events.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Adicionar Evento</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eventos as $evento)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    @if ($evento->imagem)
                        <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->nome }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">Sem imagem</div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $evento->nome }}</h3>
                        <p class="text-gray-600 mb-2">
                            Início: 
                            @if ($evento->dias->isNotEmpty())
                                {{ $evento->dias->first()->data->format('d/m/Y') }} {{ $evento->dias->first()->hora_inicio }}
                            @else
                                Sem data
                            @endif
                        </p>
                        <p class="text-gray-600 mb-2">
                            Fim: 
                            @if ($evento->dias->isNotEmpty())
                                {{ $evento->dias->last()->data->format('d/m/Y') }} {{ $evento->dias->last()->hora_fim }}
                            @else
                                Sem data
                            @endif
                        </p>
                        <p class="text-gray-600 mb-2">
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
                        @php    
                            $responsavel = App\Models\User::findOrFail($evento->responsible);
                        @endphp 
                        <p class="text-gray-600 mb-2">
                            Responsável: {{$responsavel->name ?? 'Não informado';}}
                        </p>
                        <div class="flex justify-between items-center flex-wrap gap-2">
                            <div>
                                <a href="{{ route('admin.events.edit', $evento) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                <form action="{{ route('admin.events.destroy', $evento) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4" onclick="return confirm('Tem certeza que deseja excluir este evento?')">Excluir</button>
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('evento.confirmar.presenca', [$evento->id, $evento->token]) }}" class="text-green-500 hover:text-green-700" target="_blank">Compartilhar</a>
                                <a href="{{ route('admin.events.presencas', $evento) }}" class="text-purple-500 hover:text-purple-700 ml-4">Presenças</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection