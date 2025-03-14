<?php

namespace App\Services;

use Illuminate\Http\Request;

class EmailVerificationService
{
    public function resendVerificationEmail(Request $request)
    {
        dd("teste");
        // Enviar a notificação de verificação de e-mail
        $request->user()->sendEmailVerificationNotification();

        // Incrementar tentativas e calcular novo tempo de espera
        $attempts = session()->get('email_verification_attempts', 0);
        $waitTime = $this->calculateWaitTime($attempts);

        // Atualizar a sessão com as novas tentativas e tempo de espera
        session(['email_verification_attempts' => $attempts + 1]);
        session(['wait_time' => $waitTime]);

        // Retornar a resposta com a mensagem de sucesso e o tempo de espera
        return redirect()->back()
            ->with('success', 'Um novo e-mail de verificação foi enviado!')
            ->with('wait_time', $waitTime);
    }

    protected function calculateWaitTime($attempts)
    {
        // Tempo inicial de 30 segundos, dobrando a cada tentativa
        return pow(2, $attempts) * 30; // 30s, 60s, 120s, etc.
    }
}