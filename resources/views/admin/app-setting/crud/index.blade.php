@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'App Settings',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    <div class="row mb-3">
        <div class="col-3">
            <div class="d-grid">
                <a href="{{ route('admin.app-settings.create') }}" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create New App Setting
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appSettings as $setting)
                                    <tr>
                                        <td>{{ $setting->id }}</td>
                                        <td>{{ $setting->name }}</td>
                                        <td>{{ $setting->value }}</td>
                                        <td>
                                            <a href="{{ route('admin.app-settings.edit', $setting->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-responsive --}}
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    {{ $appSettings->links('pagination::bootstrap-5') }}
                </div>
                {{-- /.card-footer --}}
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
