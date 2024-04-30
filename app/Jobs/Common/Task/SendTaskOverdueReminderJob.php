<?php

namespace App\Jobs\Common\Task;

use App\Mail\Admin\Task\Admin\SendTaskOverdueReminderAdminEmail;
use App\Mail\Admin\Task\Staff\SendTaskOverdueReminderStaffEmail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskOverdueReminderJob implements ShouldQueue
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

            $created_by = $task->createdBy;

            if ($created_by) {
                Mail::to($created_by->email)
                    ->send(new SendTaskOverdueReminderAdminEmail($task));
            }

            /**
             * Send email notification to the assign_to of the task
             * @param assigned_to relationship with assignee() method in Task model
             * @param Task $task->assignee
             */

            $assigned_to = $task->assignee;

            if ($assigned_to) {
                Mail::to($assigned_to->email)
                    ->send(new SendTaskOverdueReminderStaffEmail($task));
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
