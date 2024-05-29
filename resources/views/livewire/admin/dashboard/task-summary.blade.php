<div class="row mb-3">
    {{-- Not Started Task --}}
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Not Started</p>
                        <h4 class="mb-2">{{ $taskNotStarted }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-transparent text-primary rounded-3">
                            <i class="ri-chat-new-line font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}

    {{-- Not Completed Task --}}
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Not Completed</p>
                        <h4 class="mb-2">{{ $taskNotCompleted }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-transparent text-primary rounded-3">
                            <i class="ri-discuss-line font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}

    {{-- Not Completed Task --}}
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Overdue Tasks</p>
                        <h4 class="mb-2">{{ $taskOverDue }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-transparent text-primary rounded-3">
                            <i class="ri-chat-poll-line font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}

    {{-- Total Task --}}
    <div class="col-3">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Completed Task</p>
                        <h4 class="mb-2">{{ $totalTask }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-transparent text-primary rounded-3">
                            <i class="ri-chat-heart-line font-size-24"></i>
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
