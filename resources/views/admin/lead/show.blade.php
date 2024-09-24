@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Leads',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Leads', 'link' => route('admin.leads.index')],
            ['text' => 'View Lead', 'link' => null],
        ],
    ])

    {{-- Show Record --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Lead Details
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Name</td>
                            <td>{{ $lead->name }}</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>{{ $lead->company }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $lead->country }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <a href="mailto:{{ $lead->email }}">
                                    {{ $lead->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>phone</td>
                            <td>
                                <a href="tel:{{ $lead->phone }}">
                                    {{ $lead->phone }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>product</td>
                            <td>{{ $lead->product }}</td>
                        </tr>
                        <tr>
                            <td>status</td>
                            <td>
                                <span class="badge {{ $lead->getStatusColor() }}">{{ $lead->getStatus() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $lead->created_at->format('l, F j, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $lead->updated_at->format('l, F j, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- /.card --}}
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
