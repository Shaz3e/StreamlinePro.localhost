<div>
    <div class="row mb-3">
        <div class="col-md-9 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="filterStatus" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Status</option>
                @foreach ($invoiceStatuses as $value => $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-1 col-sm-12 mb-2">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 55%">Invoice Details</th>
                                    <th style="10%">Status</th>
                                    <th style="10%">Price</th>
                                    <th style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr wire:key="{{ $invoice->id }}">
                                        <td>
                                            <a href="{{ route('invoice.show', $invoice->id) }}">
                                                Invoice# {{ $invoice->id }}
                                            </a>
                                        </td>
                                        <td>
                                            <strong
                                                class="badge {{ $invoice->getStatusColor() }}">{{ $invoice->getStatus() }}</strong>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $invoice->total }}
                                            </strong>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</div>
