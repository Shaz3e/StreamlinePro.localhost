<?php

namespace App\Mail\System\Invoice;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublishedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewInvoice;

    /**
     * Create a new message instance.
     */
    public function __construct(public $invoice)
    {
        $this->subject = 'Invoice has been published';
        $this->invoice = $invoice;
        $this->viewInvoice = route('admin.invoices.show', $this->invoice->id);
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
            view: 'mail.system.invoice.published',
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
