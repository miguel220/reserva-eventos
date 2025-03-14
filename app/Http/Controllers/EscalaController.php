<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Escala;
use App\Models\Setor;
use App\Models\User;
use App\Notifications\ConfirmarPresencaVoluntario;
use App\Notifications\NotificarProdutorEscala;

class EscalaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'producer'])->except(['confirmar', 'responder']);
        $this->middleware(['signed'])->only(['confirmar']);
    }

    public function index()
    {
        $eventos = Evento::all();
        return view('escalas.index', compact('eventos'));
    }

    public function create(Evento $evento)
    {
        $setores = Setor::all();

        // Buscar todos os voluntários (usuários com setor_id não nulo) e agrupá-los por setor
        $voluntariosPorSetor = User::whereNotNull('setor_id')
            ->with('setor')
            ->get()
            ->groupBy('setor_id');

        // Buscar as datas do evento
        $datasEvento = $evento->dias()->pluck('data')->toArray();

        return view('escalas.create', compact('evento', 'setores', 'voluntariosPorSetor', 'datasEvento'));
    }

    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'data' => 'required|date',
            'voluntarios' => 'required|array|min:1',
            'voluntarios.*.*' => 'exists:users,id',
        ]);

        // Verificar se pelo menos 1 voluntário foi selecionado
        $totalVoluntarios = 0;
        foreach ($request->voluntarios as $setorId => $voluntarios) {
            $totalVoluntarios += count(array_filter($voluntarios));
        }
        if ($totalVoluntarios === 0) {
            return redirect()->back()->withErrors(['voluntarios' => 'Selecione pelo menos 1 voluntário.']);
        }

        // Criar uma escala para cada setor que tiver voluntários selecionados
        foreach ($request->voluntarios as $setorId => $voluntariosSelecionados) {
            $voluntariosSelecionados = array_filter($voluntariosSelecionados);
            if (empty($voluntariosSelecionados)) {
                continue;
            }

            $escala = Escala::create([
                'evento_id' => $evento->id,
                'data' => $request->data,
                'setor_id' => $setorId,
            ]);

            $escala->voluntarios()->attach($voluntariosSelecionados);

            // Enviar e-mails de confirmação para os voluntários
            foreach ($voluntariosSelecionados as $voluntarioId) {
                $voluntario = User::find($voluntarioId);
                $voluntario->notify(new ConfirmarPresencaVoluntario($escala, $voluntario));
            }
        }

        return redirect()->route('escalas.index')->with('success', 'Escala(s) criada(s) com sucesso! E-mails de confirmação foram enviados.');
    }

    public function edit(Evento $evento, Escala $escala)
    {
        $setores = Setor::all();
        $voluntarios = User::whereNotNull('setor_id')->get();
        return view('escalas.edit', compact('evento', 'escala', 'setores', 'voluntarios'));
    }

    public function update(Request $request, Evento $evento, Escala $escala)
    {
        $request->validate([
            'data' => 'required|date',
            'setor_id' => 'required|exists:setores,id',
            'voluntario_id_1' => 'required|exists:users,id',
            'voluntario_id_2' => 'nullable|exists:users,id|different:voluntario_id_1',
        ]);

        $escala->update([
            'data' => $request->data,
            'setor_id' => $request->setor_id,
            'voluntario_id_1' => $request->voluntario_id_1,
            'voluntario_id_2' => $request->voluntario_id_2,
            'confirmado_voluntario_1' => null,
            'motivo_ausencia_1' => null,
            'confirmado_voluntario_2' => null,
            'motivo_ausencia_2' => null,
        ]);

        // Enviar e-mails de confirmação para os voluntários
        if ($escala->voluntario1) {
            $escala->voluntario1->notify(new ConfirmarPresencaVoluntario($escala, 1));
        }
        if ($escala->voluntario2) {
            $escala->voluntario2->notify(new ConfirmarPresencaVoluntario($escala, 2));
        }

        return redirect()->route('escalas.index')->with('success', 'Escala atualizada com sucesso! E-mails de confirmação foram enviados.');
    }

    public function consultar()
    {
        $user = auth()->user();

        // Verificar se o usuário é um produtor
        if ($user->is_producer) {
            // Se for produtor, buscar todas as escalas
            $escalas = Escala::with(['evento', 'setor', 'voluntarios' => function ($query) {
                $query->withPivot('confirmado', 'motivo_ausencia'); // Carregar colunas da tabela pivô
            }])
            ->get();
        } else {
            // Se não for produtor, buscar apenas as escalas onde o usuário é voluntário
            $escalas = Escala::whereHas('voluntarios', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['evento', 'setor', 'voluntarios' => function ($query) {
                $query->withPivot('confirmado', 'motivo_ausencia'); // Carregar colunas da tabela pivô
            }])
            ->get();
        }

        return view('escalas.consultar', compact('escalas'));
    }

    public function confirmar(Request $request, Escala $escala, User $voluntario)
    {
        // Verificar se o voluntário está associado à escala
        if (!$escala->voluntarios()->where('user_id', $voluntario->id)->exists()) {
            return redirect()->route('erro')->with('error', 'Você não está escalado para este evento.');
        }

        return view('escalas.confirmar', compact('escala', 'voluntario'));
    }

    public function responder(Request $request, Escala $escala, User $voluntario)
    {
        $request->validate([
            'confirmado' => 'required|boolean',
            'motivo' => 'required_if:confirmado,0|string|max:500|nullable',
        ]);

        // Verificar se o voluntário está associado à escala
        if (!$escala->voluntarios()->where('user_id', $voluntario->id)->exists()) {
            return redirect()->route('erro')->with('error', 'Você não está escalado para este evento.');
        }

        // Atualizar a confirmação na tabela pivô
        $escala->voluntarios()->updateExistingPivot($voluntario->id, [
            'confirmado' => $request->confirmado,
            'motivo_ausencia' => $request->confirmado ? null : $request->motivo,
        ]);

        // Enviar e-mail ao Produtor de Escala
        $produtores = User::where('is_producer', true)->get();
        foreach ($produtores as $produtor) {
            $produtor->notify(new NotificarProdutorEscala($escala, $voluntario, $request->confirmado, $request->motivo));
        }

        return redirect()->route('obrigado')->with('success', 'Confirmação enviada com sucesso!');
    }
}