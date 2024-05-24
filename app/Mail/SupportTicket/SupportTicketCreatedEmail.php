<?php

namespace App\Mail\SupportTicket;

use App\Models\Admin;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $supportTicket;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(SupportTicket $supportTicket, User|Admin $recipient)
    {
        $this->supportTicket = $supportTicket;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Support Ticket Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.support-ticket.support-ticket-created-email',
            with: [
                'supportTicket' => $this->supportTicket,
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
