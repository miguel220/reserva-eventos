<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = \App\Providers\RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return route('admin.dashboard');
        }
        return \App\Providers\RouteServiceProvider::HOME;
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $attempts = session()->get('email_verification_attempts', 0);
            $waitTime = $this->calculateWaitTime($attempts);

            session(['email_verification_attempts' => $attempts + 1]);
            session(['wait_time' => $waitTime]);

            return redirect()->route('verification.notice')->with('wait_time', $waitTime);
        }

        return redirect()->intended($this->redirectTo);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function calculateWaitTime($attempts)
    {
        // Tempo inicial de 30 segundos, dobrando a cada tentativa
        return pow(2, $attempts) * 30; // 30s, 60s, 120s, etc.
    }
}
