@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-semibold mb-4">Gerenciar Escalas</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Eventos</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Nome do Evento</th>
                        <th class="py-2 px-4 border-b text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventos as $evento)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $evento->nome }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('escalas.create', $evento) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">
                                    Adicionar Escala
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
