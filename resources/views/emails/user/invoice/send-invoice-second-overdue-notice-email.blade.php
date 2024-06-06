<x-mail::message>
# Dear {{ $invoice->user->name ?? $invoice->company->name }},

This is the second billing notice that your invoice no. {{ $invoice->id }} which was generated on 
{{ $invoice->invoice_date ? $invoice->invoice_date->format('l, jS M Y') : $invoice->published_on->format('l, jS M Y') }} is now overdue.<br><br>

------------------------------------------------------
Invoice: {{ $invoice->id }}<br>
Balance Due: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total - $invoice->total_paid }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
Due Date: {{ $invoice->due_date->format('l, jS M Y') }}
------------------------------------------------------

You can login to your client area to view and pay the invoice at

@component('mail::button', ['url' => route('admin.invoices.show', $invoice->id)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
