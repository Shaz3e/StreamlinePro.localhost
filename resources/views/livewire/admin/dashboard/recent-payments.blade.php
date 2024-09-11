<div wire:poll.visible>
    <div class="card" style="height: calc(100% - 15px)">
        <div class="card-body">
            <h4 class="card-title">Latest Transactions</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Transaction Date</th>
                            <th>Created At</th>
                            <th class="text-end" style="width: 15%">Invoice #</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->transaction_number }}</td>
                                <td>{{ $payment->transaction_date->format('l, F j, Y') }}</td>
                                <td>{{ $payment->created_at->format('l, F j, Y') }}</td>
                                <td class="text-end"><a
                                        href="{{ route('admin.invoices.show', $payment->invoice_id) }}">{{ $payment->invoice_id }}</a>
                                </td>
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
</div>
