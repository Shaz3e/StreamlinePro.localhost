<div>
    @hasanyrole(json_decode(DiligentCreators('can_access_task_summary')))
        @livewire('admin.dashboard.task-summary')
    @endhasanyrole

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
            <select wire:model.live="filterOverdueTask" class="form-control form-control-sm form-control-border">
                <option value="" selected>Filter by Overdue</option>
                <option value="0">Hide Overdue Task</option>
                <option value="1">Show Overdue Task</option>
            </select>
        </div>
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

    <div class="row mb-3">
        <div class="col-md-3 col-sm-12">
            <select wire:model.live="filterLabel" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Label</option>
                <option value="">All</option>
                @foreach ($taskLabels as $label)
                    <option value="{{ $label->id }}">{{ $label->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12 mb-2">
            <select wire:model.live="filterStartedTask" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filter by Started/Not Started</option>
                <option value="0">Show Not Started Task</option>
                <option value="1">Show Started Task</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12 mb-2">
            <select wire:model.live="filterCompletedTask" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filter by Completed/Not Completed</option>
                <option value="0">Show Not Completed Task</option>
                <option value="1">Show Completed Task</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filter Active/Deleted</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
    </div>
    {{-- .row --}}

    <div class="row" wire:poll.60s>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 30%">Tasks</th>
                                    <th style="width: 12%"><small>Started At</small></th>
                                    <th style="width: 12%"><small>Completed At</small></th>
                                    <th style="width: 12%"><small>Task Complete Time</small></th>
                                    <th style="width: 12%"><small>Total Time</small></th>
                                    <th style="width: 12%"><small>Due At</small></th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalRecords = $tasks->total();
                                    $currentPage = $tasks->currentPage();
                                    $perPage = $tasks->perPage();
                                    $id = $totalRecords - ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach ($tasks as $task)
                                    <tr wire:key="{{ $task->id }}">
                                        <td>{{ $id-- }}</td>
                                        <td>
                                            <h4>{{ $task->title }}</h4>
                                            <span class="badge"
                                                style="background-color:{{ $task->label->bg_color }}; color:{{ $task->label->text_color }}">
                                                {{ $task->label->name }}
                                            </span>
                                            <span class="badge bg-success">
                                                Created By: {{ $task->createdBy->name }}
                                            </span>
                                            @role('superadmin')
                                                <span class="badge bg-info">
                                                    Assigned To: {{ $task->assignee->name }}
                                                </span>
                                            @endrole
                                        </td>
                                        <td>
                                            @if ($task->is_started)
                                                {{ $task->start_time->format('d M Y H:i A') }}
                                            @else
                                                @if (auth()->user()->id == $task->assignee->id)
                                                    <button type="submit" wire:click="startTask({{ $task->id }})"
                                                        class="btn btn-sm btn-success">
                                                        <i class="ri-timer-line"></i> Start</button>
                                                @else
                                                    <small class="badge bg-info">Not Started</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$task->is_started && !$task->is_completed)
                                                ...
                                            @elseif($task->is_started && $task->is_completed)
                                                {{ $task->complete_time->format('d M Y H:i A') }}
                                            @else
                                                @if (auth()->user()->id == $task->assignee->id)
                                                    <button type="submit"
                                                        wire:click="completeTask({{ $task->id }})"
                                                        class="btn btn-sm btn-success">
                                                        <i class="ri-timer-flash-line"></i> Finish</button>
                                                @else
                                                    <small class="badge bg-info">Not Completed</small>
                                                @endif
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
                                            @if ($task->is_started == 0 || $task->is_completed == 0)
                                                ...
                                            @else
                                                <i class="ri-history-line"></i>
                                                {{ calcTime($task->created_at, $task->complete_time) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($task->due_date < now()->format('Y-m-d H:i:s') && $task->due_date !== null)
                                                <small class="text-danger">Task is Overdue</small>
                                            @elseif (!is_null($task->due_date))
                                                <small class="text-primary">
                                                    {{ $task->due_date->format('d M Y H:i A') }}
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
