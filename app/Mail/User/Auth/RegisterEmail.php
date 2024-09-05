<?php

namespace App\Mail\User\Auth;

use App\Mail\User\BaseEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterEmail extends BaseEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $user;
    public $password;
    public $login;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $password)
    {
        $this->subject = 'Your account has been created';
        $this->user = $user;
        $this->password = $password;
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
            view: 'mail.user.auth.register',
            with: [
                'subject' => $this->subject,
                'user' => $this->user,
                'password' => $this->password,
                'login' => $this->login
            ],
        );
    }
}
