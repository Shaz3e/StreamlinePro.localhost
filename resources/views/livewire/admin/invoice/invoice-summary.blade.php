<div class="row mb-3">
    <div class="col-3">
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
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Partially Paid Invoices</p>
                        <h4 class="mb-2">{{ $partialPaidInvoices }}</h4>
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
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Paid Invoices</p>
                        <h4 class="mb-2">{{ $totalPaidInvoices }}</h4>
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
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Cancelled Invoices</p>
                        <h4 class="mb-2">{{ $cancelledInvoices }}</h4>
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
</div>
{{-- /.row --}}

<div class="row mb-3">
    <div class="col-4">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Unpaid Amount</p>
                        <h4 class="mb-2">{{ $totalAmount }}</h4>
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
    <div class="col-4">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Paid Amount</p>
                        <h4 class="mb-2">{{ $totalPaidAmount }}</h4>
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
    <div class="col-4">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Due Amount</p>
                        <h4 class="mb-2">{{ $totalDueAmount }}</h4>
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
</div>
{{-- /.row --}}
