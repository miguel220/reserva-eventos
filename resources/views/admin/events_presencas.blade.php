@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Presenças - {{ $evento->nome }}</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Lista de Presenças</h2>
            <div>
                <a href="{{ route('admin.events') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Voltar aos Eventos</a>
                <a href="{{ route('admin.presencas.export', $evento) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Exportar para Excel</a>
            </div>
        </div>

        <!-- Campo de Pesquisa -->
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.events.presencas', $evento) }}" class="flex items-center">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request()->get('search') }}" 
                    placeholder="Pesquisar por nome..." 
                    class="w-full md:w-1/3 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Pesquisar
                </button>
            </form>
        </div>

        <div class="mb-4">
            <p class="text-gray-700 text-lg font-semibold">Total de Presenças Confirmadas: {{ $presencas->total() }}</p>
        </div>

        @if ($presencas->isEmpty())
            <p class="text-gray-600">Nenhuma presença confirmada para este evento ou correspondente à pesquisa.</p>
        @else
            <form method="POST" action="{{ route('admin.presencas.update.payment.statuses', $evento) }}" id="paymentStatusForm">
                @csrf

                <div class="mb-4">
                    <label for="payment_status" class="block text-gray-700 text-sm font-bold mb-2">Alterar Status de Pagamento para Selecionados</label>
                    <select 
                        id="payment_status" 
                        class="w-full md:w-1/3 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_status') border-red-500 @enderror" 
                        name="payment_status" 
                        required 
                    >
                        <option value="pending">Pendente</option>
                        <option value="paid">Pago</option>
                        <option value="failed">Falhou</option>
                    </select>
                    <button 
                        type="submit" 
                        class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Atualizar Status de Pagamento
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.presencas.update.attendance.statuses', $evento) }}" id="attendanceStatusForm">
                @csrf

                <div class="mb-4">
                    <label for="attendance_status" class="block text-gray-700 text-sm font-bold mb-2">Alterar Status de Presença para Selecionados</label>
                    <select 
                        id="attendance_status" 
                        class="w-full md:w-1/3 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('attendance_status') border-red-500 @enderror" 
                        name="attendance_status" 
                        required 
                    >
                        <option value="absent">Ausente</option>
                        <option value="present">Presente</option>
                    </select>
                    <button 
                        type="submit" 
                        class="mt-2 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >
                        Atualizar Status de Presença
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.presencas.update.attendance.days', $evento) }}" id="attendanceDaysForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alterar Dias de Presença para Selecionados</label>
                    @if ($evento->dias->isNotEmpty())
                        <div class="mb-2">
                            @foreach ($evento->dias as $dia)
                                <label class="inline-flex items-center mr-4">
                                    <input type="checkbox" name="attendance_days[]" value="{{ $dia->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2">{{ $dia->data->format('d/m/Y') }} - {{ $dia->hora_inicio }} às {{ $dia->hora_fim }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">Nenhum dia definido para este evento.</p>
                    @endif
                    <button 
                        type="submit" 
                        class="mt-2 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800"
                    >
                        Atualizar Dias de Presença
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.presencas.update.equipe', $evento) }}" id="equipeForm">
                @csrf

                <div class="mb-4">
                    <label for="equipe_id" class="block text-gray-700 text-sm font-bold mb-2">Alterar Equipe para Selecionados</label>
                    <select 
                        id="equipe_id" 
                        class="w-full md:w-1/3 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('equipe_id') border-red-500 @enderror" 
                        name="equipe_id" 
                        required 
                    >
                        <option value="">Selecione uma equipe</option>
                        @foreach ($equipes as $equipe)
                            <option value="{{ $equipe->id }}">{{ $equipe->nome }}</option>
                        @endforeach
                    </select>
                    <button 
                        type="submit" 
                        class="mt-2 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800"
                    >
                        Atualizar Equipe
                    </button>
                </div>
            </form>

            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">
                            <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-blue-600">
                        </th>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Nome</th>
                        <th class="py-2 px-4 border-b text-left">E-mail</th>
                        <th class="py-2 px-4 border-b text-left">Número de Contato</th>
                        <th class="py-2 px-4 border-b text-left">Forma de Pagamento</th>
                        <th class="py-2 px-4 border-b text-left">Status do Pagamento</th>
                        <th class="py-2 px-4 border-b text-left">Status de Presença</th>
                        <th class="py-2 px-4 border-b text-left">Dias de Presença</th>
                        <th class="py-2 px-4 border-b text-left">Equipe</th>
                        <th class="py-2 px-4 border-b text-left">Confirmado</th>
                        <th class="py-2 px-4 border-b text-left">Data de Confirmação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presencas as $presenca)
                        <tr>
                            <td class="py-2 px-4 border-b">
                                <input type="checkbox" name="presenca_ids[]" value="{{ $presenca->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="py-2 px-4 border-b">{{ $presenca->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->nome }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->contact_number ?? 'Não informado' }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->payment_method ? ucfirst($presenca->payment_method) : 'Não informado' }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->payment_status ? ucfirst($presenca->payment_status) : 'Não informado' }}</td>
                            <td class="py-2 px-4 border-b">
                                {{ $presenca->attendance_status ? ucfirst($presenca->attendance_status) : 'Não informado' }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                @if ($presenca->attendance_days)
                                    @foreach ($presenca->attendance_days as $dayId)
                                        @php
                                            $day = $evento->dias->where('id', $dayId)->first();
                                        @endphp
                                        @if ($day)
                                            {{ $day->data->format('d/m/Y') }} - {{ $day->hora_inicio }} às {{ $day->hora_fim }}<br>
                                        @endif
                                    @endforeach
                                @else
                                    Não informado
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">
                                {{ $presenca->equipe ? $presenca->equipe->nome : 'Não atribuído' }}
                            </td>
                            <td class="py-2 px-4 border-b">{{ $presenca->confirmado ? 'Sim' : 'Não' }}</td>
                            <td class="py-2 px-4 border-b">{{ $presenca->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Links de Paginação -->
            <div class="mt-4">
                {{ $presencas->appends(['search' => request()->get('search')])->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="presenca_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection