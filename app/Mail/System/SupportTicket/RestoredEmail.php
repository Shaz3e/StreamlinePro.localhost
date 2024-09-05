<?php

namespace App\Mail\System\SupportTicket;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RestoredEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewSupportTicket;

    /**
     * Create a new message instance.
     */
    public function __construct(public $supportTicket)
    {
        $this->subject = 'Support Ticket has been restored';
        $this->supportTicket = $supportTicket;
        $this->viewSupportTicket = route('admin.support-tickets.show', $this->supportTicket->id);
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
            view: 'mail.system.support-ticket.restored',
            with: [
                'subject' => $this->subject,
                'supportTicket' => $this->supportTicket,
                'viewSupportTicket' => $this->viewSupportTicket,
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
