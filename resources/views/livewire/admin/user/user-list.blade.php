<div class="row">
    <div class="row mb-2">
        <div class="col-1">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-9">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        <div class="col-2">
            <div class="d-grid">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm btn-flat btn-block">
                    <i class="ri-add-line"></i> Create
                </a>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="data" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->company != null)
                                        {{ $user->company->name }}
                                    @endif
                                </td>
                                <td>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" wire:change="toggleStatus({{ $user->id }})"
                                            id="is_active_{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                        <label for="is_active_{{ $user->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <a wire:navigate href="{{ route('admin.users.show', $user->id) }}"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a wire:navigate href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $user->id }})"
                                        class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@script
    <script>
        document.addEventListener('statusChanged', () => {
            Toast.fire({
                icon: 'success',
                title: "Status has been updated successfully",
            })
        })

        
        document.addEventListener('error', () => {
            Toast.fire({
                icon: 'error',
                title: "Record not found",
            })
        })

        document.addEventListener('showDeleteConfirmation', () => {
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
