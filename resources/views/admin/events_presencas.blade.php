@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Presenças - {{ $evento->nome }}</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Lista de Presenças</h2>
            <a href="{{ route('admin.events') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Voltar aos Eventos</a>
        </div>

        <!-- Total de Presenças Confirmadas -->
        <div class="mb-4">
            <p class="text-gray-700 text-lg font-semibold">Total de Presenças Confirmadas: {{ $evento->presencas->where('confirmado', true)->count() }}</p>
        </div>

        @if ($evento->presencas->isEmpty())
            <p class="text-gray-600">Nenhuma presença confirmada para este evento.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Nome</th>
                        <th class="py-2 px-4 border-b text-left">E-mail</th>
                        <th class="py-2 px-4 border-b text-left">Confirmado</th>
                        <th class="py-2 px-4 border-b text-left">Data de Confirmação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evento->presencas as $presenca)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $presenca->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->nome }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->confirmado ? 'Sim' : 'Não' }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection