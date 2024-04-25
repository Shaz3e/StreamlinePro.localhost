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

    {{-- Show Record Summary --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Status</small><br>
                    <strong class="badge" style="background-color: {{ $task->status->bg_color }}; color: {{ $task->status->text_color }}">
                        {{ $task->status->name }}
                    </strong>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Assigned To</small><br>
                    <strong>{{ ucwords($task->assignee->name) }}</strong>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Created By</small><br>
                    <strong>{{ ucwords($task->createdBy->name )}}</strong>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Closed</small><br>
                    @if ($task->closed == 0)
                        <strong class="badge bg-danger">Task Not Closed</strong>
                    @else
                        <strong class="badge bg-success">Task Closed</strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- /.row --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Started At</small><br>
                    @if ($task->start_date == null)
                        <strong class="badge bg-danger">Not Started</strong>
                    @else
                        <strong>{{ date('l, F j, Y h:i A', strtotime($task->start_date)) }}</strong>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Due Date</small><br>
                    @if ($task->due_date < now()->format('Y-m-d H:i:s') && $task->due_date !== null)
                        <strong class="badge bg-danger">Task is Overdue</strong>
                    @elseif ($task->due_date == null)
                        <strong class="badge bg-info">No Due Date</strong>
                    @else
                        <strong>{{ date('l, F j, Y h:i A', strtotime($task->due_date)) }}</strong>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Created On</small><br>
                    <strong>{{ $task->created_at->format('l, F j, Y h:i A') }}</strong>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small>Updated On</small><br>
                    <strong>{{ $task->updated_at->format('l, F j, Y h:i A') }}</strong>
                </div>
            </div>
        </div>
    </div>
    {{-- /.row --}}
    <div class="row">
        <div class="col-12">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="card-title">
                        <h5>{{ $task->title }}</h5>
                    </div>
                    {{-- /.card-title --}}
                    <div class="card-text">
                        {!! $task->description !!}
                    </div>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Audit History --}}
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
@endsection

@push('styles')
@endpush

@push('scripts')
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
@endpush
