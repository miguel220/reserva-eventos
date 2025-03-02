@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('Reset Password') }}</h2>

        <div class="w-full">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                
                <div class="mb-4 flex flex-col md:flex-row md:items-center">
                    <label for="email" class="md:w-1/3 text-gray-700 text-sm font-bold mb-2 md:mb-0 md:text-right md:pr-4">{{ __('Email Address') }}</label>
                    <div class="md:w-2/3">
                        <input 
                            id="email" 
                            type="email" 
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                            name="email" 
                            value="{{ $email ?? old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                        >
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Campo Senha -->
                <div class="mb-4 flex flex-col md:flex-row md:items-center">
                    <label for="password" class="md:w-1/3 text-gray-700 text-sm font-bold mb-2 md:mb-0 md:text-right md:pr-4">{{ __('Password') }}</label>
                    <div class="md:w-2/3">
                        <input 
                            id="password" 
                            type="password" 
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                        >
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Campo Confirmação de Senha -->
                <div class="mb-6 flex flex-col md:flex-row md:items-center">
                    <label for="password-confirm" class="md:w-1/3 text-gray-700 text-sm font-bold mb-2 md:mb-0 md:text-right md:pr-4">{{ __('Confirm Password') }}</label>
                    <div class="md:w-2/3">
                        <input 
                            id="password-confirm" 
                            type="password" 
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                        >
                    </div>
                </div>
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 text-red-500">TESTESTAASDFASDFASDF</h2>
                <!-- Botão de Envio -->
                <div class="flex justify-center md:justify-start md:pl-1/3">
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection