@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Editar Evento</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Editar Evento</h2>
        <form method="POST" action="{{ route('admin.events.update', $evento) }}" id="eventoForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome do Evento</label>
                <input 
                    id="nome" 
                    type="text" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-500 @enderror" 
                    name="nome" 
                    value="{{ old('nome', $evento->nome) }}" 
                    required 
                >
                @error('nome')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                <textarea 
                    id="descricao" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @enderror" 
                    name="descricao" 
                    rows="4"
                >{{ old('descricao', $evento->descricao) }}</textarea>
                @error('descricao')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="imagem" class="block text-gray-700 text-sm font-bold mb-2">Imagem do Evento</label>
                @if ($evento->imagem)
                    <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->nome }}" class="w-32 h-32 object-cover mb-2">
                @endif
                <input 
                    id="imagem" 
                    type="file" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('imagem') border-red-500 @enderror" 
                    name="imagem" 
                    accept="image/*" 
                >
                @error('imagem')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="vagas" class="block text-gray-700 text-sm font-bold mb-2">Número de Vagas</label>
                <input 
                    id="vagas" 
                    type="number" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('vagas') border-red-500 @enderror" 
                    name="vagas" 
                    value="{{ old('vagas', $evento->vagas) }}" 
                    min="1" 
                    required 
                >
                @error('vagas')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="is_paid" class="block text-gray-700 text-sm font-bold mb-2">Evento Pago?</label>
                <select 
                    id="is_paid" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('is_paid') border-red-500 @enderror" 
                    name="is_paid" 
                    required 
                    onchange="togglePriceField(this)"
                >
                    <option value="0" {{ old('is_paid', $evento->is_paid) == 0 ? 'selected' : '' }}>Gratuito</option>
                    <option value="1" {{ old('is_paid', $evento->is_paid) == 1 ? 'selected' : '' }}>Pago</option>
                </select>
                @error('is_paid')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4" id="price_field" style="display: {{ old('is_paid', $evento->is_paid) == 1 ? 'block' : 'none' }};">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Preço (R$)</label>
                <input 
                    id="price" 
                    type="number" 
                    step="0.01" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror" 
                    name="price" 
                    value="{{ old('price', $evento->price) }}" 
                    min="0" 
                    {{ old('is_paid', $evento->is_paid) == 1 ? 'required' : '' }}
                >
                @error('price')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div id="diasContainer" class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Dias do Evento</h3>
                @foreach ($evento->dias as $index => $dia)
                    <div class="dia-item mb-4" data-index="{{ $index }}">
                        <div class="flex flex-col md:flex-row md:space-x-4 items-end">
                            <div class="flex-1">
                                <label for="data_{{ $index }}" class="block text-gray-700 text-sm font-bold mb-2">Data</label>
                                <input 
                                    type="date" 
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error("dias.$index.data") border-red-500 @enderror" 
                                    name="dias[{{ $index }}][data]" 
                                    value="{{ old("dias.$index.data", $dia->data->format('Y-m-d')) }}" 
                                    required 
                                >
                                @error("dias.$index.data")
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="hora_inicio_{{ $index }}" class="block text-gray-700 text-sm font-bold mb-2">Hora de Início</label>
                                <input 
                                    type="time" 
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error("dias.$index.hora_inicio") border-red-500 @enderror" 
                                    name="dias[{{ $index }}][hora_inicio]" 
                                    value="{{ old("dias.$index.hora_inicio", $dia->hora_inicio) }}" 
                                    required 
                                >
                                @error("dias.$index.hora_inicio")
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="hora_fim_{{ $index }}" class="block text-gray-700 text-sm font-bold mb-2">Hora de Fim</label>
                                <input 
                                    type="time" 
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error("dias.$index.hora_fim") border-red-500 @enderror" 
                                    name="dias[{{ $index }}][hora_fim]" 
                                    value="{{ old("dias.$index.hora_fim", $dia->hora_fim) }}" 
                                    required 
                                >
                                @error("dias.$index.hora_fim")
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4 md:mt-0">
                                <button type="button" class="remove-dia text-white bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline {{ $index === 0 && $evento->dias->count() === 1 ? 'hidden' : '' }}">Remover</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-6">
                <button 
                    type="button" 
                    id="addDia" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Adicionar Outro Dia
                </button>
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Atualizar Evento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let diaCount = {{ $evento->dias->count() }};

    function togglePriceField(select) {
        const priceField = document.getElementById('price_field');
        const priceInput = document.getElementById('price');
        if (select.value == '1') {
            priceField.style.display = 'block';
            priceInput.required = true;
        } else {
            priceField.style.display = 'none';
            priceInput.required = false;
            priceInput.value = '';
        }
    }

    document.getElementById('addDia').addEventListener('click', function() {
        const container = document.getElementById('diasContainer');
        const newDia = document.createElement('div');
        newDia.classList.add('dia-item', 'mb-4');
        newDia.setAttribute('data-index', diaCount);
        newDia.innerHTML = `
            <div class="flex flex-col md:flex-row md:space-x-4 items-end">
                <div class="flex-1">
                    <label for="data_${diaCount}" class="block text-gray-700 text-sm font-bold mb-2">Data</label>
                    <input 
                        type="date" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        name="dias[${diaCount}][data]" 
                        required 
                    >
                </div>
                <div class="flex-1">
                    <label for="hora_inicio_${diaCount}" class="block text-gray-700 text-sm font-bold mb-2">Hora de Início</label>
                    <input 
                        type="time" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        name="dias[${diaCount}][hora_inicio]" 
                        required 
                    >
                </div>
                <div class="flex-1">
                    <label for="hora_fim_${diaCount}" class="block text-gray-700 text-sm font-bold mb-2">Hora de Fim</label>
                    <input 
                        type="time" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        name="dias[${diaCount}][hora_fim]" 
                        required 
                    >
                </div>
                <div class="mt-4 md:mt-0">
                    <button type="button" class="remove-dia text-white bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Remover</button>
                </div>
            </div>
        `;
        container.appendChild(newDia);
        diaCount++;
        updateRemoveButtons();
    });

    document.getElementById('diasContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-dia')) {
            e.target.closest('.dia-item').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const diaItems = document.querySelectorAll('.dia-item');
        if (diaItems.length > 1) {
            diaItems.forEach(item => {
                item.querySelector('.remove-dia').classList.remove('hidden');
            });
        } else {
            diaItems[0].querySelector('.remove-dia').classList.add('hidden');
        }
    }

    updateRemoveButtons();
</script>
@endsection