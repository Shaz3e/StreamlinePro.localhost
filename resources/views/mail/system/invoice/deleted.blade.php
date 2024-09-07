@extends('mail.layouts.user')

@section('content')
    <h2>System Notification</h2>
    <p>Invoice has been temporarily deleted and can be restored.</p>

    <p>
        To: {{ $invoice->user->name ?? $invoice->company->name }}<br>
        Invoice #{{ $invoice->id }}<br>
        Amount Due:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Due Date: {{ $invoice->due_date ? $invoice->due_date->format('l, jS M Y') : 'N/A' }}<br>
    </p>

    <h5>Invoice Items</h5>

    <table>
        <thead>
            <tr>
                <td>Product Name</td>
                <td>Price</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->products as $product)
                <tr>
                    <td>{{ $product->item_description }}</td>
                    <td>
                        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $product->unit_price }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <p>
        Sub Total:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->sub_total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @if ($invoice->discount > 0)
            Discount:
            {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->discount }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @endif
        @if ($invoice->tax > 0)
            Tax:
            {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->tax }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @endif
        Total:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}
    </p>
@endsection
