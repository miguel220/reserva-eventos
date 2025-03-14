<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureEmailVerifiedUnlessSeeder
{
    public function handle(Request $request, Closure $next)
    {
        // Se a rota atual é a de verificação, permitir acesso sem redirecionar
        if ($request->route()->named('verification.notice')) {
            return $next($request);
        }
        
        $user = Auth::user();
        
        if ($user && !$user->hasVerifiedEmail() && !$user->is_seeder) {
            // Armazena o tempo de início da sessão não verificada
            if (!Session::has('verification_start_time')) {
                Session::put('verification_start_time', now());
            }

            // Define o tempo limite (ex.: 30 segundos)
            $timeout = 30; // Em segundos
            $startTime = Session::get('verification_start_time');
            $elapsedTime = now()->diffInSeconds($startTime);

            if ($elapsedTime >= $timeout) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('error', 'Sua sessão foi encerrada devido à falta de confirmação de e-mail.');
            }

            // Redireciona para a página de verificação
            return redirect()->route('verification.notice')
                ->with('error', 'Você deve verificar seu e-mail antes de continuar. Verifique sua caixa de entrada ou clique para reenviar o e-mail. A sessão será encerrada em ' . ($timeout - $elapsedTime) . ' segundos.');
        }

        // Limpa o temporizador se o e-mail for verificado
        if ($user && $user->hasVerifiedEmail()) {
            Session::forget('verification_start_time');
        }

        return $next($request);
    }

}