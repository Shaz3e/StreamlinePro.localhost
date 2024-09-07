<?php

namespace App\Jobs\User\Invoice\OverdueReminder;

use App\Jobs\SendEmailJob;
use App\Mail\User\Invoice\OverdueReminder\NoticeEmail;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceSecondOverDueNoticeJob implements ShouldQueue
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
        // Todo Add dynamic days functionality
        // $days = DiligentCreators('invoice_second_overdue_notice');
        $days = 2;
        $notice = Carbon::now()->subDays($days)->toDateString();

        // Find invoices with due_date equal after 1 days and send email
        $invoices = Invoice::whereDate('due_date', $notice)
            ->where([
                'is_published' => true,
                'status' => Invoice::STATUS_UNPAID,
                'status' => Invoice::STATUS_PARTIALLY_PAID,
            ])
            ->get();

        foreach ($invoices as $invoice) {
            // Send invoice pulished notification to user
            if ($invoice->user) {
                // send email
                $mailable = new NoticeEmail($invoice);
                SendEmailJob::dispatch($mailable, $invoice->user->email);
            }
            // Send invoice pulished notification to company
            if ($invoice->company) {
                // check if company has users
                if ($invoice->company->users->count() >= 1) {
                    // send email to all users in this company
                    $invoice->company->users->each(function (User $client) use ($invoice) {
                        // send email
                        $mailable = new NoticeEmail($invoice);
                        SendEmailJob::dispatch($mailable, $client->email);
                    });
                } else {
                    // Send email to company only
                    $mailable = new NoticeEmail($invoice);
                    SendEmailJob::dispatch($mailable, $invoice->company->email);
                }
            }
        }
    }
}
