<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResponsibleNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $participantName;
    public $participantEmail;
    public $participantContact;
    public $responsibleUser; // Mudar para o objeto User

    /**
     * Create a new message instance.
     */
    public function __construct($evento, $participantName, $participantEmail, $participantContact, $responsibleId = null)
    {
        $this->evento = $evento;
        $this->participantName = $participantName;
        $this->participantEmail = $participantEmail;
        $this->participantContact = $participantContact;
        $this->responsibleUser = $responsibleId ? User::find($responsibleId) : null; // Carregar o usuário pelo ID
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $responsibleEmail = $this->responsibleUser ? $this->responsibleUser->email : 'responsavel@exemplo.com';
        $responsiblePhone = $this->responsibleUser ? $this->responsibleUser->phone_number : 'Não informado';

        return $this->to($responsibleEmail)
                    ->subject('Nova Confirmação de Presença - ' . $this->evento->nome)
                    ->view('emails.responsible_notification')
                    ->with([
                        'responsiblePhone' => $responsiblePhone,
                    ]);
    }
}