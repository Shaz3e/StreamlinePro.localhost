<?php

namespace App\Jobs\User\Invoice;

use App\Models\Invoice;
use App\Models\RecurringScheduledInvoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateRecurringInvoiceJob implements ShouldQueue
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
        // Query all recurring invoices
        $recurringInvoices = RecurringScheduledInvoices::where('next_invoice_date', '<=', now())->get();
        foreach ($recurringInvoices as $recurringInvoice) {
            $invoice = Invoice::find($recurringInvoice->invoice_id);

            // Get the next recurring date as per frequency
            switch ($invoice->recurring_frequency) {
                case 'weekly':
                    $nextInvoiceDate = $invoice->recurring_on->addWeeks(1);
                    break;
                case 'monthly':
                    $nextInvoiceDate = $invoice->recurring_on->addMonths(1);
                    break;
                case 'quarterly':
                    $nextInvoiceDate = $invoice->recurring_on->addQuarters(1);
                    break;
                case 'semiannually':
                    $nextInvoiceDate = $invoice->recurring_on->addMonths(6);
                    break;
                case 'annually':
                    $nextInvoiceDate = $invoice->recurring_on->addYears(1);
                    break;
                default:
                    // handle invalid frequency
                    break;
            }

            // Create new invoice
            $newInvoice = Invoice::create([
                'user_id' => $invoice->user_id,
                'company_id' => $invoice->company_id,
                'invoice_label_id' => $invoice->invoice_label_id,
                'invoice_date' => now(),
                'due_date' => $nextInvoiceDate,
                'is_published' => 1,
                'published_on' => now(),
                'is_recurring' => 1,
                'recurring_on' => $nextInvoiceDate,
                'recurring_frequency' => $invoice->recurring_frequency,
                'header_note' => $invoice->header_note,
                'footer_note' => $invoice->footer_note,
                'private_note' => $invoice->private_note,
                'discount_type' => $invoice->discount_type,
                'sub_total' => $invoice->sub_total,
                'discount' => $invoice->discount,
                'tax' => $invoice->tax,
                'total' => $invoice->total,
            ]);

            // Create new invoice items for the new invoice
            if ($invoice->products->count() > 0) {
                foreach ($invoice->products as $item) {
                    $newInvoice->products()->create([
                        'invoice_id' => $newInvoice->id,
                        'item_description' => $item->item_description,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'discount_value' => $item->discount_value,
                        'tax_value' => $item->tax_value,
                        'product_total' => $item->product_total,
                    ]);
                }
            }

            // Delete old schedule entry
            RecurringScheduledInvoices::where('invoice_id', $invoice->id)->delete();
        }
    }
}
