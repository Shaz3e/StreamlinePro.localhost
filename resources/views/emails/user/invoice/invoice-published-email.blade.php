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
| {{ $product->item_description }} | {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $product->unit_price }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }} |
@endforeach

------------------------------------------------------
Sub Total: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->sub_total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
@if ($invoice->discount > 0)
Discount: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->discount }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
@endif
@if ($invoice->tax > 0)
Tax: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->tax }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
@endif
Total: {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }} 
------------------------------------------------------
You can login to your client area to view and pay the invoice below.

@component('mail::button', ['url' => route('admin.invoices.show', $invoice->id)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>