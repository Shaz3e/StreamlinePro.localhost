<div class="row mb-0">
    {{-- Open Tickets --}}
    <div class="col-4">
        <div class="card" style="height: calc(100% - 30px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Open Tickets</p>
                        <h4 class="mb-2">{{ $openSupportTickets }}</h4>
                        Total open tickets
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-questionnaire-line font-size-24"></i>  
                        </span>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}
    {{-- Current Month Tickets --}}
    <div class="col-4">
        <div class="card" style="height: calc(100% - 30px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">This Month Tickets</p>
                        <h4 class="mb-2">{{ $currentMonthTickets }}</h4>
                        <p class="text-muted mb-0">
                            <span class="{{ $this->getNewTicketPercentageChange() < 0 ? 'text-success' : 'text-danger' }} fw-bold font-size-12 me-2">
                                <i class="{{ $this->getNewTicketPercentageChange() < 0 ? 'ri-arrow-right-down-line' : 'ri-arrow-right-up-line' }} me-1 align-middle"></i>
                                {{ number_format($this->getNewTicketPercentageChange(), 1) }}% <!-- removed abs() here -->
                            </span>
                            from previous month
                        </p>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-chat-history-line font-size-24"></i>  
                        </span>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}
    {{-- Last Month Tickets --}}
    <div class="col-4">
        <div class="card" style="height: calc(100% - 30px)">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Last Month</p>
                        <h4 class="mb-2">{{ $lastMonthTickets }}</h4>
                        <p class="text-muted mb-0">tickets created</p>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-feedback-line font-size-24"></i>  
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