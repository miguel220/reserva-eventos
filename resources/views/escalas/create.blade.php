@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-semibold mb-4">Criar Escala para {{ $evento->nome }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('escalas.store', $evento) }}">
        @csrf
        <div class="mb-4">
            <label for="data" class="block text-gray-700 text-sm font-bold mb-2">Data do Evento</label>
            <select name="data" id="data" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data') border-red-500 @enderror" required>
                <option value="">Selecione uma Data</option>
                @foreach ($datasEvento as $data)
                    <option value="{{ $data->format('Y-m-d') }}" {{ old('data') == $data->format('Y-m-d') ? 'selected' : '' }}>
                        {{ $data->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
            @error('data')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Voluntários por Setor (Selecione pelo menos 1 voluntário)</h2>
            @foreach ($setores as $setor)
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">{{ $setor->nome }}</label>
                    <select name="voluntarios[{{$setor->id}}][]" multiple class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @if (isset($voluntariosPorSetor[$setor->id]))
                            @foreach ($voluntariosPorSetor[$setor->id] as $voluntario)
                                <option value="{{ $voluntario->id }}" {{ in_array($voluntario->id, old('voluntarios.' . $setor->id, [])) ? 'selected' : '' }}>
                                    {{ $voluntario->name }}
                                </option>
                            @endforeach
                        @else
                            <option disabled>Nenhum voluntário disponível neste setor</option>
                        @endif
                    </select>
                </div>
            @endforeach
            @error('voluntarios')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <p class="text-gray-600 text-sm mt-2">Segure Ctrl (ou Cmd no Mac) para selecionar múltiplos voluntários em cada setor.</p>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Criar Escala
        </button>
        <a href="{{ route('escalas.index') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            Voltar
        </a>
    </form>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('select[multiple]').select2({
                placeholder: "Selecione os voluntários",
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@endsection