@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Usuários</h1>
    </div>

    <div class="mb-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Lista de Usuários</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Adicionar Usuário</a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Nome</th>
                        <th class="py-2 px-4 border-b text-left">E-mail</th>
                        <th class="py-2 px-4 border-b text-left">Telefone</th>
                        <th class="py-2 px-4 border-b text-left">Admin</th>
                        <th class="py-2 px-4 border-b text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->phone_number ?? 'Não informado' }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->is_admin ? 'Sim' : 'Não' }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection