<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PixConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $pixKey;
    public $nome;

    /**
     * Create a new message instance.
     */
    public function __construct($evento, $pixKey, $nome)
    {
        $this->evento = $evento;
        $this->pixKey = $pixKey;
        $this->nome = $nome;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmação de Presença - Pagamento via Pix')
                    ->view('emails.pix_confirmation');
    }
}