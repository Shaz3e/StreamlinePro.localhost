@extends('mail.layouts.user')

@section('content')
    @if ($invoice->user)
        <h2>Dear {{ $invoice->user->name }}</h2>,
    @endif
    @if ($invoice->company)
        <h2>Invoice Generated for {{ $invoice->company->name }}</h2>,
    @endif

    <p>
        This is a billing reminder that your invoice no. {{ $invoice->id }} which was generated on
        {{ $invoice->invoice_date ? $invoice->invoice_date->format('l, jS M Y') : $invoice->published_on->format('l, jS M Y') }}
        will be due on {{ $invoice->due_date->format('l, jS M Y') }}.
    </p>

    <hr>

    <p>
        Invoice: {{ $invoice->id }}<br>
        Balance Due:
        {{ currency(DiligentCreators('currency'), ['symbol'])['symbol'] }}
        {{ $invoice->total - $invoice->total_paid }}
        {{ currency(DiligentCreators('currency'), ['name'])['name'] }}<br>
        Due Date: {{ $invoice->due_date->format('l, jS M Y') }}
    </p>

    <hr>

    <p>
        You can login to your client area to view and pay the invoice below.
    </p>

    <a href="{{ $viewInvoice }}">View Invoice</a>
@endsection
