<?php

namespace App\Jobs\Staff;

use App\Mail\Staff\SendTaskReminderEmail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tasks = Task::where('due_date', '>', now())->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->tasks as $task){
            // Calculate remaining time
            $remainingTime = $task->due_date->diffInMinutes(now());

            if($remainingTime <= 15){
                // send 15-minute reminder email
                $this->sendTaskReminderEmail($task, '15 Minutes');
            }else if($remainingTime <= 60){
                // send 1-hour reminder email
                $this->sendTaskReminderEmail($task, '1 Hour');
            }else if($remainingTime <= 360){
                // send 6-hour reminder email
                $this->sendTaskReminderEmail($task, '6 Hours');
            }elseif($remainingTime <= 1440){
                // send 24-hour reminder email
                $this->sendTaskReminderEmail($task, '24 Hours');
            }
        }
    }

    private function sendTaskReminderEmail($task, $time)
    {

        // send markdown email with mail facade
        Mail::to($task->assignee->email)
            ->send(new SendTaskReminderEmail($task, $time));
    }
}
