@extends('components.layouts.app')

@section('content')
@include('partials.page-header', [
    'title' => 'Create New Todo Status',
    'breadcrumbs' => [
        ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
        ['text' => 'Todo Status List', 'link' => route('admin.todo-status.index')],
        ['text' => 'Create', 'link' => null],
    ],
])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.todo-status.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="is_active" class="col-sm-2 col-form-label">Show/Hide</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="is_active" required>
                                    <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Show</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Hide</option>
                                </select>
                                @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="ri-save-line align-middle me-2"></i> Create
                        </button>
                    </div>
                    {{-- /.card-footer --}}
                </form>
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
@endpush
