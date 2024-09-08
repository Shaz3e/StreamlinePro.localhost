@extends('mail.layouts.user')

@section('content')
    <h2>System Notification</h2>
    <p>New Payment Deleted</p>

    <p>
        From: {{ $invoice->user->name ?? $invoice->company->name }}<br>
        Invoice #{{ $invoice->id }}<br>
        Deleted Payment:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $payment->amount }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Amount:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->total }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Due Date: {{ $invoice->due_date ? $invoice->due_date->format('l, jS M Y') : 'N/A' }}<br>
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

    <a href="{{ $viewInvoice }}">View Invoice</a>
@endsection
