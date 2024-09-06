<?php

namespace App\Mail\System\Task;

use App\Mail\System\SystemEmail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueReminderEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewTask;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Task $task)
    {
        $this->task = $task;
        $this->subject = 'Task is overdue';
        $this->viewTask = route('admin.tasks.show', $this->task->id);
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
            view: 'mail.system.task.overdue-reminder',
            with: [
                'subject' => $this->subject,
                'task' => $this->task,
                'viewTask' => $this->viewTask
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
