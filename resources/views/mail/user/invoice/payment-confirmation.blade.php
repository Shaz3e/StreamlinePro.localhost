@extends('mail.layouts.user')

@section('content')
    @if ($invoice->user)
        <h2>Dear {{ $invoice->user->name }}</h2>,
    @endif
    @if ($invoice->company)
        <h2>Invoice Generated for {{ $invoice->company->name }}</h2>,
    @endif

    <p>
        This is a payment receipt for Invoice <strong>#{{ $invoice->id }}</strong> sent on
        {{ $payment->created_at->format('l, F jS, Y') }}
    </p>

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

        Transaction #: {{ $payment->transaction_number }}<br>
        Amount:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $payment->amount }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Total Paid:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->total_paid }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Remaining Balance:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->total - $invoice->total_paid }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Status: {{ $invoice->status }}
    </p>

    <hr>

    <p>
        You may review your invoice history at any time by logging in to your client area.
    </p>

    <p>
        You can login to your client area to view and pay the invoice below.
    </p>

    <p>
        Note: This email will serve as an official receipt for this payment.
    </p>

    <a href="{{ $viewInvoice }}">View Invoice</a>
@endsection
