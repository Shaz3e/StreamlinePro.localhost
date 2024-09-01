<div class="row mb-3">
    <div class="col-6">
        <h4>My Invoices</h4>
    </div>
    {{-- /.col --}}
    <div class="col-6">
        <div class="text-end">
            <a href="{{ route('invoice.index') }}">View All Invoices</a>
        </div>
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}
<div class="row">
    <div class="col-6">
        @include('user.dashboard.invoices.recent-invoices')
    </div>
    <div class="col-6">
        @include('user.dashboard.invoices.recent-paid-invoices')
    </div>
</div>
{{-- /.row --}}

<div class="row mb-3">
    <div class="col-12">
        @include('user.dashboard.invoices.recent-payments')
    </div>
</div>
{{-- /.row --}}
