<?php

namespace App\Mail\System\Task\Staff;

use App\Mail\System\SystemEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends SystemEmail
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewTask;

    /**
     * Create a new message instance.
     */
    public function __construct(protected $task, protected $time)
    {
        $this->task = $task;
        $this->time = $time;
        $this->subject = 'Your Task will be over due soon';
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
            view: 'mail.system.task.staff.task-reminder',
            with: [
                'subject' => $this->subject,
                'task' => $this->task,
                'viewTask' => $this->viewTask
            ],
        );
    }
}
