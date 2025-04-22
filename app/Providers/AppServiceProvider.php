<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('anyrole', function ($roles) {
            return auth()->check() && auth()->user()->hasAnyRole((array) $roles);
        });

        //         @role('admin')
        //     <a href="/manage-user">Manage Users</a>
        // @endrole

        // @anyrole(['admin', 'guru'])
        //     <p>Selamat datang Admin atau Guru!</p>
        // @endanyrole

    }
}
