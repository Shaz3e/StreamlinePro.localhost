<?php

namespace App\Providers;

use App\Services\BellNotificationService;
use Illuminate\Support\ServiceProvider;

class BellNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BellNotificationService::class, function ($app) {
            return new BellNotificationService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
