<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function events()
    {
        $eventos = Evento::with(['dias' => function ($query) {
            $query->orderBy('data', 'asc');
        }])->whereNull('deleted_at')->get(); // Apenas eventos não excluídos

        return view('admin.events', compact('eventos'));
    }

    public function createEvent()
    {
        return view('admin.events_create');
    }

    public function listarPresencas(Evento $evento)
    {
        if ($evento->trashed()) { // Verifica se o evento está excluído logicamente
            return redirect()->route('admin.events')->with('error', 'Este evento foi excluído.');
        }
        $evento->load('presencas');
        return view('admin.events_presencas', compact('evento'));
    }

    // Métodos para Usuários
    public function users()
    {
        $users = User::whereNull('deleted_at')->get(); // Apenas usuários não excluídos
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users_create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuário criado com sucesso!');
    }

    public function editUser(User $user)
    {
        if ($user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'Este usuário foi excluído.');
        }
        return view('admin.users_edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroyUser(User $user)
    {
        $user->delete(); // Exclusão lógica
        return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso!');
    }

}