@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New App Settings',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'App Settings', 'link' => route('admin.app-settings.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>Warning!</strong> Update this field may cause error in the application change this if you know what you are doing.
            </div>
        </div>
    </div>
    {{-- /.row --}}

    <div class="row mb-3">
        <div class="col-3">
            <div class="d-grid">
                <a href="{{ route('admin.app-settings.index') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Back to App Settings
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.app-settings.update', $appSetting->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Setting Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $appSetting->name) }}" required>
                                    @error('name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            {{-- /.col --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="value">Setting Value</label>
                                    <input type="text" name="value" class="form-control" id="value"
                                        value="{{ old('value', $appSetting->value) }}" required>
                                    @error('value')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button />
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
@endpush
