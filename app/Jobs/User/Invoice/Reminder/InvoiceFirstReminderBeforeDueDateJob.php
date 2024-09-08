<?php

namespace App\Jobs\User\Invoice\Reminder;

use App\Jobs\SendEmailJob;
use App\Mail\User\Invoice\Reminder\ReminderEmail;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceFirstReminderBeforeDueDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $days = DiligentCreators('invoice_first_reminder_before_due_date') ?? 3;
        $reminder = Carbon::now()->addDays($days)->toDateString();

        // Find invoices with due_date equal before 3 days and send email
        $invoices = Invoice::whereDate('due_date', $reminder)
            ->where([
                'is_published' => true,
                'status' => Invoice::STATUS_UNPAID,
                'status' => Invoice::STATUS_PARTIALLY_PAID
            ])
            ->get();

        foreach ($invoices as $invoice) {
            // Send invoice pulished notification to user
            if ($invoice->user) {
                // send email
                $mailable = new ReminderEmail($invoice);
                SendEmailJob::dispatch($mailable, $invoice->user->email);
            }
            // Send invoice pulished notification to company
            if ($invoice->company) {
                // check if company has users
                if ($invoice->company->users->count() >= 1) {
                    // send email to all users in this company
                    $invoice->company->users->each(function (User $client) use ($invoice) {
                        // send email
                        $mailable = new ReminderEmail($invoice);
                        SendEmailJob::dispatch($mailable, $client->email);
                    });
                } else {
                    // Send email to company only
                    $mailable = new ReminderEmail($invoice);
                    SendEmailJob::dispatch($mailable, $invoice->company->email);
                }
            }
        }
    }
}
