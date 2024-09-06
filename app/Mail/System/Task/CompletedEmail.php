<?php

namespace App\Mail\System\Task;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompletedEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewTask;

    /**
     * Create a new message instance.
     */
    public function __construct(public $task)
    {
        $this->subject = 'Task has been completed';
        $this->task = $task;
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
            view: 'mail.system.task.completed',
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
