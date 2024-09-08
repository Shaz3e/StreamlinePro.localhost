<?php

namespace App\Jobs\System\Task;

use App\Jobs\SystemNotificationJob;
use App\Mail\System\Task\DailyTaskReportEmail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyTaskReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tasksSummary;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Summarize the tasks
        $this->tasksSummary = [
            'total' => Task::count(),
            'overdue' => Task::where('due_date', '<', today())->where('is_completed', false)->count(),
            'not_started' => Task::where('is_started', false)->count(),
            'started' => Task::where('is_started', true)->where('is_completed', false)->count(),
            'not_completed' => Task::where('is_completed', false)->count(),
            'completed' => Task::where('is_completed', true)->count(),
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailable = new DailyTaskReportEmail($this->tasksSummary);
        SystemNotificationJob::dispatch($mailable);
    }
}
