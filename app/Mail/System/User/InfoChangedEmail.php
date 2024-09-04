<?php

namespace App\Mail\System\User;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InfoChangedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewUser;

    /**
     * Create a new message instance.
     */
    public function __construct(public $user)
    {
        $this->subject = 'Notification: User Information Changed';
        $this->user = $user;
        $this->viewUser = route('admin.users.show', $this->user->id);
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
            view: 'mail.system.user.info-changed',
            with: [
                'subject' => $this->subject,
                'user' => $this->user,
                'viewUser' => $this->viewUser
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
