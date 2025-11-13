<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\MakeDomain;
use Illuminate\Foundation\Console\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->commands([
            \App\Console\Commands\MakeDomain::class,
        ]);
    }

    public function boot()
    {
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('auth.admin', \App\Http\Middleware\RedirectIfAdmin::class);
        }
    }
}