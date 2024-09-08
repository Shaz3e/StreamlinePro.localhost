<?php

namespace App\Mail\System\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyTaskReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $tasksSummary;
    public $taskView;

    /**
     * Create a new message instance.
     */
    public function __construct(array $tasksSummary)
    {
        $this->subject = 'Daily Task Report';
        $this->tasksSummary = $tasksSummary;
        $this->taskView = route('admin.tasks.index');
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
            view: 'mail.system.task.daily-task-report',
            with: [
                'subject' => $this->subject,
                'tasksSummary' => $this->tasksSummary,
                'taskView' => $this->taskView,
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
