<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Mail\System\Task\Staff\TaskCommentEmail;
use App\Models\TaskComment;

class TaskCommentObserver extends BaseObserver
{
    /**
     * Handle the TaskComment "created" event.
     */
    public function created(TaskComment $taskComment): void
    {
        // Fetch the task and eager load the necessary relationships
        $task = $taskComment->task()->with(['assignee', 'createdBy'])->first();

        // Check if the task comment was posted by the assignee and notify the creator
        if ($task->assignee && $task->assignee->id === $taskComment->postedBy->id) {
            // Notify the task creator (createdBy) if they are not the one who posted the comment
            if ($task->createdBy && $task->createdBy->id !== $taskComment->postedBy->id) {
                $this->bell->notifyStaff(
                    $task->createdBy->id,
                    'Your task has a reply',
                    shortTextWithOutHtml($taskComment->message, 15),
                    $task->id,
                    'tasks',
                    'show'
                );
                $mailable = new TaskCommentEmail($taskComment);
                SendEmailJob::dispatch($mailable, $task->createdBy->email);
            }
        }

        // Check if the task comment was posted by the creator and notify the assignee
        if ($task->createdBy && $task->createdBy->id === $taskComment->postedBy->id) {
            // Notify the assignee (assignee) if they are not the one who posted the comment
            if ($task->assignee && $task->assignee->id !== $taskComment->postedBy->id) {
                $this->bell->notifyStaff(
                    $task->assignee->id,
                    'Your task has a reply',
                    shortTextWithOutHtml($taskComment->message, 15),
                    $task->id,
                    'tasks',
                    'show'
                );
                $mailable = new TaskCommentEmail($taskComment);
                SendEmailJob::dispatch($mailable, $task->assignee->email);
            }
        }
    }
}
