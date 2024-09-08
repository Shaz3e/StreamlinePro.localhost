<?php

namespace App\Mail\System\Invoice;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeletedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(public $invoice)
    {
        $this->subject = 'Invoice has been temporarily deleted';
        $this->invoice = $invoice;
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
            view: 'mail.system.invoice.deleted',
            with: [
                'subject' => $this->subject,
                'invoice' => $this->invoice,
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
