@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Department',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Departments', 'link' => route('admin.departments.index')],
            ['text' => 'Edit', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Company Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $department->name) }}">
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
                                    <option value="1"
                                        {{ old('is_active', $department->is_active) == 1 ? 'selected' : '' }}>Show</option>
                                    <option value="0"
                                        {{ old('is_active', $department->is_active) == 0 ? 'selected' : '' }}>Hide</option>
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
                        <x-form.button />
                        <x-form.button-save-view />
                        <x-form.button-save-create-new />
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
