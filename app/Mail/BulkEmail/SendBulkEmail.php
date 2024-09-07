<?php

namespace App\Mail\BulkEmail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendBulkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(public Email $email, public $recipient)
    {
        $this->email = $email;
        $this->recipient = $recipient;
        $this->subject = $this->email->subject;
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
            view: 'mail.bulk-email.email',
            with: [
                'subject' => $this->subject,
                'content' => $this->email->content,
                'recipient' => $this->recipient,
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
