<?php

namespace App\Providers;

use App\Models\PaymentTransaction;
use App\Observers\Invoice\InvoiceObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        PaymentTransaction::observe(InvoiceObserver::class);
    }
}
