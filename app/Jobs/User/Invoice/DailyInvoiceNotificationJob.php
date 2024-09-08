<?php

namespace App\Jobs\User\Invoice;

use App\Jobs\SendEmailJob;
use App\Mail\User\Invoice\PublishedEmail;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DailyInvoiceNotificationJob implements ShouldQueue
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
        $today = Carbon::now()->toDateString();

        // Find invoices with published_on equal to today and send email
        $invoicesToPublish = Invoice::where([
            'status' => Invoice::STATUS_UNPAID,
            'status' => Invoice::STATUS_PARTIALLY_PAID,
        ])
            ->whereDate('published_on', $today)
            ->get();

        foreach ($invoicesToPublish as $invoice) {
            // Send invoice pulished notification to user
            if ($invoice->user) {
                // send email
                $mailable = new PublishedEmail($invoice);
                SendEmailJob::dispatch($mailable, $invoice->user->email);
            }
            // Send invoice pulished notification to company
            if ($invoice->company) {
                // check if company has users
                if ($invoice->company->users->count() >= 1) {
                    // send email to all users in this company
                    $invoice->company->users->each(function (User $client) use ($invoice) {
                        // send email
                        $mailable = new PublishedEmail($invoice);
                        SendEmailJob::dispatch($mailable, $client->email);
                    });
                } else {
                    // Send email to company only
                    $mailable = new PublishedEmail($invoice);
                    SendEmailJob::dispatch($mailable, $invoice->company->email);
                }
            }
        }
    }
}
