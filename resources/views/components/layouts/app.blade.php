<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/remixicon.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('styles')

    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    {{-- Livewire Styles --}}
    @livewireStyles
</head>

<body data-topbar="light">

    <!-- Loader -->
    {{-- <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div> --}}

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Check if the user is logged in as an admin -->
        @if (auth()->guard('admin')->check())
            <x-admin-header />
            <x-admin-sidebar />
            <!-- Check if the user is logged in as a regular user -->
        @elseif (auth()->check())
            <x-user-header />
            <x-user-sidebar />
        @endif

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @if (session()->has('token'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    <strong>Change Your Password</strong> We strongly recommand to change your password before proceeding further as this the temporarly login session.
                                </div>
                            </div>
                        </div>
                    @endif
                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <x-footer />

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    {{-- <x-rightsidebar /> --}}

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/remix-icons-list.js') }}"></script>

    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @if (Session::has('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}",
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}",
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            Toast.fire({
                icon: 'info',
                title: "{{ session('info') }}",
            })
        </script>
    @endif
    @if (Session::has('warning'))
        <script>
            Toast.fire({
                icon: 'warning',
                title: "{{ session('warning') }}",
            })
        </script>
    @endif


    @stack('scripts')

    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>

    <x-appjs />

    {{-- Livewire Scripts --}}
    @livewireScripts

</body>

</html>
