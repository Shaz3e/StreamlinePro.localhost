@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Lead',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Leads', 'link' => route('admin.leads.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.leads.store') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="company" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-10">
                                <input type="text" name="company" id="company" class="form-control"
                                    value="{{ old('company') }}">
                                @error('company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="country" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10">
                                <input type="text" name="country" id="country" class="form-control"
                                    value="{{ old('country') }}">
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="product" class="col-sm-2 col-form-label">Product</label>
                            <div class="col-sm-10">
                                <input type="text" name="product" id="product" class="form-control"
                                    value="{{ old('product') }}">
                                @error('product')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="message" class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <input type="text" name="message" id="message" class="form-control"
                                    value="{{ old('message') }}">
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                {{-- Loop through all statuses --}}
                                @foreach (\App\Models\Lead::getStatuses() as $status)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="status_{{ $status }}" value="{{ $status }}"
                                            {{ old('status', $lead->status ?? '') == $status ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="status_{{ $status }}">{{ $status }}</label>
                                    </div>
                                @endforeach
                                @error('status')
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
