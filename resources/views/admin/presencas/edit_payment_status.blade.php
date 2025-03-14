@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Editar Status de Pagamento</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Atualizar Status de Pagamento para {{ $presenca->nome }}</h2>
        <form method="POST" action="{{ route('admin.presencas.update.payment.status', $presenca) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="payment_status" class="block text-gray-700 text-sm font-bold mb-2">Status de Pagamento</label>
                <select 
                    id="payment_status" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_status') border-red-500 @enderror" 
                    name="payment_status" 
                    required 
                >
                    <option value="pendente" {{ old('payment_status', $presenca->payment_status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="pago" {{ old('payment_status', $presenca->payment_status) === 'pago' ? 'selected' : '' }}>Pago</option>
                    <option value="falhou" {{ old('payment_status', $presenca->payment_status) === 'falhou' ? 'selected' : '' }}>Falhou</option>
                </select>
                @error('payment_status')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Atualizar Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection