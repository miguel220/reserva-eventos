<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChurchPaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $nome;
    public $responsible;
    public $phone_number;

    /**
     * Create a new message instance.
     */
    public function __construct($evento, $nome, $responsible, $phone_number)
    {
        $this->evento = $evento;
        $this->nome = $nome;
        $this->responsible = $responsible;
        $this->phone_number = $phone_number;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmação de Presença')
                    ->view('emails.church_payment');
    }
}