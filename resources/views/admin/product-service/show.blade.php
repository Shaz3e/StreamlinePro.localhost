@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Product Service List', 'link' => route('admin.product-service.index')],
            ['text' => 'View ', 'link' => null],
        ],
    ])

    {{-- Show Record --}}
    <div class="row">
        <div class="col-md-9">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <small class="d-block">Name</small>
                    <h3 class="card-title mb-3">{{ $productService->name }}</h3>
                    <small class="d-block">Description</small>
                    <div class="card-text">{!! $productService->description !!}</div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-success btn-sm waves-effect waves-light"
                        href="{{ route('admin.product-service.edit', $productService->id) }}">
                        <i class="ri-edit-line align-middle me-2"></i> Edit
                    </a>
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <small class="d-block">Type</small>
                    <strong class="d-block mb-3">{{ $productService->type }}</strong>
                    <small class="d-block">Price</small>
                    <strong class="d-block mb-3">{{ $productService->price }}</strong>
                    <small class="d-block">Status</small>
                    <strong class="d-block mb-3"><x-is-active-badge :isActive="$productService->is_active" /></strong>
                    <small class="d-block">Created At</small>
                    <strong class="d-block mb-3">{{ $productService->created_at->format('l, F j, Y') }}</strong>
                    <small class="d-block">Updated At</small>
                    <strong class="d-block mb-3">{{ $productService->updated_at->format('l, F j, Y') }}</strong>
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}


    {{-- Show Audit History --}}
    @hasanyrole(['superadmin', 'developer', 'tester'])
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
    @endhasanyrole
@endsection

@push('styles')
@endpush

@push('scripts')
    @hasanyrole(['superadmin', 'developer', 'tester'])
        <script>
            $(document).ready(function() {
                // Audit Log Show Modal
                $('.show-audit-modal').click(function(e) {
                    e.preventDefault();
                    const productId = $(this).data('audit-id');
                    // Fetch details via AJAX
                    $.ajax({
                        url: `{{ route('admin.product-service.audit', ':id') }}`.replace(':id',
                            productId),
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
                    const productId = $(this).data('audit-id');

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
                                url: `{{ route('admin.product-service.audit.delete', ':id') }}`
                                    .replace(
                                        ':id', productId),
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
    @endhasanyrole
@endpush
