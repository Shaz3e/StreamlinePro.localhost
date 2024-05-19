<x-mail::message>
# Dear {{ $invoice->user->name ?? $invoice->company->name }},

This is a payment receipt for Invoice {{ $invoice->id }} sent on {{ $payment->created_at->format('l, F jS, Y') }}<br><br>

------------------------------------------------------
Sub Total: Rs{{ $invoice->sub_total }}PKR<br>
Total: Rs{{ $invoice->total }}PKR<br><br>

Amount: Rs{{ $payment->amount }}PKR<br>
Transaction #: {{ $payment->transaction_number }}<br>
Total Paid: Rs{{ $invoice->total_paid }}PKR<br>
Remaining Balance: Rs{{ $invoice->total - $invoice->total_paid }}PKR<br>
Status: {{ $invoice->status }}
------------------------------------------------------

You may review your invoice history at any time by logging in to your client area.<br><br>

Note: This email will serve as an official receipt for this payment.<br><br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>