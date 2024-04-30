@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Profile',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'My Profile', 'link' => null],
        ],
    ])
    
    {{-- My details --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Profile</div>
                <form action="{{ route('profile.store', $user->id) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-md-4 col-sm-4">
                                <input name="email" id="email" class="form-control input-mask"
                                    data-inputmask="'alias': 'email'" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        {{-- <button type="submit" name="updateProfile" class="btn btn-success waves-effect waves-light">
                            <i class="ri-save-line align-middle me-2"></i> Update Profile
                        </button> --}}
                        <x-form.button name="updateProfile" text="Update Profile" icon="ri-save-line" />
                    </div>
                </form>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Change Password --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Change Password</div>
                <form action="{{ route('profile.store', $user->id) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('post')
                    <div class="card-body">
                        @if(!session()->has('token'))
                        <div class="row mb-3">
                            <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-md-4 col-sm-4">
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    value="{{ old('current_password') }}" required>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        @endif
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-md-4 col-sm-4">
                                <input type="password" name="password" id="password" class="form-control"
                                    value="{{ old('password') }}" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-md-4 col-sm-4">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    value="{{ old('confirm_password') }}" required>
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        {{-- <button type="submit" name="updatePassword" class="btn btn-success waves-effect waves-light">
                            <i class="ri-save-line align-middle me-2"></i> Change Password
                        </button> --}}
                        <x-form.button name="updatePassword" text="Change Password" icon="ri-save-line" />
                    </div>
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
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        // Input mask
        $(document).ready(function() {
            $(".input-mask").inputmask()
        });
    </script>
@endpush
