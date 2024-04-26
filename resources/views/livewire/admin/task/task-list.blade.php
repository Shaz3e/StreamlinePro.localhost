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
                @foreach ($taskStatusList as $status)
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
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row" wire:poll.60s>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 47%">Tasks</th>
                                    <th style="width: 12%">Started At</th>
                                    <th style="width: 12%">Completed At</th>
                                    <th style="width: 12%">Total Time</th>
                                    <th style="width: 12%">Due At</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr wire:key="{{ $task->id }}">
                                        <td>
                                            <h4>{{ $task->title }}</h4>
                                            <span class="badge"
                                                style="background-color:{{ $task->status->bg_color }}; color:{{ $task->status->text_color }}">
                                                {{ $task->status->name }}
                                            </span>
                                            <span class="badge bg-success">
                                                {{ $task->createdBy->name }}
                                            </span>
                                            @role('superadmin')
                                                <span class="badge bg-info">
                                                    Assigned To: {{ $task->assignee->name }}
                                                </span>
                                            @endrole
                                        </td>
                                        <td>
                                            @if ($task->is_started)
                                                {{ date('d M Y H:i A', strtotime($task->start_time)) }}
                                            @else
                                                <button type="submit" wire:click="startTask({{ $task->id }})"
                                                    class="btn btn-sm btn-success">
                                                    <i class="ri-timer-line"></i> Start</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$task->is_started && !$task->is_completed)
                                                ...
                                            @elseif($task->is_started && $task->is_completed)
                                                {{ date('d M Y H:i A', strtotime($task->complete_time)) }}
                                            @else
                                                <button type="submit" wire:click="completeTask({{ $task->id }})"
                                                    class="btn btn-sm btn-success">
                                                    <i class="ri-timer-flash-line"></i> Finish</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($task->is_started == 0 || $task->is_completed == 0)
                                                ...
                                            @else
                                                <i class="ri-history-line"></i>
                                                {{ calcTime($task->start_time, $task->complete_time) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($task->due_date < now()->format('Y-m-d H:i:s') && $task->due_date !== null)
                                                <small class="text-danger">Task is Overdue</small>
                                            @elseif (!is_null($task->due_date))
                                                <small class="text-primary">
                                                    {{ date('d M Y H:i A', strtotime($task->due_date)) }}
                                                </small>
                                            @else
                                                <small class="text-muted">No Due Date</small>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if ($showDeleted)
                                                @can('task.restore')
                                                    <button wire:click="confirmRestore({{ $task->id }})"
                                                        class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-arrow-go-back-line"></i>
                                                    </button>
                                                @endcan
                                                @can('task.force.delete')
                                                    <button wire:click="confirmForceDelete({{ $task->id }})"
                                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="ri-delete-bin-7-line"></i>
                                                    </button>
                                                @endcan
                                            @else
                                                @can('task.read')
                                                    <a href="{{ route('admin.tasks.show', $task->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                @endcan
                                                @can('task.update')
                                                    <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                @endcan
                                                @can('task.delete')
                                                    <button wire:click="confirmDelete({{ $task->id }})"
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
                    {{ $tasks->links() }}
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
        // Task Started
        document.addEventListener('taskStarted', () => {
            Toast.fire({
                icon: 'success',
                title: "The task has been started",
            })
        })
        document.addEventListener('TaskClosed', () => {
            Toast.fire({
                icon: 'success',
                title: "The task has been completed",
            })
        })
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
