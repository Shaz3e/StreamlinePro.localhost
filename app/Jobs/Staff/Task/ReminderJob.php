<?php

namespace App\Jobs\Staff\Task;

use App\Jobs\SendEmailJob;
use App\Mail\System\Task\Staff\ReminderEmail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tasks = Task::where('due_date', '>', now())
            ->where('is_completed', false)
            ->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->tasks as $task) {
            // Calculate remaining time in minutes
            $remainingTimeInMinutes = $task->due_date->diffInMinutes(now());

            $timeLabel = null;
            if ($remainingTimeInMinutes <= 15) {
                // 15-minute reminder
                $timeLabel = '15 Minutes';
            } elseif ($remainingTimeInMinutes <= 60) {
                // 1-hour reminder
                $timeLabel = '1 Hour';
            } elseif ($remainingTimeInMinutes <= 360) {
                // 6-hour reminder
                $timeLabel = '6 Hours';
            } elseif ($remainingTimeInMinutes <= 1440) {
                // 24-hour reminder
                $timeLabel = '24 Hours';
            }

            if ($timeLabel) {
                $this->sendTaskReminderEmail($task, $timeLabel);
            }
        }
    }

    private function sendTaskReminderEmail($task, $time)
    {

        $mailable = new ReminderEmail($task, $time);
        Mail::to($task->assignee->email)->send($mailable);
        // SendEmailJob::dispatch($mailable, $task->assignee->email);
    }
}
