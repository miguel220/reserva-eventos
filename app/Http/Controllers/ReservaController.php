<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Reserva::where('user_id', Auth::id())->with('evento')->get();
    }

    public function store($id)
    {
        $evento = Evento::findOrFail($id);

        // Verifica se já fez reserva para este evento
        if (Reserva::where('user_id', Auth::id())->where('evento_id', $id)->exists()) {
            return response()->json(['error' => 'Você já reservou este evento'], 403);
        }

        // Verifica se ainda há vagas
        if ($evento->vagas <= 0) {
            return response()->json(['error' => 'Não há mais vagas disponíveis'], 403);
        }

        // Criar a reserva
        Reserva::create([
            'evento_id' => $id,
            'user_id' => Auth::id()
        ]);

        // Reduz uma vaga no evento
        $evento->decrement('vagas');

        return response()->json(['message' => 'Reserva realizada com sucesso!']);
    }
}

