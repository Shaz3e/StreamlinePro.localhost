@extends('mail.layouts.user')

@section('content')
    @if ($invoice->user)
        <h2>Dear {{ $invoice->user->name }}</h2>,
    @endif
    @if ($invoice->company)
        <h2>Invoice Generated for {{ $invoice->company->name }}</h2>,
    @endif

    <p>This is a notice that an invoice has been generated on {{ $invoice->published_on->format('l, jS M Y') }}.</p>

    <p>
        Invoice #{{ $invoice->id }}<br>
        Invoice Amount:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}{{ $invoice->total }}{{ currency(DiligentCreators('currency'), ['name'])['name'] }}
        @if ($invoice->due_date)
            <br>
            Due Date: {{ $invoice->due_date ? $invoice->due_date->format('l, jS M Y') : 'N/A' }}
        @endif
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
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->sub_total }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @if ($invoice->discount)
            Discount:
            {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
            {{ $invoice->discount }}
            {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @endif
        @if ($invoice->tax)
            Tax:
            {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
            {{ $invoice->tax }}
            {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        @endif
        Total:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->total }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}
    </p>

    <hr>

    <p>
        You can login to your client area to view and pay the invoice below.
    </p>

    <a href="{{ $viewInvoice }}">View Invoice</a>
@endsection
