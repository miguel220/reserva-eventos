@extends('layouts.app-login')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white shadow-md rounded-lg text-center">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Link de Redefinição Enviado</h1>
        @if (session('status'))
            <p class="text-green-600 mb-4">{{ session('status') }}</p>
        @endif
        <p class="text-gray-700 mb-4">Verifique seu e-mail para encontrar o link de redefinição de senha. Se não o encontrar, verifique sua pasta de spam.</p>
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Voltar ao Login</a>
    </div>
</div>
@endsection