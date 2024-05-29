<?php

namespace App\Jobs\User\Invoice;

use App\Mail\User\Invoice\SendInvoiceSecondOverDueNoticeEmail;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceSecondOverDueNoticeJob implements ShouldQueue
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
        $notice = Carbon::now()->subDays(2)->toDateString();

         // Find invoices with due_date equal after 2 days and send email
         $invoices = Invoice::whereDate('due_date', $notice)
         ->where([
             'status' => Invoice::STATUS_UNPAID,
             'status' => Invoice::STATUS_PARTIALLY_PAID,
         ])
         ->get();
         foreach ($invoices as $invoice) {
             // Send invoice pulished notification to user
             if ($invoice->user) {
                 Mail::to($invoice->user->email)->send(new SendInvoiceSecondOverDueNoticeEmail($invoice));
             }
             // Send invoice pulished notification to company
             if ($invoice->company) {
                 Mail::to($invoice->company->email)->send(new SendInvoiceSecondOverDueNoticeEmail($invoice));
             }
         }
    }
}
