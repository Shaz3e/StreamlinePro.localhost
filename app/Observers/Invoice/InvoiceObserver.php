<?php

namespace App\Observers\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class InvoiceObserver
{
    /**
     * Handle the Invoice "creating" event.
     */
    public function creating(Invoice $invoice): void
    {
        Log::info('invoice is being created');
    }
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        Log::info('invoice is created');
    }

    /**
     * Handle the invoice "updating" event
     */
    public function updating(Invoice $invoice): void
    {
        Log::info('invoice is being updated');
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        Log::info('invoice is updated');
    }

    /**
     * Handle the Invoice "deleting" event.
     */
    public function deleting(Invoice $invoice): void
    {
        Log::info('invoice is being deleted');
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        Log::info('invoice is deleted');
    }
}
