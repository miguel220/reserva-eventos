<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\EscalaController;
use App\Http\Controllers\EventoController;
use App\Models\User;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/eventos'); // Usuários não-admin vão para a lista de eventos
    }
    return redirect('/login'); // Usuários não logados vão para o login
});

Auth::routes();

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
    Route::get('/admin/events/create', [AdminController::class, 'createEvent'])->name('admin.events.create');
    Route::post('/admin/events', [EventoController::class, 'storeEvent'])->name('admin.events.store');
    Route::delete('/admin/events/{evento}', [EventoController::class, 'deleteEvent'])->name('admin.events.destroy');
    Route::get('/admin/events/{evento}/edit', [EventoController::class, 'editEvent'])->name('admin.events.edit');
    Route::put('/admin/events/{evento}', [EventoController::class, 'updateEvent'])->name('admin.events.update');
    Route::get('/admin/events/{evento}/presencas', [AdminController::class, 'listarPresencas'])->name('admin.events.presencas');

    // Rotas para Presenças
    Route::get('/admin/presencas/{presenca}/edit-payment-status', [AdminController::class, 'editPaymentStatus'])->name('admin.presencas.edit.payment.status');
    Route::put('/admin/presencas/{presenca}/update-payment-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.presencas.update.payment.status');
    Route::post('/admin/events/{evento}/presencas/update-payment-statuses', [AdminController::class, 'updatePaymentStatuses'])->name('admin.presencas.update.payment.statuses');
    Route::get('/admin/events/{evento}/presencas', [AdminController::class, 'showPresencas'])->name('admin.events.presencas');
    Route::post('/admin/events/{evento}/presencas/update-attendance-statuses', [AdminController::class, 'updateAttendanceStatuses'])->name('admin.presencas.update.attendance.statuses');
    Route::post('/admin/events/{evento}/presencas/update-attendance-days', [AdminController::class, 'updateAttendanceDays'])->name('admin.presencas.update.attendance.days');
    Route::post('/admin/events/{evento}/presencas/update-equipe', [AdminController::class, 'updateEquipe'])->name('admin.presencas.update.equipe');

    // Rota para exportar presenças
    Route::get('/admin/events/{evento}/presencas/export', [AdminController::class, 'exportPresencas'])->name('admin.presencas.export');
});

Route::middleware(['auth', 'producer'])->group(function () {
    Route::get('/producao/escalas', [EscalaController::class, 'index'])->name('escalas.index');
    Route::get('/producao/escalas/{evento}/create', [EscalaController::class, 'create'])->name('escalas.create');
    Route::post('/producao/escalas/{evento}', [EscalaController::class, 'store'])->name('escalas.store');
    Route::get('/producao/escalas/{evento}/{escala}/edit', [EscalaController::class, 'edit'])->name('escalas.edit');
    Route::put('/producao/escalas/{evento}/{escala}', [EscalaController::class, 'update'])->name('escalas.update');
    
    // Rotas para Usuários
    Route::get('/producao/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/producao/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/producao/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/producao/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/producao/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/producao/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/escalas/consultar', [EscalaController::class, 'consultar'])->name('escalas.consultar');
});

// Rotas de autenticação padrão
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/reset-link-success', function () {
    return view('auth.reset-link-success');
})->name('password.reset.link.success');

// Confirmação e resposta de escalas
Route::get('/escalas/confirmar/{escala}/{voluntario}', [EscalaController::class, 'confirmar'])->name('escalas.confirmar')->middleware('signed');
Route::post('/escalas/responder/{escala}/{voluntario}', [EscalaController::class, 'responder'])->name('escalas.responder');

// Rotas de erros
Route::get('/erro', function () {
    return view('erros.nao-escalado');
})->name('erro');
Route::get('/obrigado', function () {
    return view('sucesso.confirmado');
})->name('obrigado');



// Rotas para e-mails
Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Route::get('/email/verify', function (Request $request) {
    if (!$request->user()->hasVerifiedEmail()) {
        return view('auth.verify-email')->with('wait_time', session('wait_time', 0));
    }

    return redirect()->intended('/home');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Verifica se a assinatura é válida e não expirou
    if (!$request->hasValidSignature()) {
        return redirect()->route('verification.notice')->with('error', 'O link de verificação expirou ou é inválido.');
    }

    // Busca o usuário pelo ID
    $user = User::findOrFail($id);

    // Verifica se o hash corresponde ao e-mail
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return redirect()->route('verification.notice')->with('error', 'Link de verificação inválido');
    }

    // Verifica se o e-mail já foi validado
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('admin.users')->with('info', 'E-mail já foi verificado');
    }

    // Marca como verificado
    $user->markEmailAsVerified();

    return redirect()->route('login')->with('success', 'E-mail verificado com sucesso!');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::get('/evento/{evento}/{token}/confirmar-presenca', [EventoController::class, 'confirmarPresenca'])->name('evento.confirmar.presenca');
Route::post('/evento/{evento}/{token}/confirmar-presenca', [EventoController::class, 'storePresenca'])->name('evento.store.presenca');
