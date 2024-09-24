<div wire:poll.1s>
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
        <div class="col-md-5 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <a href="{{ route('admin.leads.create') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
        <!-- Add new filter for duplicates -->
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDuplicates" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">All Leads</option>
                <option value="true">Show Duplicate Leads</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filters</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
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
                                    <th>#</th>
                                    <th>Lead</th>
                                    <th>Contact</th>
                                    <th>Product</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalRecords = $leads->total();
                                    $currentPage = $leads->currentPage();
                                    $perPage = $leads->perPage();
                                    $id = $totalRecords - ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach ($leads as $lead)
                                    <tr wire:key="{{ $lead->id }}">
                                        <td>{{ $id-- }}</td>
                                        <td>
                                            <a href="{{ route('admin.leads.show', $lead->id) }}">
                                                <h4>{{ $lead->name }}</h4>
                                            </a>
                                            @if ($lead->company)
                                                <span class="badge bg-info">{{ $lead->company }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            Email:
                                            <strong
                                                class="d-block @if ($lead->duplicates > 0) text-danger @endif">{{ $lead->email }}</strong>
                                            Phone:
                                            <strong
                                                class="d-block @if ($lead->duplicates > 0) text-danger @endif">{{ $lead->phone }}</strong>

                                            @if ($lead->duplicates > 0)
                                                <span class="badge bg-warning">Duplicate Lead Detected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($lead->product)
                                                <strong class="badge bg-success">{{ $lead->product }}</strong>
                                            @else
                                                <strong class="badge bg-info">No Product</strong>
                                            @endif
                                        </td>
                                        <td>{{ $lead->country }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $lead->getStatusColor() }}">{{ $lead->getStatus() }}</span>
                                        </td>
                                        <td class="text-right">
                                            @if ($showDeleted)
                                                @can('lead.restore')
                                                    <button wire:click="confirmRestore({{ $lead->id }})"
                                                        class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-arrow-go-back-line"></i>
                                                    </button>
                                                @endcan
                                                @can('lead.force.delete')
                                                    <button wire:click="confirmForceDelete({{ $lead->id }})"
                                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-delete-bin-7-line"></i>
                                                    </button>
                                                @endcan
                                            @else
                                                @can('lead.read')
                                                    <a href="{{ route('admin.leads.show', $lead->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                @endcan
                                                @can('lead.update')
                                                    <a href="{{ route('admin.leads.edit', $lead->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                @endcan
                                                @can('lead.delete')
                                                    <button wire:click="confirmDelete({{ $lead->id }})"
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
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</div>
@push('styles')
    <!-- Lightbox css -->
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <!-- Magnific Popup-->
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- lightbox init js-->
    <script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>
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
