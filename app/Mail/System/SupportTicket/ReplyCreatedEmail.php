<?php

namespace App\Mail\System\SupportTicket;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyCreatedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewSupportTicketReply;

    /**
     * Create a new message instance.
     */
    public function __construct(public $supportTicketReply)
    {
        $this->subject = 'Support Ticket Reply';
        $this->supportTicketReply = $supportTicketReply;
        $this->viewSupportTicketReply = route('admin.support-tickets.show', $this->supportTicketReply->supportTicket->id);
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
            view: 'mail.system.support-ticket.reply-created',
            with: [
                'subject' => $this->subject,
                'supportTicketReply' => $this->supportTicketReply,
                'viewSupportTicketReply' => $this->viewSupportTicketReply
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
