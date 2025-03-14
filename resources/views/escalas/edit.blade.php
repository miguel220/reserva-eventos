@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-semibold mb-4">Editar Escala para {{ $evento->nome }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('escalas.update', [$evento, $escala]) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="data" class="block text-gray-700 text-sm font-bold mb-2">Data</label>
            <input type="date" name="data" id="data" value="{{ old('data', $escala->data) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data') border-red-500 @enderror" required>
            @error('data')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="setor_id" class="block text-gray-700 text-sm font-bold mb-2">Setor</label>
            <select name="setor_id" id="setor_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('setor_id') border-red-500 @enderror" required>
                <option value="">Selecione um Setor</option>
                @foreach ($setores as $setor)
                    <option value="{{ $setor->id }}" {{ old('setor_id', $escala->setor_id) == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                @endforeach
            </select>
            @error('setor_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="voluntario_id_1" class="block text-gray-700 text-sm font-bold mb-2">Voluntário 1</label>
            <select name="voluntario_id_1" id="voluntario_id_1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('voluntario_id_1') border-red-500 @enderror" required>
                <option value="">Selecione um Voluntário</option>
                @foreach ($voluntarios as $voluntario)
                    <option value="{{ $voluntario->id }}" {{ old('voluntario_id_1', $escala->voluntario_id_1) == $voluntario->id ? 'selected' : '' }}>{{ $voluntario->name }} ({{ $voluntario->setor->nome }})</option>
                @endforeach
            </select>
            @error('voluntario_id_1')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="voluntario_id_2" class="block text-gray-700 text-sm font-bold mb-2">Voluntário 2 (Opcional)</label>
            <select name="voluntario_id_2" id="voluntario_id_2" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('voluntario_id_2') border-red-500 @enderror">
                <option value="">Nenhum</option>
                @foreach ($voluntarios as $voluntario)
                    <option value="{{ $voluntario->id }}" {{ old('voluntario_id_2', $escala->voluntario_id_2) == $voluntario->id ? 'selected' : '' }}>{{ $voluntario->name }} ({{ $voluntario->setor->nome }})</option>
                @endforeach
            </select>
            @error('voluntario_id_2')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Atualizar Escala
        </button>
        <a href="{{ route('escalas.index') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            Voltar
        </a>
    </form>
</div>
@endsection