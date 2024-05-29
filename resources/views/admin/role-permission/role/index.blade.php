@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Roles',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Roles List', 'link' => null],
        ],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @can('role.create')
                    <div class="card-header">
                        <a href="{{ route('admin.roles-permissions.roles.create') }}" class="btn btn-success btn-sm">
                            Add Role
                        </a>
                    </div>
                    {{-- /.card-header --}}
                @endcan
                <div class="card-body">
                    <div class="table-responsive mb-0 fixed-solution">
                        <table id="data" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('role.update')
                                                <a href="{{ route('admin.roles-permissions.roles.edit', $role->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            @endcan
                                            @can('role.delete')
                                                <form action="{{ route('admin.roles-permissions.roles.destroy', $role->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="DeleteFormSubmit(this)"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-response --}}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        function DeleteFormSubmit(element) {
            element.closest('form').submit()
        }
    </script>
@endpush
