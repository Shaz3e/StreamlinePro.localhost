@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Company',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Companies', 'link' => route('admin.companies.index')],
            ['text' => 'View Company', 'link' => null],
        ],
    ])

    {{-- Show Record --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Company Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Logo</td>
                            <td>Logo</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $company->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $company->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $company->phone }}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{ $company->website }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $company->country }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $company->address }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                @if ($company->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $company->created_at->format('l, F j, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $company->updated_at->format('l, F j, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <!-- User list -->
    <div class="row">
        <div class="col-md-12">
            @if (count($company->users) > 0)
                <div class="card-header">Company Users</div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company->users as $user)
                                    <tr wire:key="{{ $user->id }}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('D, d M Y') }}</td>
                                        <th>
                                            <a href="{{ route('admin.users.show', $user->id) }}">
                                                View
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @else
                <div class="alert alert-info">
                    No user listed in this company
                </div>
            @endif
        </div>
    </div>
    {{-- /.row --}}

    {{-- Show Audit History --}}
    @if (count($audits) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Audit History
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
                const userId = $(this).data('audit-id');
                // Fetch details via AJAX
                $.ajax({
                    url: `{{ route('admin.companies.audit', ':id') }}`.replace(':id', userId),
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
                const userId = $(this).data('audit-id');

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
                            url: `{{ route('admin.companies.audit.delete', ':id') }}`
                                .replace(
                                    ':id', userId),
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
