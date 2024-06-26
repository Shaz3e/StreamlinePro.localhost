<div>
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
        <div class="col-md-7 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <div class="btn-group me-2 mb-2 mb-sm-0">
                    <button type="button" class="btn btn-success btn-sm waves-light waves-effect dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-add-fill align-middle me-2"></i> Create New Email
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.email-management.bulk-emails.create') }}"
                            class="dropdown-item btn btn-success btn-sm waves-effect waves-light">
                            <i class="ri-add-fill align-middle me-2"></i> Send Single Email
                        </a>
                        <a href="{{ route('admin.email-management.bulk-email-users.create') }}"
                            class="dropdown-item btn btn-success btn-sm waves-effect waves-light">
                            <i class="ri-add-fill align-middle me-2"></i> Send Email to All Users
                        </a>
                        <a href="{{ route('admin.email-management.bulk-email-staff.create') }}"
                            class="dropdown-item btn btn-success btn-sm waves-effect waves-light">
                            <i class="ri-add-fill align-middle me-2"></i> Send Email to All Staff
                        </a>
                    </div>
                </div>
            </div>
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
                                    <th>Subject</th>
                                    <th>Send To</th>
                                    <th>Send Date</th>
                                    <th>Status</th>
                                    <th>Sent</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bulkEmails as $email)
                                    <tr wire:key="{{ $email->id }}">
                                        <td>{{ $email->subject }}</td>
                                        <td>
                                            @if (!is_null($email->user_id))
                                                @if ($email->is_sent_all_users)
                                                    <span class="badge bg-success">Sent to All Users</span>
                                                @else
                                                    <span class="badge bg-info">{{ count($email->user_id) }} </span>
                                                    User(s)
                                                @endif
                                            @endif
                                            @if (!is_null($email->admin_id))
                                                @if ($email->is_sent_all_admins)
                                                    <span class="badge bg-success">Sent to All Staff</span>
                                                @else
                                                    <span class="badge bg-info">{{ count($email->admin_id) }} </span>
                                                    Staff Members
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $email->send_date->format('d M Y H:i A') }}</small>
                                        </td>
                                        <td>
                                            @if ($email->is_publish)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-info">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($email->is_sent)
                                                <span class="badge bg-success">Sent</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if ($showDeleted)
                                                @can('bulk-email.restore')
                                                    <button wire:click="confirmRestore({{ $email->id }})"
                                                        class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-arrow-go-back-line"></i>
                                                    </button>
                                                @endcan
                                                @can('bulk-email.force.delete')
                                                    <button wire:click="confirmForceDelete({{ $email->id }})"
                                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-delete-bin-7-line"></i>
                                                    </button>
                                                @endcan
                                            @else
                                                @can('bulk-email.read')
                                                    @if ($email->is_sent_all_users)
                                                        <a href="{{ route('admin.email-management.bulk-email-users.show', $email->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @elseif($email->is_sent_all_admins)
                                                        <a href="{{ route('admin.email-management.bulk-email-staff.show', $email->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.email-management.bulk-emails.show', $email->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                                @can('bulk-email.update')
                                                    @if ($email->is_sent_all_users)
                                                        <a href="{{ route('admin.email-management.bulk-email-users.edit', $email->id) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    @elseif($email->is_sent_all_admins)
                                                        <a href="{{ route('admin.email-management.bulk-email-staff.edit', $email->id) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.email-management.bulk-emails.edit', $email->id) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                                @can('bulk-email.delete')
                                                    <button wire:click="confirmDelete({{ $email->id }})"
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
                    {{ $bulkEmails->links() }}
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
