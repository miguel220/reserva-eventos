@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-semibold mb-4">Minhas Escalas</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-xl font-semibold mb-4">Escalas Atribuídas</h2>
        @if ($escalas->isEmpty())
            <p class="text-gray-600">Você não está escalado para nenhum evento no momento.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Evento</th>
                        <th class="py-2 px-4 border-b text-left">Data</th>
                        <th class="py-2 px-4 border-b text-left">Setor</th>
                        <th class="py-2 px-4 border-b text-left">Voluntários</th>
                        <th class="py-2 px-4 border-b text-left">Status de Confirmação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($escalas as $escala)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $escala->evento->nome }}</td>
                            <td class="py-2 px-4 border-b">{{ $escala->data->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b">{{ $escala->setor->nome }}</td>
                            <td class="py-2 px-4 border-b">
                                @foreach ($escala->voluntarios as $voluntario)
                                    {{ $voluntario->name }} ({{ $voluntario->setor->nome ?? 'Sem setor' }})<br>
                                @endforeach
                            </td>
                            <td class="py-2 px-4 border-b">
                                @foreach ($escala->voluntarios as $voluntario)
                                    @if ($voluntario->pivot->confirmado === null)
                                        <span class="text-yellow-600">Aguardando Confirmação ({{ $voluntario->name }})</span><br>
                                    @elseif ($voluntario->pivot->confirmado)
                                        <span class="text-green-600">Confirmado ({{ $voluntario->name }})</span><br>
                                    @else
                                        <span class="text-red-600">Recusado ({{ $voluntario->name }}) - Motivo: {{ $voluntario->pivot->motivo_ausencia ?? 'Não informado' }}</span><br>
                                    @endif
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