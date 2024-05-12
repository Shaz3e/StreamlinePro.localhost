@livewire('admin.dashboard.user-summary')

<div class="row mb-3">
    <div class="col-6">
        @livewire('admin.dashboard.recent-support-ticket')
    </div>
    <div class="col-6">
        @livewire('admin.dashboard.recent-support-ticket-reply')
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        @livewire('admin.dashboard.recent-invoice')
    </div>
    <div class="col-6">
        @livewire('admin.dashboard.recent-paid-invoice')
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        @livewire('admin.dashboard.recent-payments')
    </div>
</div>