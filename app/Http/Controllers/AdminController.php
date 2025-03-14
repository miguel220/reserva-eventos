<?php

namespace App\Http\Controllers;

use App\Exports\PresencasExport;
use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Presenca;
use App\Models\Setor;
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
        $users = User::whereNull('deleted_at')->get();
        return view('admin.users.users_list', compact('users'));
    }

    public function createUser()
    {
        $setores = Setor::all();
        return view('admin.users.users_create', compact('setores'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'is_producer' => 'required|boolean',
            'setor_id' => 'nullable|exists:setores,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
            'is_producer' => $request->is_producer,
            'setor_id' => $request->setor_id,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('admin.users')->with('success', 'Usuário criado com sucesso! Um e-mail de confirmação foi enviado para ' . $request->email);
    }

    public function editUser(User $user)
    {
        if ($user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'Este usuário foi excluído.');
        }
        $setores = Setor::all();
        return view('admin.users.users_edit', compact('user', 'setores'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'is_producer' => 'required|boolean',
            'setor_id' => 'nullable|exists:setores,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'is_admin' => $request->is_admin,
            'is_producer' => $request->is_producer,
            'setor_id' => $request->setor_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroyUser(User $user)
    {
        $user->delete(); // Exclusão lógica
        return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso!');
    }

    public function editPaymentStatus(Presenca $presenca)
    {
        return view('admin.presencas.edit_payment_status', compact('presenca'));
    }

    public function updatePaymentStatus(Request $request, Presenca $presenca)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed', // Status possíveis
        ]);

        $presenca->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.events.presencas', $presenca->evento_id)->with('success', 'Status de pagamento atualizado com sucesso!');
    }

    public function updatePaymentStatuses(Request $request, Evento $evento)
    {
        
        $request->validate([
            'presenca_ids' => 'required|array',
            'presenca_ids.*' => 'exists:presencas,id',
            'payment_status' => 'required|in:pendente,pago,falhou',
        ]);
        
        Presenca::whereIn('id', $request->presenca_ids)->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.events.presencas', $evento)->with('success', 'Status de pagamento atualizado com sucesso para as presenças selecionadas!');
    }

    public function updateAttendanceStatuses(Request $request, Evento $evento)
    {
        $request->validate([
            'presenca_ids' => 'required|array',
            'presenca_ids.*' => 'exists:presencas,id',
            'attendance_status' => 'required|in:presente,ausente',
        ]);

        Presenca::whereIn('id', $request->presenca_ids)->update([
            'attendance_status' => $request->attendance_status,
        ]);

        return redirect()->route('admin.events.presencas', $evento)->with('success', 'Status de presença atualizado com sucesso para as presenças selecionadas!');
    }

    public function updateAttendanceDays(Request $request, Evento $evento)
    {
        $request->validate([
            'presenca_ids' => 'required|array',
            'presenca_ids.*' => 'exists:presencas,id',
            'attendance_days' => 'required|array',
        ]);

        $attendanceDays = array_filter($request->attendance_days, function ($day) {
            return !empty($day); // Remove valores vazios
        });

        Presenca::whereIn('id', $request->presenca_ids)->update([
            'attendance_days' => $attendanceDays,
        ]);

        return redirect()->route('admin.events.presencas', $evento)->with('success', 'Dias de presença atualizados com sucesso para as presenças selecionadas!');
    }

    public function showPresencas(Evento $evento, Request $request)
    {
        $query = $evento->presencas()->where('confirmado', true);

        // Filtrar por nome, se fornecido
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        // Paginar os resultados
        $presencas = $query->paginate(10);

        // Obter todas as equipes
        $equipes = Equipe::all();

        return view('admin.events_presencas', compact('evento', 'presencas', 'equipes'));
    }

    public function exportPresencas(Evento $evento)
    {
        $export = new PresencasExport($evento->id);
        return $export->export();
    }

    public function updateEquipe(Request $request, Evento $evento)
    {
        $request->validate([
            'equipe_id' => 'required|exists:equipes,id',
            'presenca_ids' => 'required|array',
            'presenca_ids.*' => 'exists:presencas,id',
        ]);

        $presencas = Presenca::whereIn('id', $request->presenca_ids)->where('evento_id', $evento->id)->get();
        foreach ($presencas as $presenca) {
            $presenca->update(['equipe_id' => $request->equipe_id]);
        }

        return redirect()->back()->with('success', 'Equipes atualizadas com sucesso!');
    }

    public function showEscalas(Evento $evento)
    {
        $escalas = $evento->escalas()->with(['setor', 'voluntario1', 'voluntario2'])->get();
        $setores = Setor::all();
        return view('admin.evento_escalas', compact('evento', 'escalas', 'setores'));
    }

}