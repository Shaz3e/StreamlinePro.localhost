<?php

namespace App\Observers;

use App\Mail\User\Invoice\InvoicePaymentConfirmationEmail;
use App\Models\Invoice;
use App\Models\Payment;
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

        // Send email notification
        // if ($invoice->user) {
        //     Mail::to($invoice->user->email)
        //         ->queue(new InvoicePaymentConfirmationEmail($invoice, $payment));
        // }
        // if ($invoice->company) {
        //     Mail::to($invoice->company->email)
        //         ->queue(new InvoicePaymentConfirmationEmail($invoice, $payment));
        // }
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
