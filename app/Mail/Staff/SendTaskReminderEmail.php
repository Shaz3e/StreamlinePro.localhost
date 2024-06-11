<?php

namespace App\Mail\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTaskReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $task;
    protected $time;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $time)
    {
        $this->task = $task;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Task will be over due in ' . $this->time,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.staff.send-task-reminder-email',
            with: [
                'task' => $this->task,
                'time' => $this->time,
                'url' => config('app.url') . '/admin/tasks/' . $this->task->id,
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
