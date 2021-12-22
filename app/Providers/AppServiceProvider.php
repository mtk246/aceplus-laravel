<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

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
        Blade::if('admin', function () {
            return Auth::user()->role == 0;
        });
        Blade::if('employee', function () {
            return Auth::user()->role == 1;
        });
        // Blade::if('admin', function () {
        //     return Auth::user()->role && Auth::user()->role == 0;
        // });
    }
}
