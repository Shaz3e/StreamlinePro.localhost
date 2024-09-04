<?php

namespace App\Mail\User\Auth;

use App\Mail\User\BaseEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InfoChangedEmail extends BaseEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $login;

    /**
     * Create a new message instance.
     */
    public function __construct(public $user)
    {
        $this->subject = 'Your Information has been updated';
        $this->user = $user;
        $this->login = route('login');
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
            view: 'mail.user.auth.info-changed',
            with: [
                'subject' => $this->subject,
                'user' => $this->user,
                'login' => $this->login
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
