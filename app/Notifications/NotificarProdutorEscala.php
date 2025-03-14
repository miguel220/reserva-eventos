<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotificarProdutorEscala extends Notification
{
    use Queueable;

    protected $escala;
    protected $voluntario;
    protected $confirmado;
    protected $motivo;

    public function __construct($escala, $voluntario, $confirmado, $motivo = null)
    {
        $this->escala = $escala;
        $this->voluntario = $voluntario;
        $this->confirmado = $confirmado;
        $this->motivo = $motivo;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Atualização de Confirmação de Voluntário')
            ->view('emails.notificacao-produtor', [
                'notifiable' => $notifiable,
                'voluntario' => $this->voluntario,
                'confirmado' => $this->confirmado,
                'motivo' => $this->motivo,
                'escala' => $this->escala,
            ]);
    }
}