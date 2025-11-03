<?php

namespace App\Providers;


use Filament\Support\Facades\FilamentTimezone;
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
        // en: America/New_York
        // vn: Asia/Ho_Chi_Minh
        FilamentTimezone::set('Asia/Ho_Chi_Minh');
    }
}
