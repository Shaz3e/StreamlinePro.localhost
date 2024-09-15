<div class="row mb-3">
    {{-- New Users --}}
    <div wire:poll.visible class="col-md-8 col-sm-12">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <h4 class="card-title">Recent User Signup</h4>
                <div class="table-resposnive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr wire:key="{{ $user->id }}">
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->company)
                                            <a href="{{ route('admin.companies.show', $user->company->id) }}">
                                                {{ $user->company->name }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <x-is-active-badge :isActive="$user->is_active" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- /.table-resposnive --}}
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}

    {{-- Users Count --}}
    <div wire:poll.visible class="col-md-4">
        <div class="row">
            {{-- New Users --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">New Users</p>
                                <h4 class="mb-2">{{ $currentMonthUsers }}</h4>
                                <p class="text-muted mb-0">
                                    <span
                                        class="{{ $newUserPercentageChange > 0 ? 'text-success' : 'text-danger' }} fw-bold font-size-12 me-2">
                                        <i
                                            class="{{ $newUserPercentageChange > 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} me-1 align-middle"></i>
                                        {{ number_format($newUserPercentageChange, 1) }}%
                                    </span>
                                    from previous month
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-user-add-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Last Month Users --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Last Month</p>
                                <h4 class="mb-2">{{ $lastMonthUsers }}</h4>
                                <p class="text-muted mb-0">
                                    User signed up
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-user-star-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Total Users --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Users</p>
                                <h4 class="mb-2">{{ $totalUsers }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-user-3-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Active Company --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Active Company</p>
                                <h4 class="mb-2">{{ $companies }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-building-4-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Active Users --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Active Users</p>
                                <h4 class="mb-2">{{ $activeUsers }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-user-heart-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Inactive Users --}}
            <div class="col-md-6">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Inactive Users</p>
                                <h4 class="mb-2">{{ $inActiveUsers }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-transparent text-primary rounded-3">
                                    <i class="ri-user-unfollow-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    </div>
    {{-- .col --}}
</div>
{{-- /.row --}}
