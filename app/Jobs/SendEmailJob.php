<?php

namespace App\Jobs;

use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $mailable, protected $recipient)
    {
        $this->mailable = $mailable;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(MailService $mailService): void
    {
        $mailService->sendEmail($this->mailable, $this->recipient);
    }
}
