<?php

namespace App\Jobs\Staff\Task;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\Task\OverdueReminderEmail as TaskOverdueReminderEmail;
use App\Mail\System\Task\Staff\OverdueReminderEmail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OverdueReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tasks = Task::where('due_date', '<', now())
            ->where('is_notification_sent', 0)
            ->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Loop the task to check there is any assignee who's task(s) is over due
        foreach ($this->tasks as $task) {

            /**
             * Send email notification to the created_by of the task
             * @param created_by relationship with createdBy() method in Task model
             * @param Task $task->createdBy
             */

            if ($task->createdBy) {
                $mailable = new TaskOverdueReminderEmail($task);

                // System notification
                SystemNotificationJob::dispatch($mailable);

                // send notification to createdBy
                SendEmailJob::dispatch($mailable, $task->createdBy->email);
            }

            /**
             * Send email notification to the assign_to of the task
             * @param assigned_to relationship with assignee() method in Task model
             * @param Task $task->assignee
             */

            if ($task->assignee) {
                $mailable = new OverdueReminderEmail($task);
                SendEmailJob::dispatch($mailable, $task->assignee->email);
            }

            /**
             * Update task with notification status and time
             */
            $task->update([
                'is_notification_sent' => 1,
                'notification_time' => now(),
            ]);
        }
    }
}
