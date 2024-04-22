@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Permission',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Permissions', 'link' => route('admin.roles-permissions.permissions.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.roles-permissions.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Permission Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $permission->name) }}">
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="ri-save-line align-middle me-2"></i> Update
                        </button>
                    </div>
                    {{-- /.card-footer --}}
                </div>
                {{-- /.card --}}
            </form>
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
