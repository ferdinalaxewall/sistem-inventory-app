<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

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
        if (!App::runningInConsole()) {
            // Default Datetime Config
            config(['app.locale' => 'id']);
            \Carbon\Carbon::setLocale('id');
            date_default_timezone_set('Asia/Jakarta');
        }
    }
}
