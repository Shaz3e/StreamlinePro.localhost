<div>
    {{-- Invoice Summary Report --}}
    @include('livewire.admin.invoice.invoice-summary')

    {{-- Invoice Search & Filters --}}
    <div class="row mb-3">
        <div class="col-md-1 col-sm-12 mb-2">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-9 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <a href="{{ route('admin.invoices.create') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row mb-3">
        <div class="col-md-2 col-sm-12 mb-2">
            <input type="search" wire:model.live="searchUser" class="form-control form-control-sm"
                placeholder="Search By User...">
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <input type="search" wire:model.live="searchCompany" class="form-control form-control-sm"
                placeholder="Search By Company...">
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="filterStatus" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Status</option>
                @foreach ($invoiceStatuses as $value => $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="filterLabel" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Label</option>
                @foreach ($invoiceLabels as $label)
                    <option value="{{ $label->id }}">
                        {{ $label->name }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filters</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <button wire:click="resetFilters" class="btn btn-sm btn-block btn-outline-secondary">
                Reset
            </button>
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
                                    <th>#</th>
                                    <th style="width: 45%">Invoice Details</th>
                                    <th style="20%">Status</th>
                                    <th style="10%">Price</th>
                                    <th style="width: 10%">Label</th>
                                    <th style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalRecords = $invoices->total();
                                    $currentPage = $invoices->currentPage();
                                    $perPage = $invoices->perPage();
                                    $id = $totalRecords - ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    <tr wire:key="{{ $invoice->id }}">
                                        <td>{{ $id-- }}</td>
                                        <td>
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}">
                                                Invoice# {{ $invoice->id }}
                                            </a>
                                            @if ($invoice->company)
                                                <span class="badge bg-success">
                                                    {{ $invoice->company->name }}
                                                </span>
                                            @endif
                                            @if ($invoice->user)
                                                <span class="badge bg-success">
                                                    {{ $invoice->user->name }}
                                                </span>
                                            @endif
                                            @if ($invoice->products()->count() > 0)
                                                @foreach ($invoice->products as $product)
                                                    <span class="badge bg-warning">
                                                        {{ $product->item_description }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <strong
                                                class="badge {{ $invoice->getStatusColor() }}">{{ $invoice->getStatus() }}</strong>
                                        </td>
                                        <td>
                                            <span>Total:
                                                <strong>
                                                    {{ $currency['symbol'] }}
                                                    {{ $invoice->total }}
                                                </strong>
                                            </span>
                                            <br>
                                            <span>Paid:
                                                <strong>
                                                    {{ $currency['symbol'] }}
                                                    {{ $invoice->payments->sum('amount') }}
                                                </strong>
                                            </span>
                                            <br>
                                            <span>Balance:
                                                <strong>
                                                    {{ $currency['symbol'] }}
                                                    {{ $invoice->total - $invoice->payments->sum('amount') }}
                                                </strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge"
                                                style="background-color: {{ $invoice->label->bg_color }};color: {{ $invoice->label->text_color }}">
                                                {{ $invoice->label->name }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            @if ($showDeleted)
                                                @can('invoices.restore')
                                                    <button wire:click="confirmRestore({{ $invoice->id }})"
                                                        class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-arrow-go-back-line"></i>
                                                    </button>
                                                @endcan
                                                @can('invoices.force.delete')
                                                    <button wire:click="confirmForceDelete({{ $invoice->id }})"
                                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-delete-bin-7-line"></i>
                                                    </button>
                                                @endcan
                                            @else
                                                @can('invoices.read')
                                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                @endcan
                                                @can('invoices.update')
                                                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                @endcan
                                                @can('invoices.delete')
                                                    <button wire:click="confirmDelete({{ $invoice->id }})"
                                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                @endcan
                                            @endif
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
@push('styles')
@endpush

@push('scripts')
@endpush
@script
    <script>
        // Status Changed
        document.addEventListener('statusChanged', () => {
            Toast.fire({
                icon: 'success',
                title: "Status has been updated successfully",
            })
        })

        // Error
        document.addEventListener('error', () => {
            Toast.fire({
                icon: 'error',
                title: "Record not found",
            })
        })

        // Show Delete Confirmation
        document.addEventListener('showDeleteConfirmation', () => {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('deleteConfirmed');
                    Swal.fire({
                        title: "Deleted!",
                        text: "The record has been deleted.",
                        icon: "success"
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'This record is safe :)',
                        'error'
                    );
                }
            });
        })

        // Show Restore Confirmation
        document.addEventListener('confirmRestore', () => {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to restore this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, restore it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('restored');
                    Swal.fire({
                        title: "Restored!",
                        text: "The record has been restored.",
                        icon: "success"
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'This record is still deleted :)',
                        'error'
                    );
                }
            });
        })

        // Show Force Delete Confirmation
        document.addEventListener('confirmForceDelete', () => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('forceDeleted');
                    Swal.fire({
                        title: "Deleted!",
                        text: "The record has been deleted.",
                        icon: "success"
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'This record is deleted but can be restore later :)',
                        'error'
                    );
                }
            });
        })
    </script>
@endscript
