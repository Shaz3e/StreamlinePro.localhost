<?php

namespace App\Mail\System\Company;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreatedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewCompany;

    /**
     * Create a new message instance.
     */
    public function __construct(public $company)
    {
        $this->subject = 'New Company Created';
        $this->company = $company;
        $this->viewCompany = route('admin.companies.show', $this->company->id);
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
            view: 'mail.system.company.created',
            with: [
                'subject' => $this->subject,
                'company' => $this->company,
                'viewCompany' => $this->viewCompany,
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
