<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoice_statuses = [
            [
                'name' => 'Draft',
                'description' => 'The invoice is being prepared and hasn\'t been sent to the client yet.',
                'is_active' => 1
            ],
            [
                'name' => 'Sent',
                'description' => 'The invoice has been sent to the client but hasn\'t been paid yet.',
                'is_active' => 1
            ],
            [
                'name' => 'Pending',
                'description' => 'The client has not yet made a payment for the invoice.',
                'is_active' => 1
            ],
            [
                'name' => 'Partial Payment',
                'description' => 'The client has made a partial payment for the invoice amount.',
                'is_active' => 1
            ],
            [
                'name' => 'Paid',
                'description' => 'The client has paid the full amount of the invoice.',
                'is_active' => 1
            ],
            [
                'name' => 'Overdue',
                'description' => 'The invoice has not been paid by the due date.',
                'is_active' => 1
            ],
            [
                'name' => 'Void',
                'description' => 'The invoice has been canceled or invalidated.',
                'is_active' => 1
            ],
            [
                'name' => 'Processing',
                'description' => 'The payment for the invoice is currently being processed.',
                'is_active' => 1
            ],
            [
                'name' => 'Refunded',
                'description' => 'The payment for the invoice has been refunded to the client.',
                'is_active' => 1
            ],
            [
                'name' => 'Pending Approval',
                'description' => 'The invoice is pending approval before it can be sent to the client.',
                'is_active' => 1
            ],
            [
                'name' => 'Pending Review',
                'description' => 'The invoice is pending review by an administrator or manager.',
                'is_active' => 1
            ],
        ];

        DB::table('invoice_statuses')->insert($invoice_statuses);
    }
}
