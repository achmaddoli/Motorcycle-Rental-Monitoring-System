<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon; // ✅ Tambahkan ini

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
        // ✅ Set timezone server Laravel ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // ✅ Set locale Carbon ke Indonesia
        Carbon::setLocale('id');
    }
}
