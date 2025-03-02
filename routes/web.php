<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ReservaController;

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

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
    Route::get('/admin/events/create', [AdminController::class, 'createEvent'])->name('admin.events.create');
    Route::post('/admin/events', [EventoController::class, 'storeEvent'])->name('admin.events.store');
    Route::delete('/admin/events/{evento}', [EventoController::class, 'deleteEvent'])->name('admin.events.destroy');
    Route::get('/admin/events/{evento}/edit', [EventoController::class, 'editEvent'])->name('admin.events.edit');
    Route::put('/admin/events/{evento}', [EventoController::class, 'updateEvent'])->name('admin.events.update');
    Route::get('/admin/events/{evento}/presencas', [AdminController::class, 'listarPresencas'])->name('admin.events.presencas');

    // Rotas para Usuários
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::get('/eventos', [EventoController::class, 'index']); // Listar eventos
Route::get('/eventos/{id}', [EventoController::class, 'show']); // Detalhes do evento
Route::post('/reservar/{id}', [ReservaController::class, 'store']); // Fazer reserva
Route::get('/minhas-reservas', [ReservaController::class, 'index']); // Ver reservas do usuário
Route::get('/evento/{evento}/{token}/confirmar-presenca', [EventoController::class, 'confirmarPresenca'])->name('evento.confirmar.presenca');
Route::post('/evento/{evento}/{token}/confirmar-presenca', [EventoController::class, 'storePresenca'])->name('evento.store.presenca');
