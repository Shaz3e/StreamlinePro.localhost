<?php

namespace App\Observers\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\Log;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        if (
            request()->has('product_name') ||
            request()->has('quantity') ||
            request()->has('unit_price') ||
            request()->has('tax') ||
            request()->has('discount') ||
            request()->has('discount_type') ||
            request()->has('total_price')
        ) {
            // Extract the product details from the request
            $productNames = request()->input('product_name');
            $quantities = request()->input('quantity');
            $unitPrices = request()->input('unit_price');
            $taxes = request()->input('tax');
            $discounts = request()->input('discount');
            $discountTypes = request()->input('discount_type');
            $totalPrices = request()->input('total_price');

            // Initialize variables to store the sums
            $sumQuantity = 0;
            $sumUnitPrice = 0;
            $sumTax = 0;
            $sumDiscount = 0;
            $sumTotalPrice = 0;

            // Iterate through the products and calculate the sums
            for ($i = 0; $i < count($productNames); $i++) {
                $sumQuantity += (float) $quantities[$i];
                $sumUnitPrice += (float) $unitPrices[$i];
                $sumTax += (float) $taxes[$i];
                $sumDiscount += (float) $discounts[$i];
                $sumTotalPrice += (float) $totalPrices[$i];

                // Create entries in InvoiceProduct model
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_name' => $productNames[$i],
                    'quantity' => $quantities[$i],
                    'unit_price' => $unitPrices[$i],
                    'tax' => $taxes[$i],
                    'discount' => $discounts[$i],
                    'discount_type' => $discountTypes[$i],
                    'total_price' => $totalPrices[$i],
                ]);
            }

            // Update Invoice model with sum
            $invoice->update([
                'total_price' => $sumUnitPrice,
                'total_tax' => $sumTax,
                'total_discount' => $sumDiscount,
                'total_amount' => $sumTotalPrice,
            ]);
        }
    }

    /**
     * Handle the invoice "updating" event
     */
    public function updating(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "deleting" event.
     */
    public function deleting(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }
}
