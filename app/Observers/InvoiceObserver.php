<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\Invoice\DeletedEmail;
use App\Mail\System\Invoice\ForceDeletedEmail;
use App\Mail\System\Invoice\PublishedEmail as InvoicePublishedEmail;
use App\Mail\System\Invoice\RestoredEmail;
use App\Mail\User\Invoice\PublishedEmail;
use App\Models\Invoice;
use App\Models\RecurringScheduledInvoices;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
        if (!$invoice->is_published) {
        }

        // Send invoice pulished notification to user
        if ($invoice->is_published && !$invoice->total_paid) {

            // Send email to user only
            if ($invoice->user) {
                $mailable = new PublishedEmail($invoice);
                SendEmailJob::dispatch($mailable, $invoice->user->email);
            }

            // Send email to company
            if ($invoice->company) {

                if ($invoice->company->users->count() >= 1) {
                    // Send invoice pulished notification to all users in company
                    $invoice->company->users->each(function (User $client) use ($invoice) {
                        $mailable = new PublishedEmail($invoice);
                        SendEmailJob::dispatch($mailable, $client->email);
                    });
                } else {
                    // Send invoice published notification to company email
                    $mailable = new PublishedEmail($invoice);
                    SendEmailJob::dispatch($mailable, $invoice->company->email);
                }
            }
            // System notification
            $mailable = new InvoicePublishedEmail($invoice);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        if (!$invoice->isForceDeleting()) {
            $mailable = new DeletedEmail($invoice);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        $mailable = new RestoredEmail($invoice);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        Mail::to(DiligentCreators('notification_email'))
            ->send(new ForceDeletedEmail($invoice));
    }
}
