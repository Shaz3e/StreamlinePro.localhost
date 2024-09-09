<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Mail\System\Task\Staff\TaskCommentEmail;
use App\Models\TaskComment;

class TaskCommentObserver
{
    /**
     * Handle the TaskComment "created" event.
     */
    public function created(TaskComment $taskComment): void
    {
        // Fetch the task and eager load the necessary relationships
        $task = $taskComment->task()->with(['assignee', 'createdBy'])->first();

        // Check if assignee and posted by are the same
        if ($task->assignee && $task->assignee->id === $taskComment->postedBy->id) {
            $mailable = new TaskCommentEmail($taskComment);
            SendEmailJob::dispatch($mailable, $taskComment->postedBy->email);
        }
        // Check if created by and posted by are the same
        if ($task->createdBy && $task->createdBy->id === $taskComment->postedBy->id) {
            $mailable = new TaskCommentEmail($taskComment);
            SendEmailJob::dispatch($mailable, $taskComment->postedBy->email);
        }
    }
}
