<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\Task\CompletedEmail;
use App\Mail\System\Task\CreatedEmail;
use App\Mail\System\Task\DeletedEmail;
use App\Mail\System\Task\ForceDeletedEmail;
use App\Mail\System\Task\RestoredEmail;
use App\Mail\System\Task\Staff\CreatedEmail as StaffCreatedEmail;
use App\Mail\System\Task\Staff\UpdatedEmail as StaffUpdatedEmail;
use App\Mail\System\Task\StartedEmail;
use App\Mail\System\Task\UpdatedEmail;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskObserver
{
    /**
     * Handle the Task "crating" event.
     */
    public function creating(Task $task): void
    {
        $task->created_by = Auth::user()->id;
    }
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        if ($task->assignee) {
            $mailable = new StaffCreatedEmail($task);
            SendEmailJob::dispatch($mailable, $task->assignee->email);
        }

        $mailable = new CreatedEmail($task);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('is_started') && !$task->isDirty('is_completed')) {
            $mailable = new StartedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }

        if ($task->isDirty('is_completed')) {
            $mailable = new CompletedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }

        if (!$task->isDirty('is_started') && !$task->isDirty('is_completed') && !$task->isDirty('task_label_id')) {
            if ($task->isDirty('assigned_to')) {
                $mailable = new StaffUpdatedEmail($task);
                SendEmailJob::dispatch($mailable, $task->assignee->email);
            }
            $mailable = new UpdatedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        if (!$task->isForceDeleting()) {
            $mailable = new DeletedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        $mailable = new RestoredEmail($task);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        Mail::to(DiligentCreators('notification_email'))
            ->send(new ForceDeletedEmail($task));
    }
}
