<?php

namespace App\Observers;

use App\Mail\User\Invoice\InvoicePublishedEmail;
use App\Models\Invoice;
use App\Models\RecurringScheduledInvoices;
use Illuminate\Support\Facades\Mail;
use PDO;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        if ($invoice->is_recurring) {
            $frequency = $invoice->recurring_frequency;
            $recurringOn = $invoice->recurring_on;
            $nextInvoiceDate = null;

            switch ($frequency) {
                case 'weekly':
                    $nextInvoiceDate = $recurringOn->addWeeks(1);
                    break;
                case 'monthly':
                    $nextInvoiceDate = $recurringOn->addMonths(1);
                    break;
                case 'quarterly':
                    $nextInvoiceDate = $recurringOn->addQuarters(1);
                    break;
                case 'semiannually':
                    $nextInvoiceDate = $recurringOn->addMonths(6);
                    break;
                case 'annually':
                    $nextInvoiceDate = $recurringOn->addYears(1);
                    break;
                default:
                    // handle invalid frequency
                    break;
            }

            RecurringScheduledInvoices::create([
                'invoice_id' => $invoice->id,
                'next_invoice_date' => $nextInvoiceDate,
                'status' => 'Generated',
            ]);
        }
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        // Send invoice pulished notification to user
        if ($invoice->is_published) {
            // if ($invoice->user) {
            //     Mail::to($invoice->user->email)->send(new InvoicePublishedEmail($invoice));
            // }
            // // Send invoice pulished notification to company
            // if ($invoice->company) {
            //     Mail::to($invoice->company->email)->send(new InvoicePublishedEmail($invoice));
            // }
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
