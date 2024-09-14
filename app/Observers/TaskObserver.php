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

class TaskObserver extends BaseObserver
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
            // Notify to assignee
            $this->bell->notifyStaff(
                $task->assignee->id,
                'You have a new task',
                $task->title,
                $task->id,
                'tasks',
                'show'
            );

            // Send email to assignee
            $mailable = new StaffCreatedEmail($task);
            SendEmailJob::dispatch($mailable, $task->assignee->email);
        }

        // Notify to createdBy
        $this->bell->notifyStaff(
            $task->createdBy->id,
            'You assigned task to ' . $task->assignee->name,
            $task->title,
            $task->id,
            'tasks',
            'show'
        );

        // Notify to system
        $this->bell->notifySystem(
            'New Task assigned to ' . $task->assignee->name,
            $task->title,
            $task->id,
            'tasks',
            'show'
        );

        $mailable = new CreatedEmail($task);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('is_started') && !$task->isDirty('is_completed')) {
            // Notify createdBy
            $this->bell->notifyStaff(
                $task->createdBy->id,
                $task->assignee->name . ' Started task',
                $task->title,
                $task->id,
                'tasks',
                'show'
            );
            // Notify system
            $this->bell->notifySystem(
                $task->assignee->name . ' Started task ',
                $task->title,
                $task->id,
                'tasks',
                'show'
            );
            // Send email to system
            $mailable = new StartedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }

        if ($task->isDirty('is_completed')) {
            // Notify createdBy
            $this->bell->notifyStaff(
                $task->createdBy->id,
                $task->assignee->name . ' Completed task',
                $task->title,
                $task->id,
                'tasks',
                'show'
            );
            // Notify system
            $this->bell->notifySystem(
                $task->assignee->name . ' Completed task ',
                $task->title,
                $task->id,
                'tasks',
                'show'
            );
            // Send system email
            $mailable = new CompletedEmail($task);
            SystemNotificationJob::dispatch($mailable);
        }

        if (!$task->isDirty('is_started') && !$task->isDirty('is_completed') && !$task->isDirty('task_label_id')) {
            if ($task->isDirty('assigned_to')) {
                // Notify to assignee
                $this->bell->notifyStaff(
                    $task->assignee->id,
                    'You have a new task',
                    $task->title,
                    $task->id,
                    'tasks',
                    'show'
                );
                // Send email to system
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
