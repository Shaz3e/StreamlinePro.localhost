<?php

namespace App\Mail\System\Task\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskCommentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewTask;

    /**
     * Create a new message instance.
     */
    public function __construct(public $taskComment)
    {
        $this->subject = 'Task has new resonse';
        $this->taskComment = $taskComment;
        $this->viewTask = route('admin.tasks.show', ['task' => $this->taskComment->task]);
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
            view: 'mail.system.task.staff.comment',
            with: [
                'subject' => $this->subject,
                'taskComment' => $this->taskComment,
                'viewTask' => $this->viewTask
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
