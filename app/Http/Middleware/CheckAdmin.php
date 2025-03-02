<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Opcional: Verificar se é admin
        if (Auth::user()->is_admin != 1) {
            return redirect('/teste1')->with('error', 'Acesso não autorizado');
        }
        
        return $next($request);
    }
}