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
            <form action="{{ route('admin.roles-permissions.permissions.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Permission Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
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
                        <x-form.button />
                        <x-form.button-save-view />
                        <x-form.button-save-create-new />
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
