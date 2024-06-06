<x-mail::message>
# Dear {{ $invoice->user->name ?? $invoice->company->name }},

This is a payment receipt for Invoice {{ $invoice->id }} sent on {{ $payment->created_at->format('l, F jS, Y') }}<br><br>

------------------------------------------------------
Sub Total: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->sub_total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
Total: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br><br>

Amount: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $payment->amount }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
Transaction #: {{ $payment->transaction_number }}<br>
Total Paid: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total_paid }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
Remaining Balance: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total - $invoice->total_paid }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
Status: {{ $invoice->status }}
------------------------------------------------------

You may review your invoice history at any time by logging in to your client area.<br><br>

Note: This email will serve as an official receipt for this payment.<br><br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>