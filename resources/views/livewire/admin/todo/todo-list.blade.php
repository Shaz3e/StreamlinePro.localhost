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
        <div class="col-md-2 col-sm-12">
            <select wire:model.live="filterStatus" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Status</option>
                <option value="">All</option>
                @foreach ($getTodoStatus as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-5 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Active/Deleted</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <a href="{{ route('admin.todos.create') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 70%">My Todo</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todos as $todo)
                                <tr wire:key="{{ $todo->id }}">

                                    <td>{{ $todo->title }}</td>
                                    <td>{{ $todo->status->name }}</td>
                                    <td class="text-right">
                                        @if ($showDeleted)
                                            @can('todo.restore')
                                                <button wire:click="confirmRestore({{ $todo->id }})"
                                                    class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="ri-arrow-go-back-line"></i>
                                                </button>
                                            @endcan
                                            @can('todo.force.delete')
                                                <button wire:click="confirmForceDelete({{ $todo->id }})"
                                                    class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="ri-delete-bin-7-line"></i>
                                                </button>
                                            @endcan
                                        @else
                                            @can('todo.read')
                                                <a href="{{ route('admin.todos.show', $todo->id) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            @endcan
                                            @can('todo.update')
                                                <a href="{{ route('admin.todos.edit', $todo->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            @endcan
                                            @can('todo.delete')
                                                <button wire:click="confirmDelete({{ $todo->id }})"
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
                    {{ $todos->links() }}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
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
