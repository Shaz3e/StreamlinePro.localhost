<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\Invoice\PaymentConfirmationEmail as SystemInvoicePaymentConfirmationEmail;
use App\Mail\System\Invoice\PaymentDeletedEmail;
use App\Mail\User\Invoice\InvoicePaymentConfirmationEmail;
use App\Mail\User\Invoice\PaymentConfirmationEmail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $invoice = $payment->invoice;

        // Update the total paid amount
        $invoice->total_paid += $payment->amount;

        // Update the invoice status based on the total paid amount
        if ($invoice->total == $invoice->total_paid) {
            $invoice->status = Invoice::STATUS_PAID;
        } elseif ($invoice->total_paid > 0 && $invoice->total_paid < $invoice->total) {
            $invoice->status = Invoice::STATUS_PARTIALLY_PAID;
        }

        // Save the updated invoice
        $invoice->save();

        // Send email to user only
        if ($invoice->user) {
            $mailable = new PaymentConfirmationEmail($invoice, $payment);
            SendEmailJob::dispatch($mailable, $invoice->user->email);
        }

        // Send email to company
        if ($invoice->company) {

            if ($invoice->company->users->count() >= 1) {
                // Send invoice pulished notification to all users in company
                $invoice->company->users->each(function (User $client) use ($invoice, $payment) {
                    $mailable = new PaymentConfirmationEmail($invoice, $payment);
                    SendEmailJob::dispatch($mailable, $client->email);
                });
            } else {
                // Send invoice published notification to company email
                $mailable = new PaymentConfirmationEmail($invoice, $payment);
                SendEmailJob::dispatch($mailable, $invoice->company->email);
            }
        }
        // System notification
        $mailable = new SystemInvoicePaymentConfirmationEmail($invoice, $payment);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $invoice = $payment->invoice;

        // Update the total paid amount
        if ($invoice->total_paid != 0) {
            $invoice->total_paid -= $payment->amount;
        }

        // Update the invoice status based on the total paid amount and remaining payments
        if ($invoice->payments()->count() == 0) {
            $invoice->status = Invoice::STATUS_UNPAID;
        } elseif ($invoice->total_paid != $invoice->total) {
            $invoice->status = Invoice::STATUS_PARTIALLY_PAID;
        }

        // Send system notification
        Mail::to(DiligentCreators('notification_email'))
            ->send(new PaymentDeletedEmail($invoice, $payment));

        // Save the updated invoice
        $invoice->save();
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
