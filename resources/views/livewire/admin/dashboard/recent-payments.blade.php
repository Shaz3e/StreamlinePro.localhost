<div class="card" wire:poll.5s.visible style="height: calc(100% - 15px)">
    <div class="card-header">
        <h4 class="card-title">Latest Transactions</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Transaction Date</th>
                        <th>Created At</th>
                        <th class="text-center" style="width: 15%">Invoice #</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->transaction_number }}</td>
                            <td>{{ $payment->transaction_date->format('l, F j, Y') }}</td>
                            <td>{{ $payment->created_at->format('l, F j, Y') }}</td>
                            <td class="text-center"><a
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
