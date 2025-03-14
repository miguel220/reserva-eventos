<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class ConfirmarPresencaVoluntario extends Notification
{
    use Queueable;

    protected $escala;
    protected $voluntario;

    public function __construct($escala, $voluntario)
    {
        $this->escala = $escala;
        $this->voluntario = $voluntario;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $confirmationUrl = URL::temporarySignedRoute(
            'escalas.confirmar',
            now()->addHours(24),
            [
                'escala' => $this->escala->id,
                'voluntario' => $this->voluntario->id,
            ]
        );

        return (new MailMessage)
            ->subject('Confirmação de Presença no Evento')
            ->view('emails.confirmacao-voluntario', [
                'notifiable' => $notifiable,
                'escala' => $this->escala,
                'confirmationUrl' => $confirmationUrl
            ]);
    }
}