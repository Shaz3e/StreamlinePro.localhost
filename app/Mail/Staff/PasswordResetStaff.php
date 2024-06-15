<?php

namespace App\Mail\Staff;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetStaff extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $staff, $token)
    {
        $this->staff = $staff;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password is Reset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.staff.password-reset-staff',
            with: [
                'staff' => $this->staff,
                'url' => route('admin.password.reset', [
                    'email' => $this->staff->email,
                    'token' => $this->token,
                ]),
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
