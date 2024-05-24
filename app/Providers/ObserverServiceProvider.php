<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\SupportTicket;
use App\Observers\PaymentObserver;
use App\Observers\SupportTicketObserver;
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
        Payment::observe(PaymentObserver::class);
        SupportTicket::observe(SupportTicketObserver::class);
    }
}
