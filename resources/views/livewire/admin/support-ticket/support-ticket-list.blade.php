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
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filters</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <a href="{{ route('admin.support-tickets.create') }}"
                    class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row mb-3">
        <div class="col-md-1 col-sm-12">
            <select wire:model.live="filterInternalTickets" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Internal Ticket</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-12">
            <input type="search" wire:model.live="searchUser" class="form-control form-control-sm" placeholder="Search By User...">
        </div>
        <div class="col-md-2 col-sm-12">
            <input type="search" wire:model.live="searchStaff" class="form-control form-control-sm" placeholder="Search By Staff...">
        </div>
        <div class="col-md-2 col-sm-12">
            <input type="search" wire:model.live="searchDepartment" class="form-control form-control-sm" placeholder="Search By Department...">
        </div>
        <div class="col-md-2 col-sm-12">
            <select wire:model.live="filterByStatusTickets" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Ticket Status</option>
                @foreach ($getTicketStatuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 col-sm-12">
            <select wire:model.live="filterByPriorityTickets" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Ticket Priority</option>
                @foreach ($getTicketPriorities as $priority)
                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 col-sm-12">
            @if (
                $search ||
                    $filterInternalTickets ||
                    $searchUser ||
                    $searchStaff ||
                    $searchDepartment ||
                    $filterByStatusTickets ||
                    $filterByPriorityTickets)
                <button wire:click="resetFilters" class="btn btn-sm btn-block btn-outline-secondary">
                    Reset
                </button>
            @endif
        </div>
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="data" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10%">Ticket#</th>
                                <th style="width: 45%">Ticket</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Priority</th>
                                <th style="width: 15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr wire:key="{{ $ticket->id }}">
                                    <td>
                                        <a class="text-black"
                                            href="{{ route('admin.support-tickets.show', $ticket->id) }}">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                        @if ($ticket->user_id)
                                            Client:
                                            <a class="text-black"
                                                href="{{ route('admin.users.show', $ticket->user_id) }}">
                                                {{ $ticket->user->name }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <h5>
                                            <a class="text-black"
                                                href="{{ route('admin.support-tickets.show', $ticket->id) }}">
                                                {{ $ticket->title }}
                                            </a>
                                        </h5>
                                        @if ($ticket->is_internal == 1)
                                            <span class="badge bg-danger">Internal Ticket</span>
                                        @endif
                                        @if ($ticket->admin_id)
                                            <span class="badge bg-success">
                                                Assigned To: {{ $ticket->admin->name }}</span>
                                        @endif
                                        @if ($ticket->department_id)
                                            <span class="badge bg-dark">Department:
                                                {{ $ticket->department->name }}</span>
                                        @endif
                                        @if ($ticket->attachments > 0)
                                            <span class="badge bg-info">Attachments</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge"
                                            style="background-color: {{ $ticket->status->bg_color }}; color: {{ $ticket->status->text_color }}">
                                            {{ $ticket->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge"
                                            style="background-color: {{ $ticket->priority->bg_color }}; color: {{ $ticket->priority->text_color }}">
                                            {{ $ticket->priority->name }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        @if ($showDeleted)
                                            @can('support-ticket.restore')
                                                <button wire:click="confirmRestore({{ $ticket->id }})"
                                                    class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="ri-arrow-go-back-line"></i>
                                                </button>
                                            @endcan
                                            @can('support-ticket.force.delete')
                                                <button wire:click="confirmForceDelete({{ $ticket->id }})"
                                                    class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="ri-delete-bin-7-line"></i>
                                                </button>
                                            @endcan
                                        @else
                                            @can('support-ticket.read')
                                                <a href="{{ route('admin.support-tickets.show', $ticket->id) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @endcan
                                            @can('support-ticket.update')
                                                <a href="{{ route('admin.support-tickets.edit', $ticket->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            @endcan
                                            @can('support-ticket.delete')
                                                <button wire:click="confirmDelete({{ $ticket->id }})"
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

                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</div>
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
