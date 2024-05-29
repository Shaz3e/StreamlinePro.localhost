<?php

namespace App\Jobs\User\Invoice;

use App\Mail\User\Invoice\SendInvoiceThirdReminderBeforeDueDateEmail;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceThirdReminderBeforeDueDateJob implements ShouldQueue
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
        $reminder = Carbon::now()->addDays(1)->toDateString();

        // Find invoices with due_date equal before 1 days and send email
        $invoices = Invoice::whereDate('due_date', $reminder)
            ->where([
                'status' => Invoice::STATUS_UNPAID,
                'status' => Invoice::STATUS_PARTIALLY_PAID
            ])
            ->get();

        foreach ($invoices as $invoice) {
            // Send invoice pulished notification to user
            if ($invoice->user) {
                Mail::to($invoice->user->email)->send(new SendInvoiceThirdReminderBeforeDueDateEmail($invoice));
            }
            // Send invoice pulished notification to company
            if ($invoice->company) {
                Mail::to($invoice->company->email)->send(new SendInvoiceThirdReminderBeforeDueDateEmail($invoice));
            }
        }
    }
}
