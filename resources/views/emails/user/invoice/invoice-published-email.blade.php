<x-mail::message>
# Dear {{ $user->name ?? $invoice->company->name }},


This is a notice that an invoice has been generated on {{ $invoice->published_on->format('l, jS M Y') }}.<br><br>

Invoice #{{ $invoice->id}}<br>
Amount Due: Rs{{ $invoice->total }}PKR<br>
Due Date: {{ $invoice->due_date ? $invoice->due_date->format('l, jS M Y') : 'N/A'}}<br>

### Invoice Items

| Product Name | Price |
|--------------|-------|
@foreach ($products as $product)
| {{ $product->item_description }} | Rs{{ $product->unit_price }}PKR |
@endforeach

------------------------------------------------------
Sub Total: Rs{{ $invoice->sub_total }}PKR<br>
@if ($invoice->discount > 0)
Discount: Rs{{ $invoice->discount }}PKR<br>
@endif
@if ($invoice->tax > 0)
Tax: Rs{{ $invoice->tax }}PKR<br>
@endif
Total: Rs{{ $invoice->total }}PKR 
------------------------------------------------------
You can login to your client area to view and pay the invoice below.

@component('mail::button', ['url' => route('admin.invoices.show', $invoice->id)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>