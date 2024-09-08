<?php

namespace App\Mail\User\Invoice\OverdueReminder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoticeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewInvoice;

    /**
     * Create a new message instance.
     */
    public function __construct(public $invoice)
    {
        $this->subject = 'Invoice Overdue Notice';
        $this->invoice = $invoice;
        $this->viewInvoice = route('invoice.show', $this->invoice->id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.user.invoice.overdue.notice',
            with: [
                'subject' => $this->subject,
                'invoice' => $this->invoice,
                'viewInvoice' => $this->viewInvoice,
            ],
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
