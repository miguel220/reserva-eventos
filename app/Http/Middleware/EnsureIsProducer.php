<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsProducer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->is_producer) {
            return redirect()->route('login')->with('error', 'Acesso não autorizado. Você precisa ser um Produtor de Escala.');
        }

        return $next($request);
    }
}