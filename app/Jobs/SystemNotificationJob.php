<?php

namespace App\Jobs;

use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SystemNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(MailService $mailService): void
    {
        $notificationEmail = DiligentCreators('notification_email');

        if (!is_null($notificationEmail)) {
            $mailService->sendEmail($this->mailable, $notificationEmail);
        }
    }
}
