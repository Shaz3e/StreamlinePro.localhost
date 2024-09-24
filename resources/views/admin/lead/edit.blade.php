@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Edit Lead',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Leads', 'link' => route('admin.leads.index')],
            ['text' => 'Edit', 'link' => null],
        ],
    ])

    {{-- Create Form --}}

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('put')
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $lead->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="company" class="col-sm-3 col-form-label">Company</label>
                            <div class="col-sm-9">
                                <input type="text" name="company" id="company" class="form-control"
                                    value="{{ old('company', $lead->company) }}">
                                @error('company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="country" class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                                <input type="text" name="country" id="country" class="form-control"
                                    value="{{ old('country', $lead->country) }}">
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $lead->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $lead->phone) }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="product" class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <input type="text" name="product" id="product" class="form-control"
                                    value="{{ old('product', $lead->product) }}">
                                @error('product')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="message" class="col-sm-12 col-form-label">Message</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="message">{!! $lead->message !!}</textarea>
                                @error('message')
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

        <div class="col-md-4">
            <form action="{{ route('admin.leads.updateStatus', $lead->id) }}" method="POST" class="needs-validation">
                @csrf
                @method('put')
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Lead Status</label>
                                    <select name="status" class="form-control">
                                        @foreach (\App\Models\Lead::getStatuses() as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $lead->status ?? '') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="created_by">Created By</label>
                                    <select name="created_by" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach ($staffList as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ old('created_by', $lead->created_by ?? '') == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('created_by')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="updated_by">Updated By</label>
                                    <select name="updated_by" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach ($staffList as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ old('updated_by', $lead->updated_by ?? '') == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('updated_by')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="assigned_by">Assigned By</label>
                                    <select name="assigned_by" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach ($staffList as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ old('assigned_by', $lead->assigned_by ?? '') == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assigned_by')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="assigned_to">Assigned To</label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach ($staffList as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ old('assigned_to', $lead->assigned_to ?? '') == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assigned_to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button text="Update" />
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
