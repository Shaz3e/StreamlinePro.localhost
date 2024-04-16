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
                        <h2>Login</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="row mx-5">
                        <div class="col-12 mb-2">
                            <input type="email" name="email" class="form-control input-mask"
                                data-inputmask="'alias': 'email'" placeholder="Email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input type="password" name="password" class="form-control"
                                placeholder="Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>

                        <div class="col-12 mb-">
                            Do not have an account <a href="{{ route('register') }}">Register</a>.
                        </div>
                        <div class="col-12 mb-">
                            Forgot Password <a href="{{ route('forgot.password') }}">Click here</a> to
                            reset.
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
@endpush
