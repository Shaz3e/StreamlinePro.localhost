<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Observers\SupportTicketObserver;
use App\Observers\SupportTicketReplyObserver;
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
        // Invoice
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);

        // Support Ticket
        SupportTicket::observe(SupportTicketObserver::class);
        // Support Ticket Reply
        SupportTicketReply::observe(SupportTicketReplyObserver::class);
    }
}
