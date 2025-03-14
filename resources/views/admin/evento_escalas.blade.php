@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-semibold mb-4">Escalas - {{ $evento->nome }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Lista de Escalas</h2>
            <a href="{{ route('admin.events') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Voltar aos Eventos</a>
        </div>

        @if ($escalas->isEmpty())
            <p class="text-gray-600">Nenhuma escala definida para este evento.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Data</th>
                        <th class="py-2 px-4 border-b text-left">Setor</th>
                        <th class="py-2 px-4 border-b text-left">Voluntários</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($escalas as $escala)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $escala->data->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b">{{ $escala->setor->nome }}</td>
                            <td class="py-2 px-4 border-b">
                                @foreach ($escala->voluntarios as $voluntario)
                                    {{ $voluntario->name }} ({{ $voluntario->setor->nome }}):
                                    @if (is_null($voluntario->pivot->confirmado))
                                        Aguardando Confirmação
                                    @elseif ($voluntario->pivot->confirmado)
                                        Confirmado
                                    @else
                                        Recusado (Motivo: {{ $voluntario->pivot->motivo_ausencia ?? 'Não informado' }})
                                    @endif
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection