<?php

namespace App\Jobs\User\Invoice;

use App\Mail\User\Invoice\InvoicePublishedEmail;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceNotificationsJob implements ShouldQueue
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
    public function handle()
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
                Mail::to($invoice->user->email)->send(new InvoicePublishedEmail($invoice));
            }
            // Send invoice pulished notification to company
            if ($invoice->company) {
                Mail::to($invoice->company->email)->send(new InvoicePublishedEmail($invoice));
            }
        }
    }
}
