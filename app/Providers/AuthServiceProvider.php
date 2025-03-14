<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('ver-escalas', function ($user) {
            // Supondo que o usuário tenha um atributo 'producao' que retorna true/false
            return $user->is_producer === true;
        });
        Gate::define('ver-eventos', function ($user) {
            // Supondo que o usuário tenha um atributo 'producao' que retorna true/false
            return $user->is_admin === true;
        });
    }
}
