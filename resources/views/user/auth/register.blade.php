@extends('components.layouts.auth')

@section('content')
    <div class="s3-container">
        <div class="s3-page">
            <div>
                <h2>Welcome to {{ config('app.name') }}</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu ut dolor placerat tincidunt ut nec
                    odio.</p>
            </div>
        </div>
        {{-- /.s3-page --}}

        <div class="s3-authbox">
            <div class="container">
                <div class="row m-2">
                    <div class="col-12 text-center">
                        <h2>Register</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('register.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row mx-5">

                        <div class="col-12 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Your Name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control input-mask" data-inputmask="'alias':'email'" placeholder="Email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>

                        <div class="col-12 mb-">
                            Already registered <a href="{{ route('login') }}">Login</a> here.
                        </div>
                    </div>
                </form>
            </div>
            {{-- /.container --}}
        </div>
        {{-- /.s3-authbox --}}
    </div>
    {{-- /.s3-container --}}
@endsection

@push('styles')
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".input-mask").inputmask()
        });
    </script>
@endpush
