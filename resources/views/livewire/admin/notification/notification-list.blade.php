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

        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="read" class="form-control form-control-sm form-control-border">
                <option value="">All Notifications</option>
                <option value="true">Read Notifications</option>
                <option value="false">Unread Notifications</option>
            </select>
        </div>
        {{-- /.col --}}

        <div class="col-md-5 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        @hasanyrole(['superadmin', 'developer'])
            <div class="col-md-2 col-sm-12 mb-2">
                <input type="search" wire:model.live="searchUser" class="form-control form-control-sm"
                    placeholder="Search By User...">
            </div>
            {{-- /.col --}}

            <div class="col-md-2 col-sm-12 mb-2">
                <input type="search" wire:model.live="searchAdmin" class="form-control form-control-sm"
                    placeholder="Search By Staff...">
            </div>
            {{-- /.col --}}
        @endhasanyrole
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
                                    <th>Notification</th>
                                    <th>Type</th>
                                    <th>To</th>
                                    <th>On</th>
                                    <th>Read</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalRecords = $notifications->total();
                                    $currentPage = $notifications->currentPage();
                                    $perPage = $notifications->perPage();
                                    $id = $totalRecords - ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach ($notifications as $notification)
                                    <tr wire:key="{{ $notification->id }}">
                                        <td>{{ $id-- }}</td>
                                        <td>
                                            <strong>{{ $notification->title }}</strong>
                                            <p>{{ $notification->message }}</p>
                                        </td>
                                        <td>{{ $notification->type }}</td>
                                        <td>
                                            @if ($notification->user)
                                                {{ $notification->user->name }}
                                            @endif
                                            @if ($notification->admin)
                                                {{ $notification->admin->name }}
                                            @endif
                                        </td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($notification->read_at)
                                                {{ $notification->read_at->diffForHumans() }}
                                            @else
                                                Unread
                                            @endif
                                        </td>
                                        <td>

                                            <a href="javascript:void();"
                                                wire:click.prevent="markAsRead({{ $notification->id }})"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <button wire:click="confirmDelete({{ $notification->id }})"
                                                class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                data-target="#deleteModal">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</div>
@push('styles')
@endpush

@push('scripts')
@endpush
@script
    <script>
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
    </script>
@endscript
