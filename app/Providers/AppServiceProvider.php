<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utils\{
    JWT,
    Mailer
};

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
        try {
            JWT::init();
            Mailer::init(config('phpmailer'));
        } catch (\Throwable $e) {
            logger()->error('Error Initialize Utils ' . $e->getMessage());
        }
    }
}
