<x-mail::message>
# Dear {{ $invoice->user->name ?? $invoice->company->name }},

This is a billing reminder that your invoice no. {{ $invoice->id }} which was generated on 
{{ $invoice->invoice_date ? $invoice->invoice_date->format('l, jS M Y') : $invoice->published_on->format('l, jS M Y') }} will be due in 2 days on {{ $invoice->due_date->format('l, jS M Y') }}.<br><br>

------------------------------------------------------
Invoice: {{ $invoice->id }}<br>
Balance Due: Rs{{ $invoice->total - $invoice->total_paid }}PKR<br>
Due Date: {{ $invoice->due_date->format('l, jS M Y') }}
------------------------------------------------------

You can login to your client area to view and pay the invoice at

@component('mail::button', ['url' => route('admin.invoices.show', $invoice->id)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
