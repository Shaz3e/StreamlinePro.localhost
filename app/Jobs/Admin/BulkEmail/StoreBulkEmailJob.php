<?php

namespace App\Jobs\Admin\BulkEmail;

use App\Models\BulkEmail;
use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bulkEmails;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // $now = Carbon::now();
        // Log::info('Current time (Carbon): ' . $now->toDateTimeString());
        // Log::info('Current time (Laravel): ' . now()->toDateTimeString());

        $this->bulkEmails = BulkEmail::where('send_date', '<=', now())
            ->where('is_publish', true)
            ->where('is_sent', false)
            ->get();
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        foreach ($this->bulkEmails as $email) {
            // Send to users
            if ($email->user_id) {
                foreach ($email->users as $user) {
                    Email::create([
                        'email' => $user->email,
                        'subject' => $email->subject,
                        'content' => $email->content,
                        'send_date' => $email->send_date,
                    ]);
                }
            }

            // Send to staff
            if ($email->admin_id) {
                foreach ($email->staff as $staff) {
                    Email::create([
                        'email' => $staff->email,
                        'subject' => $email->subject,
                        'content' => $email->content,
                        'send_date' => $email->send_date,
                    ]);
                }
            }

            // Mark the email as sent
            $email->is_sent = true;
            $email->save();
        }
    }
}
