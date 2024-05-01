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
                            <h4 class="font-size-16 mb-1">{{ ucwords(auth()->guard('admin')->user()->name) }}</h4>
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
                                <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            @can('task.list')
                                <li>
                                    <a href="{{ route('admin.tasks.index') }}" class="waves-effect">
                                        <i class="ri-task-line"></i>
                                        @if (auth()->guard('admin')->user()->pendingTasks()->count() > 0)
                                            <span class="badge rounded-pill bg-success float-end">
                                                {{ auth()->guard('admin')->user()->pendingTasks()->count() }}
                                            </span>
                                        @endif

                                        @if (auth()->guard('admin')->user()->incompleteTasks()->count() > 0)
                                            <span class="badge rounded-pill bg-danger float-end">
                                                {{ auth()->guard('admin')->user()->incompleteTasks()->count() }}
                                            </span>
                                        @endif

                                        @if (auth()->guard('admin')->user()->overdueTasks()->count() > 0)
                                            <span class="badge rounded-pill bg-warning float-end">
                                                {{ auth()->guard('admin')->user()->overdueTasks()->count() }}
                                            </span>
                                        @endif
                                        <span>Tasks</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- Support Tickets --}}
                            @can('support-ticket.list')
                                <li class="{{ request()->routeIs('admin.support-tickets.*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('admin.support-tickets.index') }}"
                                        class="waves-effect {{ request()->routeIs('admin.support-tickets.*') ? 'active' : '' }}">
                                        <i class="ri-questionnaire-line"></i>
                                        <span>Support Tickets</span>
                                    </a>
                                </li>
                            @endcan
                            {{-- Support Tickets --}}
                            @can('invoice.list')
                                <li class="{{ request()->routeIs('admin.invoices.*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('admin.invoices.index') }}"
                                        class="waves-effect {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                                        <i class="ri-wallet-line"></i>
                                        <span>Invoice List</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- Users & Company --}}
                            @canany(['user.list', 'company.list'])
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        {{-- <i class="ri-profile-line"></i> --}}
                                        <i class="ri-user-2-fill"></i>
                                        <span>Users & Companies</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @can('user.list')
                                            <li class="{{ request()->routeIs('admin.users.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.users.index') }}"
                                                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                                    Users
                                                </a>
                                            </li>
                                        @endcan
                                        @can('company.list')
                                            <li class="{{ request()->routeIs('admin.companies.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.companies.index') }}"
                                                    class="{{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                                                    Companies
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            {{-- Promotions --}}
                            @can('promotion.list')
                                <li class="{{ request()->routeIs('admin.promotions.*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('admin.promotions.index') }}"
                                        class="waves-effect {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                                        <i class="ri-advertisement-line"></i>
                                        <span>Promotions</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- Products --}}
                            @can('product.list')
                                <li class="{{ request()->routeIs('admin.products.*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('admin.products.index') }}"
                                        class="waves-effect {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                        <i class="ri-store-2-line"></i>
                                        <span>Products</span>
                                    </a>
                                </li>
                            @endcan

                            {{-- Manage --}}
                            @canany(['staff.list', 'department.list', 'role.list'])
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="ri-equalizer-line"></i>
                                        <span>Manage</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        {{-- Staff --}}
                                        @can('staff.list')
                                            <li class="{{ request()->routeIs('admin.staff.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.staff.index') }}"
                                                    class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                                                    Staff
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Departments --}}
                                        @can('department.list')
                                            <li class="{{ request()->routeIs('admin.departments.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.departments.index') }}"
                                                    class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                                                    Departments
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Roles --}}
                                        @can('role.list')
                                            <li
                                                class="{{ request()->routeIs('admin.roles-permissions.roles.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.roles-permissions.roles.index') }}"
                                                    class="{{ request()->routeIs('admin.roles-permissions.roles.*') ? 'active' : '' }}">
                                                    Roles
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Permissions --}}
                                        @if (auth()->user()->id === 1)
                                            <li
                                                class="{{ request()->routeIs('admin.roles-permissions.permissions.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.roles-permissions.permissions.index') }}"
                                                    class="{{ request()->routeIs('admin.roles-permissions.permissions.*') ? 'active' : '' }}">
                                                    Permissions
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endcanany

                            {{-- Manage Status --}}
                            @canany(['todo-label.list', 'task-status.list', 'ticket-status.list',
                                'ticket-priority.list', 'invoice-status.list'])
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="ri-switch-line"></i>
                                        <span>Manage Status</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        {{-- Todo Labels --}}
                                        @can('todo-label.list')
                                            <li class="{{ request()->routeIs('admin.todo-labels.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.todo-labels.index') }}"
                                                    class="{{ request()->routeIs('admin.todo-labels.*') ? 'active' : '' }}">
                                                    Todo Labels
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Task Status --}}
                                        @can('task-status.list')
                                            <li class="{{ request()->routeIs('admin.task-status.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.task-status.index') }}"
                                                    class="{{ request()->routeIs('admin.task-status.*') ? 'active' : '' }}">
                                                    Task Status
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Ticket Status --}}
                                        @can('ticket-status.list')
                                            <li class="{{ request()->routeIs('admin.ticket-status.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.ticket-status.index') }}"
                                                    class="{{ request()->routeIs('admin.ticket-status.*') ? 'active' : '' }}">
                                                    Ticket Status
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Ticket Priority --}}
                                        @can('ticket-priority.list')
                                            <li class="{{ request()->routeIs('admin.ticket-priority.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.ticket-priority.index') }}"
                                                    class="{{ request()->routeIs('admin.ticket-priority.*') ? 'active' : '' }}">
                                                    Ticket Priority
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- Invoice Status --}}
                                        @can('invoice-status.list')
                                            <li class="{{ request()->routeIs('admin.invoice-status.*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('admin.invoice-status.index') }}"
                                                    class="{{ request()->routeIs('admin.invoice-status.*') ? 'active' : '' }}">
                                                    Invoice Status
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
