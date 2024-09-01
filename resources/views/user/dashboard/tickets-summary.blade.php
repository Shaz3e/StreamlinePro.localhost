<div class="row">
    <div class="col-6">
        <div class="card-title">
            <h4>My Support Tickets</h4>
        </div>
    </div>
    {{-- /.col --}}
    <div class="col-6">
        <div class="text-end">
            <a href="{{ route('support-tickets.index') }}">View All Support Tickets</a>
        </div>
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}
<div class="row mb-3">
    <div class="col-6">
        @include('user.dashboard.support-tickets.recent-support-ticket')
    </div>
    <div class="col-6">
        @include('user.dashboard.support-tickets.recent-support-ticket-reply')
    </div>
</div>
{{-- /.row --}}
