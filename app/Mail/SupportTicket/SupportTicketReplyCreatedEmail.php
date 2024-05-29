<?php

namespace App\Mail\SupportTicket;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketReplyCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $supportTicket;
    public $supportTicketReply;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(SupportTicketReply $supportTicketReply, $recipient)
    {
        $this->supportTicket = SupportTicket::where('id', $supportTicketReply->support_ticket_id)->first();
        $this->supportTicketReply = $supportTicketReply;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Support Ticket Reply',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.support-ticket.support-ticket-reply-created-email',
            with: [
                'supportTicket' => $this->supportTicket,
                'supportTicketReply' => $this->supportTicketReply,
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
