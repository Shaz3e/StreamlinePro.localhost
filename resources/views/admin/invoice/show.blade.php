@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View Invoice',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Invoice List', 'link' => route('admin.invoices.index')],
            ['text' => 'View', 'link' => null],
        ],
    ])

    {{-- Links to perform quick actions --}}
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success waves-effect waves-light" href="{{ route('admin.invoices.edit', $invoice->id) }}">
                <i class="ri-edit-line align-middle me-2"></i> Edit Invoice
            </a>
            @if ($invoice->total_amount != $invoice->total_paid && $invoice->total_amount != 0)
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#addPayment">Add Payment</button>
                @include('admin.invoice.add-payment')
            @endif
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Invoice Account Summary --}}
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">All Products Price</div>
                    <h4 class="card-title">{{ $invoice->total_price }}</h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Total</div>
                    <h4 class="card-title">{{ $invoice->total_amount }}</h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Total Paid</div>
                    <h4 class="card-title">{{ $invoice->total_paid }}</h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Status</div>
                    <h4 class="card-title">{{ $invoice->status }}</h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Invoice Summary --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Invoiced To</div>
                    <h4 class="card-title">
                        <a href="{{ route('admin.companies.show', $invoice->company->id) }}">
                            {{ $invoice->company->name }}
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Invoice Label</div>
                    <h4 class="card-title">
                        <span class="badge"
                            style="background-color: {{ $invoice->label->bg_color }}; color:{{ $invoice->label->text_color }}">
                            {{ $invoice->label->name }}
                        </span>
                    </h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Invoice Date</div>
                    <h4 class="card-title">
                        @if (!is_null($invoice->invoice_date))
                            {{ $invoice->invoice_date->format('l, jS M Y') }}
                        @else
                            <span class="text-danger">Not Set</span>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">Due Date</div>
                    <h4 class="card-title">
                        @if (!is_null($invoice->due_date))
                            {{ $invoice->due_date->format('l, jS M Y') }}
                        @else
                            <span class="text-danger">Not Set</span>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Invoice Items --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Invoice Items
                </div>
                {{-- /.card-header --}}
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <table class="table table-hover table-bordered" id="invoice-items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Discount Type</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit_price }}</td>
                                        <td>{{ $item->tax }}</td>
                                        <td>{{ $item->discount }}</td>
                                        <td>{{ ucwords($item->discount_type) }}</td>
                                        <td>{{ $item->total_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>-</th>
                                    <th>{{ $items->sum('quantity') }}</th>
                                    <th>{{ $items->sum('unit_price') }}</th>
                                    <th>{{ $items->sum('tax') }}</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>{{ $items->sum('total_price') }}</th>
                                </tr>
                            </tfoot>
                        </table> --}}

                        <table class="table">
                            <thead>
                                <tr>
                                    <th><strong>Product</strong></th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Discount Type</th>
                                    <th class="text-end">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">{{ $item->unit_price }}</td>
                                        <td class="text-center">{{ $item->tax }}</td>
                                        <td class="text-center">{{ $item->discount }}</td>
                                        <td class="text-center">{{ ucwords($item->discount_type) }}</td>
                                        <td class="text-end">{{ $item->total_price }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-end">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="thick-line text-end">
                                        {{ $invoice->total_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-end">
                                        <strong>Total Discount %</strong>
                                    </td>
                                    <td class="thick-line text-end">
                                        {{ $totalPercentageDiscount }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-end">
                                        <strong>Total Fixed Amount Discount</strong>
                                    </td>
                                    <td class="thick-line text-end">
                                        ${{ $totalAmountDiscount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-end">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="no-line text-end">
                                        <h4 class="m-0">{{ $invoice->total_amount }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-responsive --}}
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                        class="btn btn-success btn-sm waves-effect waves-light">
                        <i class="ri-edit-line align-middle me-2"></i> Edit Invoice
                    </a>
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
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
                                        <td>{{ $payment->payment_number }}</td>
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

    {{-- Show Audit History --}}
    @hasrole('tester')
        @if (count($audits) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Audit History
                        </div>
                        {{-- /.card-header --}}

                        <div class="card-body">
                            <table class="table" id="#audit-log-table">
                                <thead>
                                    <tr>
                                        <th>Audit</th>
                                        <th>IP</th>
                                        <th>Modified At</th>
                                        <th>Records</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $audit)
                                        <tr>
                                            <td></td>
                                            <td>{{ $audit->ip_address }}</td>
                                            <td>{{ $audit->created_at }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm waves-effect waves-light show-audit-modal"
                                                    data-bs-toggle="modal" data-bs-target=".auditLog"
                                                    data-audit-id="{{ $audit->id }}">
                                                    <i class="ri-history-line"></i>
                                                </button>

                                                <button type="button"
                                                    class="btn btn-danger btn-sm waves-effect waves-light delete-audit-log"
                                                    data-audit-id="{{ $audit->id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $audits->links('pagination::bootstrap-5') }}
                        </div>
                        {{-- /.card-body --}}
                    </div>
                    {{-- /.card --}}
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        @endif

        {{-- Audit Log --}}
        <div class="modal fade auditLog" tabindex="-1" aria-labelledby="auditLog" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="auditLog">Audit Log</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endhasrole
@endsection

@push('styles')
@endpush

@push('scripts')
    @hasrole('tester')
        <script>
            $(document).ready(function() {
                // Audit Log Show Modal
                $('.show-audit-modal').click(function(e) {
                    e.preventDefault();
                    const invoiceId = $(this).data('audit-id');
                    // Fetch details via AJAX
                    $.ajax({
                        url: `{{ route('admin.products.audit', ':id') }}`.replace(':id',
                            invoiceId),
                        type: 'GET',
                        success: function(data) {
                            // Populate modal content with fetched data
                            $('.auditLog .modal-body').html(data);
                            // Show the modal
                            $('.auditLog').modal('show');
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });
                $('.delete-audit-log').click(function(e) {
                    e.preventDefault();
                    const invoiceId = $(this).data('audit-id');

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this audit log!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirms, proceed with deletion
                            $.ajax({
                                url: `{{ route('admin.products.audit.delete', ':id') }}`
                                    .replace(
                                        ':id', invoiceId),
                                type: 'GET',
                                success: function(data) {
                                    // Show success message
                                    Swal.fire('Deleted!',
                                        'Your audit log has been deleted.', 'success');
                                    // reload page
                                    location.reload();
                                },
                                error: function(error) {
                                    console.error('Error:', error);
                                    // Show error message if deletion fails
                                    Swal.fire('Error!',
                                        'Failed to delete audit log or it has been deleted',
                                        'error');
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // If user cancels, show message that the history is safe
                            Swal.fire('Cancelled', 'Your audit log is safe :)', 'info');
                        }
                    });
                });
            });
        </script>
    @endhasrole

    <script>
        $(document).ready(function() {
            // remove payment when button #removePayment click via ajax
            $('.removePayment').click(function(e) {
                e.preventDefault();
                const paymentId = $(this).data('payment-id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ route('admin.invoice.remove-payment', ':id') }}`.replace(':id',
                        paymentId),
                    type: 'DELETE',
                    success: function(data) {
                        // Show success message
                        Swal.fire({
                            title: 'Success',
                            text: data.success,
                            icon: 'success',
                            showCancelButton: false
                        });
                        location.reload();
                    },
                    error: function(error) {
                        // console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: data.error,
                            icon: 'error',
                            showCancelButton: false
                        });
                    }
                });
            });
        });
    </script>
@endpush
