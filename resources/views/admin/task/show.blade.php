@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View Task',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Task List', 'link' => route('admin.tasks.index')],
            ['text' => 'View', 'link' => null],
        ],
    ])

    @if (session()->get('taskClosed'))
        <div class="alert alert-success">
            Task has been completed you can change status.
            <div class="col-md-2">
                <select name="task_label_id" class="form-control form-control-sm" id="task_label_id"
                    onchange="updateStatus(this.value)">
                    @foreach ($taskLabels as $label)
                        <option value="{{ $label->id }}" {{ $task->task_label_id == $label->id ? 'selected' : '' }}>
                            {{ $label->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    {{-- Show Record Summary --}}
    <div class="row">
        <div class="col-8">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-header">
                    @if (auth()->user()->id === $task->createdBy->id)
                        <a href="{{ route('admin.tasks.edit', $task->id) }}">
                            <i class="ri-pencil-line"></i> Edit
                        </a>
                    @endif
                    <h5>{{ $task->title }}</h5>
                    @if (!session()->get('taskClosed'))
                        <select name="task_label_id" class="form-control form-control-sm" id="task_label_id"
                            onchange="updateStatus(this.value)">
                            @foreach ($taskLabels as $label)
                                <option value="{{ $label->id }}"
                                    {{ $task->task_label_id == $label->id ? 'selected' : '' }}>
                                    {{ $label->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="card-body">
                    <div class="card-text">
                        {!! $task->description !!}
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <small>Created On</small>
                            <br>
                            <strong>{{ $task->created_at->format('l, F j, Y h:i A') }}</strong><br>
                        </div>
                        <div class="col-md-6">
                            <small>Updated On</small>
                            <br>
                            <strong>{{ $task->updated_at->format('l, F j, Y h:i A') }}</strong>
                        </div>
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-2">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <small>Label</small><br>
                    <strong class="badge"
                        style="background-color: {{ $task->label->bg_color }}; color: {{ $task->label->text_color }}">
                        {{ $task->label->name }}
                    </strong><br>

                    <small>Assigned To</small><br>
                    <strong>{{ ucwords($task->assignee->name) }}</strong><br>

                    <small>Created By</small><br>
                    <strong>{{ ucwords($task->createdBy->name) }}</strong><br>

                    <small>Due Date</small><br>
                    @if ($task->due_date < now()->format('Y-m-d H:i:s') && $task->due_date !== null)
                        <strong class="badge bg-danger">Task is Overdue</strong>
                    @elseif ($task->due_date == null)
                        <strong class="badge bg-info">No Due Date</strong>
                    @else
                        <strong>{{ $task->due_date->format('l, F j, Y h:i A') }}</strong>
                    @endif
                </div>
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-2">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">

                    <small>Start Time</small><br>
                    @if ($task->is_started)
                        <strong>{{ $task->start_time->format('d M Y H:i A') }}</strong>
                    @else
                        @if (auth()->user()->id === $task->assignee->id)
                            <a href="?start=1" class="btn btn-sm btn-success">
                                <i class="ri-timer-line"></i> Start
                            </a>
                        @else
                            <small class="badge bg-info">Not Started</small>
                        @endif
                    @endif

                    <br />

                    <small>Complete Time</small><br>
                    @if (!$task->is_started && !$task->is_completed)
                        ...
                    @elseif($task->is_started && $task->is_completed)
                        {{ $task->complete_time->format('d M Y H:i A') }}
                    @else
                        @if (auth()->user()->id === $task->assignee->id)
                            <a href="?complete=1" class="btn btn-sm btn-success">
                                <i class="ri-timer-flash-line"></i> Finish
                            </a>
                        @else
                            <small class="badge bg-info">Not Completed</small>
                        @endif
                    @endif

                    <br />

                    <small>Total Time</small><br>
                    @if ($task->is_started == 0 || $task->is_completed == 0)
                        ...
                    @else
                        <i class="ri-history-line"></i>
                        {{ calcTime($task->start_time, $task->complete_time) }}
                    @endif
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Audit History --}}
    @hasrole('superadmin')
        @if (count($audits) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Audit History</h4>
                        </div>
                        {{-- /.card-header --}}

                        <div class="card-body">
                            <table class="table" id="#audit-log-table">
                                <thead>
                                    <tr>
                                        <th>Audit</th>
                                        <th>IP</th>
                                        <th>Modified At</th>
                                        <th>Records</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $audit)
                                        <tr>
                                            <td></td>
                                            <td>{{ $audit->ip_address }}</td>
                                            <td>{{ $audit->created_at }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm waves-effect waves-light show-audit-modal"
                                                    data-bs-toggle="modal" data-bs-target=".auditLog"
                                                    data-audit-id="{{ $audit->id }}">
                                                    <i class="ri-history-line"></i>
                                                </button>

                                                <button type="button"
                                                    class="btn btn-danger btn-sm waves-effect waves-light delete-audit-log"
                                                    data-audit-id="{{ $audit->id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $audits->links('pagination::bootstrap-5') }}
                        </div>
                        {{-- /.card-body --}}
                    </div>
                    {{-- /.card --}}
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        @endif

        {{-- Audit Log --}}
        <div class="modal fade auditLog" tabindex="-1" aria-labelledby="auditLog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="auditLog">Audit Log</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endhasrole
@endsection

@push('styles')
@endpush

@push('scripts')
    @hasrole('superadmin')
        <script>
            $(document).ready(function() {
                // Audit Log Show Modal
                $('.show-audit-modal').click(function(e) {
                    e.preventDefault();
                    const todoId = $(this).data('audit-id');
                    // Fetch details via AJAX
                    $.ajax({
                        url: `{{ route('admin.users.audit', ':id') }}`.replace(':id', todoId),
                        type: 'GET',
                        success: function(data) {
                            // Populate modal content with fetched data
                            $('.auditLog .modal-body').html(data);
                            // Show the modal
                            $('.auditLog').modal('show');
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });
                $('.delete-audit-log').click(function(e) {
                    e.preventDefault();
                    const todoId = $(this).data('audit-id');

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this audit log!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirms, proceed with deletion
                            $.ajax({
                                url: `{{ route('admin.users.audit.delete', ':id') }}`.replace(
                                    ':id', todoId),
                                type: 'GET',
                                success: function(data) {
                                    // Show success message
                                    Swal.fire('Deleted!',
                                        'Your audit log has been deleted.', 'success');
                                    // reload page
                                    location.reload();
                                },
                                error: function(error) {
                                    console.error('Error:', error);
                                    // Show error message if deletion fails
                                    Swal.fire('Error!',
                                        'Failed to delete audit log or it has been deleted',
                                        'error');
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // If user cancels, show message that the history is safe
                            Swal.fire('Cancelled', 'Your audit log is safe :)', 'info');
                        }
                    });
                });
            });
        </script>
    @endhasrole
    <script>
        // Update status
        function updateStatus(labelId) {
            var taskId = {{ $task->id }};
            var url = '{{ route('admin.tasks.updatestatus', $task->id) }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'task_label_id': labelId
            };
            $.ajax({
                type: 'PATCH',
                url: url,
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    </script>
@endpush
