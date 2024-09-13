<div id="notification-bell" wire:poll.60s>
    <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-notification-3-line"></i>
            @if (count($notifications) >= 1)
                <span class="noti-dot"></span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0"> Notifications </h6>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.notification.index') }}" class="small"> View All</a>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                @if (count($notifications) >= 1)
                    @foreach ($notifications as $notification)
                        <a href="javascript:void();" wire:click.prevent="markAsRead({{ $notification->id }})"
                            class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        @if ($notification->type == 'support-tickets')
                                            <i class="ri-questionnaire-line"></i>
                                        @elseif ($notification->type == 'invoices')
                                            <i class="ri-wallet-line"></i>
                                        @elseif ($notification->type == 'tasks')
                                            <i class="ri-task-line"></i>
                                        @else
                                            <i class="ri-notification-line"></i>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">{{ $notification->title }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $notification->message }}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="ri-thumb-up-line"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <h6 class="mb-1">There is no notifications</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1">You read all notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="p-2 border-top">
                <div class="d-grid">
                    <a class="btn btn-sm btn-link font-size-14 text-center"
                        href="{{ route('admin.notification.index') }}">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
