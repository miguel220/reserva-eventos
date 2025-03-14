<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
        
        return (new MailMessage)
            ->subject('Verifique Seu Endereço de E-mail')
            ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
            ->action('Verificar E-mail', $verificationUrl)
            ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.')
            ->view('vendor.notifications.email', ['notifiable' => $notifiable, 'url' => $verificationUrl]);
    }
}