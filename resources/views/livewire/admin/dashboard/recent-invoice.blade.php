<div wire:poll.visible>
    <div class="card" style="height: calc(100% - 15px)">
        <div class="card-body">
            <h4 class="card-title">Recent Invoice</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice#</th>
                            <th>ٰInvoice To</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Invoice Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td><a href="{{ route('admin.invoices.show', $invoice->id) }}">Invoice#
                                        {{ $invoice->id }}</a></td>
                                <td>
                                    @if ($invoice->user)
                                        <a href="{{ route('admin.users.show', $invoice->user->id) }}">
                                            {{ $invoice->user->name }}
                                        </a>
                                    @endif
                                    @if ($invoice->company)
                                        <a href="{{ route('admin.companies.show', $invoice->company->id) }}">
                                            {{ $invoice->company->name }}
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $invoice->getStatusColor() }}">
                                        {{ $invoice->getStatus() }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    {{ $currency['symbol'] }}
                                    {{ currencyFormat($invoice->total) }}
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
