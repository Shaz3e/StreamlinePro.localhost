            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!-- User details -->
                    <div class="user-profile text-center mt-3">
                        <div class="">
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt=""
                                class="avatar-md rounded-circle">
                        </div>
                        <div class="mt-3">
                            <h4 class="font-size-16 mb-1">{{ auth()->guard('admin')->user()->name }}</h4>
                            <span class="text-muted"><i
                                    class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                                Online</span>
                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="waves-effect {{ request()->routeIs('admin.dashboard') }}">
                                    <i class="ri-dashboard-line"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('admin.users.*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    {{-- <i class="ri-profile-line"></i> --}}
                                    <i class="ri-user-2-fill"></i>
                                    <span>Customers</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li class="{{ request()->routeIs('admin.users.*') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                            Customers
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('admin.companies.*') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.companies.index') }}"
                                            class="{{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                                            Companies
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
