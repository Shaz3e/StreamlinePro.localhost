<?php

namespace App\Jobs\Admin\BulkEmail;

use App\Mail\Admin\BulkEmail\SendEmail;
use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendEmails;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $pending = Email::STATUS_PENDING;
        $failed = Email::STATUS_FAILED;

        $this->sendEmails = Email::where('send_date', '<=', now())
            ->whereIn('status', [$pending, $failed])
            ->orderBy('send_date')
            ->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the daily email sending limit
        $dailyLimit = $this->getDailyLimit(); // returns 300 by default

        // Calculate the number of emails already sent today
        $emailsSentToday = $this->getEmailsSentToday();

        // Determine the number of emails we can still send today
        $emailsToSend = min($dailyLimit - $emailsSentToday, $this->sendEmails->count());


        // Log the daily sending status
        Log::info("Daily limit: $dailyLimit, Emails sent today: $emailsSentToday, Emails to send: $emailsToSend");

        if ($emailsToSend <= 0) {
            Log::info('Daily email limit reached. No more emails will be sent today.');
            $this->rescheduleRemainingEmails();
            return;
        }

        // Initialize a counter for sent emails
        $emailCounter = 0;

        foreach ($this->sendEmails as $emailData) {
            // If we have reached the daily limit, break out of the loop
            if ($emailCounter >= $emailsToSend) {
                break;
            }

            try {
                // Send the email and log it
                Mail::to($emailData->email)
                    ->queue((new SendEmail($emailData, $emailData->email))
                        ->delay(now()->addSeconds(10 * $emailCounter))); // Delay each email by 10 seconds

                // Update the email status to SENT and log sent time
                $emailData->status = Email::STATUS_SENT;
                $emailData->sent_at = now();
                $emailData->save();

                // Increment the counter
                $emailCounter++;
            } catch (\Exception $e) {
                // Handle sending failure, log and update status to failed
                Log::error('Failed to send email to ' . $emailData->email . ': ' . $e->getMessage());
                $emailData->status = Email::STATUS_FAILED;
                $emailData->save();
            }

            // Reschedule any remaining emails
            $this->rescheduleRemainingEmails();
        }
    }

    /**
     * Get the daily email sending limit from the settings or use default.
     */
    protected function getDailyLimit()
    {
        // Replace this with your method to fetch settings, like a DB query
        $dailyLimitSetting = DiligentCreators('daily_email_sending_limit'); // returns 300 default
        return $dailyLimitSetting ?: 300;
    }

    /**
     * Get the number of emails sent today.
     */
    protected function getEmailsSentToday()
    {
        // Assume you have a sent_emails table that logs each sent email
        return Email::whereDate('sent_at', Carbon::today())
            ->count();
    }

    /**
     * Reschedule emails that were not sent today for the next day.
     */
    protected function rescheduleRemainingEmails()
    {
        $remainingEmails = $this->sendEmails->filter(function ($email) {
            return $email->status === Email::STATUS_PENDING || $email->status === Email::STATUS_FAILED;
        });

        foreach ($remainingEmails as $email) {
            $email->send_date = Carbon::tomorrow(); // Reschedule for tomorrow
            $email->save();
        }

        Log::info(count($remainingEmails) . ' emails have been rescheduled for tomorrow.');
    }
}
