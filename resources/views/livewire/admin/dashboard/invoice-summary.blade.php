<div wire:poll.visible>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Unpaid Invoices</p>
                            <h4 class="mb-2">{{ $unpaidInvoices }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-transparent text-primary rounded-3">
                                <i class="ri-safe-2-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.card --}}
        <div class="col-md-3">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Partially Paid Invoices</p>
                            <h4 class="mb-2">{{ $partialPaidInvoices }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-transparent text-primary rounded-3">
                                <i class="ri-swap-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.card --}}
        <div class="col-md-3">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Unpaid Amount</p>
                            <h4 class="mb-2">{{ $currency['symbol'] }}{{ currencyFormat($unpaidInvoiceAmount) }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-transparent text-primary rounded-3">
                                <i class="ri-safe-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.card --}}
        <div class="col-md-3">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Partially Paid Amount</p>
                            <h4 class="mb-2">{{ $currency['symbol'] }}{{ currencyFormat($partialPaidInvoiceAmount) }}
                            </h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-transparent text-primary rounded-3">
                                <i class="ri-swap-box-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.row --}}
</div>
