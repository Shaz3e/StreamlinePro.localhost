<?php

namespace App\Mail\User\Invoice;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaymentConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, Payment $payment)
    {
        $this->invoice = $invoice;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Payment Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.invoice.invoice-payment-confirmation-email',
            with: [
                'invoice' => $this->invoice,
                'payment' => $this->payment,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
