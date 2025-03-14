<?php
namespace App\Http\Controllers;

use App\Mail\ChurchPaymentEmail;
use App\Mail\ResponsibleNotificationEmail;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventoDia;
use App\Models\Presenca;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

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
            'promo_price' => 'nullable|numeric|min:0|lt:price',
            'promo_start_date' => 'nullable|date|required_with:promo_price',
            'promo_end_date' => 'nullable|date|after:promo_start_date|required_with:promo_price',
            'responsible' => 'nullable|exists:users,id', // Validação para ID de usuário
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
            'promo_price' => $request->promo_price,
            'promo_start_date' => $request->promo_start_date,
            'promo_end_date' => $request->promo_end_date,
            'responsible' => $request->responsible,
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
            'promo_price' => 'nullable|numeric|min:0|lt:price',
            'promo_start_date' => 'nullable|date|required_with:promo_price',
            'promo_end_date' => 'nullable|date|after:promo_start_date|required_with:promo_price',
            'responsible' => 'nullable|exists:users,id',
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
            'promo_price' => $request->promo_price,
            'promo_start_date' => $request->promo_start_date,
            'promo_end_date' => $request->promo_end_date,
            'responsible' => $request->responsible,
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
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:presencas,email|max:255',
            'equipe_id' => 'required|exists:equipes,id', // Adicionado
        ]);
        
        $presenca = Presenca::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'contact_number' => $request->contact_number ?? null,
            'equipe_id' => $request->equipe_id, // Associar equipe
            'evento_id' => $evento->id,
            'confirmado' => true,
            'created_at' => now(),
        ]);

        // Enviar e-mail para o participante
        Mail::to($request->email)->send(new ChurchPaymentEmail($evento, $request->nome, $evento->responsibleUser->name ?? 'Não Informado', $evento->responsibleUser->phone_number ?? 'Não Informado'));

        // Enviar e-mail para o responsável
        if ($evento->responsible) {
            Mail::to($evento->responsibleUser->email)->send(new ResponsibleNotificationEmail(
                $evento,
                $request->nome,
                $request->email,
                $request->contact_number
            ));
        }

        return redirect()->back()->with('success', 'Presença confirmada! Um e-mail com as instruções de pagamento na igreja foi enviado para ' . $request->email);
    }
}

