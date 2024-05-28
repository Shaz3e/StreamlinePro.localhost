@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Invoices',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @if (request('status') == 'success')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @elseif (request('status') == 'cancel')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Links to perform quick actions --}}
    @if ($invoice->status === App\Models\Invoice::STATUS_CANCELLED)
        <div class="row mb-0">
            <div class="col-12">
                <div class="card border border-danger">
                    <div class="card-header bg-transparent border-danger">
                        <h5 class="my-0 text-danger"><i class="mdi mdi-block-helper me-3"></i>This invoice is Cancelled</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {!! $invoice->cancel_note !!}
                        </p>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    @endif
    {{-- Invoice View --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-title">
                                <h4 class="float-end font-size-16"><strong>Invoice # {{ $invoice->id }}</strong></h4>
                                <h3>
                                    <img src="{{ asset('storage/' . DiligentCreators('site_logo_light')) }}" alt="logo"
                                        height="24" />
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ auth()->user()->name }}<br>
                                    </address>
                                </div>
                                <div class="col-3 offset-3 text-end">
                                    <address>
                                        <strong>{{ DiligentCreators('site_name') }}</strong><br>
                                        {{ DiligentCreators('app_address') }}<br>
                                        {{ DiligentCreators('app_city') }}, {{ DiligentCreators('app_state') }}<br>
                                        {{ DiligentCreators('app_country') }} {{ DiligentCreators('app_zipcode') }}<br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mt-4">
                                    <address>
                                        <strong>Email:</strong><br>
                                        {{ auth()->user()->email }}
                                    </address>
                                </div>
                                <div class="col-6 mt-4 text-end">
                                    <address>
                                        @if ($invoice->invoice_date)
                                            <strong>Invoice Date:</strong><br>
                                            {{ $invoice->invoice_date->format('l, jS M Y') }}<br>
                                        @endif
                                        @if ($invoice->due_date)
                                            <strong>Invoice Due Date:</strong><br>
                                            {{ $invoice->due_date->format('l, jS M Y') }}<br><br>
                                        @endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Header Note --}}
                    @if (!is_null($invoice->header_note))
                        <div class="row mb-5">
                            <div class="col-md-12">
                                {!! $invoice->header_note !!}
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    @endif

                    {{-- Order Summary --}}
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-size-16"><strong>Order summary</strong></h3>
                                </div>
                                <div class="">


                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%">
                                                        <strong>Item</strong>
                                                    </th>
                                                    <th style="width: 20%" class="text-center" style="width: 10%">
                                                        <strong>Price</strong>
                                                    </th>
                                                    <th style="width: 10%" class="text-center" style="width: 10%">
                                                        <strong>Quantity</strong>
                                                    </th>
                                                    <th style="width: 20%" class="text-end" style="width: 10%">
                                                        <strong>Totals</strong>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td>{{ $item->item_description }}</td>
                                                        <td class="text-center">
                                                            {{ $currency['symbol'] }}
                                                            {{ currencyFormat($item->unit_price) }}
                                                            {{ $currency['name'] }}
                                                        </td>
                                                        <td class="text-center">{{ $item->quantity }}</td>
                                                        <td class="text-end">
                                                            {{ $currency['symbol'] }}
                                                            {{ currencyFormat($item->unit_price * $item->quantity) }}
                                                            {{ $currency['name'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center">
                                                        <strong>Subtotal</strong>
                                                    </td>
                                                    <td class="thick-line text-end">
                                                        {{ $currency['symbol'] }}
                                                        {{ $invoice->sub_total }}
                                                        {{ $currency['name'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>Discount</strong>
                                                    </td>
                                                    <td class="no-line text-end">
                                                        {{ $currency['symbol'] }}
                                                        {{ $invoice->discount }}
                                                        {{ $currency['name'] }}
                                                    </td>
                                                </tr>
                                                @if (!is_null($invoice->tax))
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Tax</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ $currency['symbol'] }}
                                                            {{ $invoice->tax }}
                                                            {{ $currency['name'] }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($invoice->total_paid > 0)
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ $currency['symbol'] }}
                                                            {{ $invoice->total }}
                                                            {{ $currency['name'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total Paid</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ $currency['symbol'] }}
                                                            {{ $invoice->total_paid }}
                                                            {{ $currency['name'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Balance</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h6 class="m-0">
                                                                {{ $currency['symbol'] }}
                                                                {{ $invoice->total - $invoice->total_paid }}
                                                                {{ $currency['name'] }}
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h6 class="m-0">
                                                                {{ $currency['symbol'] }}
                                                                {{ $invoice->total }}
                                                                {{ $currency['name'] }}
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- /.table-responsive --}}

                                    <div class="d-print-none">
                                        <div class="float-end">
                                            <a href="javascript:window.print()"
                                                class="btn btn-success waves-effect waves-light"><i
                                                    class="fa fa-print"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->


                    {{-- Payment Methods --}}
                    @if ($invoice->total !== $invoice->total_paid)
                        <ul class="list-inline mb-0 mt-5">
                            @if (DiligentCreators('stripe') == 1)
                                <li class="list-inline-item">
                                    <button type="button" class="btn btn-dark waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#addStripePayment">
                                        {{ DiligentCreators('stripe_display_name') }}
                                    </button>
                                    @include('user.invoice.stripe.form')
                                </li>
                            @endif
                            @if (DiligentCreators('stripe_hosted_checkout') == 1)
                                <li class="list-inline-item">
                                    <form action="{{ route('payment-method.stripe.hosted.checkout') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                        <button type="submit" class="btn btn-dark waves-effect waves-light">
                                            {{ DiligentCreators('stripe_hosted_checkout_display_name') }}
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    @endif

                    {{-- Footer Note --}}
                    @if (!is_null($invoice->footer_note))
                        <div class="row mt-5">
                            <div class="col-md-12">
                                {!! $invoice->footer_note !!}
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    @endif

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    {{-- /.row --}}

    {{-- Transaction Details --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Transaction Details
                </div>
                {{-- /.card-header --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="transactions-table">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    <th>Payment Method</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="transactionItems">
                                @foreach ($payments as $payment)
                                    <tr data-id="{{ $payment->id }}">
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->transaction_number }}</td>
                                        <td>{{ $payment->transaction_date->format('l, F j, Y') }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->created_at->format('l, F j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
