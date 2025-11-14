<?php

namespace App\Providers;


use Filament\Support\Facades\FilamentTimezone;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use BezhanSalleh\LanguageSwitch\Events\LocaleChanged;
use Illuminate\Support\Facades\Event;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['vi', 'en']);
        });
        Event::listen(function (LocaleChanged $event) {
            // Lưu vào session
            session(['locale' => $event->locale]);
            dd($event->locale);
        });
    }
}
