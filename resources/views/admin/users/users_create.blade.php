@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-semibold mb-4">Criar Novo Usuário</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Número de Telefone</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone_number') border-red-500 @enderror">
            @error('phone_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirme a Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="is_admin" class="block text-gray-700 text-sm font-bold mb-2">Administrador?</label>
            <select name="is_admin" id="is_admin" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('is_admin') border-red-500 @enderror" required>
                <option value="0" {{ old('is_admin') == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('is_admin') == 1 ? 'selected' : '' }}>Sim</option>
            </select>
            @error('is_admin')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="is_producer" class="block text-gray-700 text-sm font-bold mb-2">Produtor de Escala?</label>
            <select name="is_producer" id="is_producer" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('is_producer') border-red-500 @enderror" required>
                <option value="0" {{ old('is_producer') == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('is_producer') == 1 ? 'selected' : '' }}>Sim</option>
            </select>
            @error('is_producer')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="setor_id" class="block text-gray-700 text-sm font-bold mb-2">Setor (Voluntário)</label>
            <select name="setor_id" id="setor_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('setor_id') border-red-500 @enderror">
                <option value="">Nenhum</option>
                @foreach ($setores as $setor)
                    <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                @endforeach
            </select>
            @error('setor_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Criar Usuário
        </button>
        <a href="{{ route('admin.users') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            Voltar
        </a>
    </form>
</div>
@endsection