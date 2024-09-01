{{-- Promotions --}}
@if (count($promotions) > 0)
    @include('user.dashboard.promotions')
@endif

{{-- My Products --}}
@include('user.dashboard.products')

{{-- My Invoices Summary --}}
@include('user.dashboard.invoices-summary')

{{-- My Tickets Summary --}}
@include('user.dashboard.tickets-summary')
