@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Staff',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Staff', 'link' => route('admin.staff.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.staff.store') }}" method="POST" class="needs-validation" novalidate>
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
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" id="email" class="form-control input-mask"
                                    data-inputmask="'alias': 'email'" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="mobile" class="col-sm-2 col-form-label">Mobile Number</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" id="mobile" class="form-control" minlength="12"
                                    maxlength="20" value="{{ old('mobile') }}">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="department_id" class="col-sm-2 col-form-label">Departments</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" multiple name="department_id[]" id="department_id">
                                    <option value="">Select</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="roles" class="col-sm-2 col-form-label">Roles</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" multiple name="roles[]" id="roles">
                                    <option value="">Select</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    required>
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="is_active" class="col-sm-2 col-form-label">Can Login?</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="is_active" required>
                                    <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Yes - User can
                                        login</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>No - User cannot
                                        login</option>
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
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        // Input mask
        $(document).ready(function() {
            $('.select2').select2();
            $(".input-mask").inputmask();
            $("#mobile").inputmask({
                mask: '+999999999999',
                placeholder: '+____________',
                greedy: false,
                definations: {
                    '9': {
                        validator: '[0-9]',
                        cardinality: 1
                    }
                }
            });
        });
    </script>
@endpush
