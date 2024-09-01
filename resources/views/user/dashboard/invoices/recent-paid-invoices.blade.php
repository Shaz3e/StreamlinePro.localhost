<div class="card" style="height: calc(100% - 15px)">
    <div class="card-body">
        <h4 class="card-title">Recently Paid Invoices</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice#</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentlyPaidInvoices as $invoice)
                        <tr>
                            <td><a href="{{ route('invoice.show', $invoice->id) }}">Invoice#
                                    {{ $invoice->id }}</a>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $invoice->getStatusColor() }}">
                                    {{ $invoice->getStatus() }}
                                </span>
                            </td>
                            <td class="text-end">{{ $currency['symbol'] }}{{ $invoice->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- /.table-responsive --}}
    </div>
    {{-- /.card-body --}}
</div>
{{-- /.card --}}
