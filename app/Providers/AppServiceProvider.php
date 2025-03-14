<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Adicionar hint paths para os componentes de e-mail
        $this->app['view']->addNamespace('mail', resource_path('views/vendor/mail'));
        $this->app['view']->addNamespace('mail', base_path('vendor/laravel/mail/src/views'));
    }
}
