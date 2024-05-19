@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Invoices',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

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
                                        1234 Main<br>
                                        Apt. 4B<br>
                                        Springfield, ST 54321
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
                                        <strong>Payment Method:</strong><br>
                                        Visa ending **** 4242<br>
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
                                                    <th style="width: 70%"><strong>Item</strong></th>
                                                    <th class="text-center" style="width: 10%"><strong>Price</strong></th>
                                                    <th class="text-center" style="width: 10%"><strong>Quantity</strong>
                                                    </th>
                                                    <th class="text-end" style="width: 10%"><strong>Totals</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td>{{ $item->item_description }}</td>
                                                        <td class="text-center">{{ currencyFormat($item->unit_price) }}</td>
                                                        <td class="text-center">{{ $item->quantity }}</td>
                                                        <td class="text-end">
                                                            {{ currencyFormat($item->unit_price * $item->quantity) }}
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
                                                        {{ $invoice->sub_total }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>Discount</strong>
                                                    </td>
                                                    <td class="no-line text-end">
                                                        {{ $invoice->discount }}
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
                                                            {{ $invoice->tax }}
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
                                                            {{ $invoice->total }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total Paid</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ $invoice->total_paid }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Balance</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h4 class="m-0">
                                                                {{ $invoice->total - $invoice->total_paid }}
                                                            </h4>
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
                                                            <h4 class="m-0">
                                                                {{ $invoice->total }}
                                                            </h4>
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
                                            <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Send</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->

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
                                        <td>{{ $payment->created_at->format('l, F j, Y') }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-danger btn-sm waves-effect waves-light removePayment"
                                                data-payment-id="{{ $payment->id }}">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
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
