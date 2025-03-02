<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventoDia;
use App\Models\Presenca;

class EventoController extends Controller
{
    public function index()
    {
        return Evento::all();
    }

    public function show($id)
    {
        return Evento::findOrFail($id);
    }

    public function deleteEvent(Evento $evento)
    {
        $evento->delete();
    
        return redirect()->route('admin.events')->with('success', 'Evento excluído com sucesso!');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'vagas' => 'required|integer|min:1',
            'imagem' => 'nullable|image|max:2048',
            'dias' => 'required|array|min:1',
            'dias.*.data' => 'required|date',
            'dias.*.hora_inicio' => 'required',
            'dias.*.hora_fim' => 'required|after:dias.*.hora_inicio',
            'is_paid' => 'required|boolean',
            'price' => 'required_if:is_paid,1|nullable|numeric|min:0',
        ]);

        $imagemPath = $request->hasFile('imagem') ? $request->file('imagem')->store('eventos', 'public') : null;

        $evento = Evento::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'vagas' => $request->vagas,
            'imagem' => $imagemPath,
            'token' => \Str::random(32),
            'is_paid' => $request->is_paid,
            'price' => $request->is_paid ? $request->price : null,
        ]);

        foreach ($request->dias as $dia) {
            EventoDia::create([
                'evento_id' => $evento->id,
                'data' => $dia['data'],
                'hora_inicio' => $dia['hora_inicio'],
                'hora_fim' => $dia['hora_fim'],
            ]);
        }

        return redirect()->route('admin.events')->with('success', 'Evento adicionado com sucesso!');
    }

    public function editEvent(Evento $evento)
    {
        $evento->load('dias'); // Carrega os dias relacionados
        return view('admin.events_edit', compact('evento'));
    }

    public function updateEvent(Request $request, Evento $evento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'vagas' => 'required|integer|min:1',
            'imagem' => 'nullable|image|max:2048',
            'dias' => 'required|array|min:1',
            'dias.*.data' => 'required|date',
            'dias.*.hora_inicio' => 'required',
            'dias.*.hora_fim' => 'required|after:dias.*.hora_inicio',
            'is_paid' => 'required|boolean',
            'price' => 'required_if:is_paid,1|nullable|numeric|min:0',
        ]);

        if ($request->hasFile('imagem')) {
            if ($evento->imagem && \Storage::disk('public')->exists($evento->imagem)) {
                \Storage::disk('public')->delete($evento->imagem);
            }
            $imagemPath = $request->file('imagem')->store('eventos', 'public');
        } else {
            $imagemPath = $evento->imagem;
        }

        $evento->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'vagas' => $request->vagas,
            'imagem' => $imagemPath,
            'token' => $evento->token ?? \Str::random(32),
            'is_paid' => $request->is_paid,
            'price' => $request->is_paid ? $request->price : null,
        ]);

        $evento->dias()->delete();
        foreach ($request->dias as $dia) {
            EventoDia::create([
                'evento_id' => $evento->id,
                'data' => $dia['data'],
                'hora_inicio' => $dia['hora_inicio'],
                'hora_fim' => $dia['hora_fim'],
            ]);
        }

        return redirect()->route('admin.events')->with('success', 'Evento atualizado com sucesso!');
    }

    public function confirmarPresenca(Evento $evento, $token)
    {
        if ($evento->token !== $token || $evento->trashed()) {
            abort(403, 'Link de confirmação inválido ou evento não encontrado.');
        }
        return view('eventos.confirmar-presenca', compact('evento', 'token'));
    }

    public function storePresenca(Request $request, Evento $evento, $token)
    {
        if ($evento->token !== $token || $evento->trashed()) {
            abort(403, 'Link de confirmação inválido ou evento não encontrado.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:presencas,email',
        ]);

        Presenca::create([
            'evento_id' => $evento->id,
            'nome' => $request->nome,
            'email' => $request->email,
            'confirmado' => true,
        ]);

        return redirect()->back()->with('success', 'Presença confirmada com sucesso!');
    }
}

