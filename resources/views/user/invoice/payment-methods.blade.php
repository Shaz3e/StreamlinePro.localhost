{{-- Payment Methods --}}
@if ($invoice->total !== $invoice->total_paid)
    <ul class="list-inline mb-0">
        {{-- Stripe Payments --}}
        @if (DiligentCreators('stripe') == 1)
            <li class="list-inline-item">
                <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#addStripePayment">
                    {{ DiligentCreators('stripe_display_name') }}
                </button>
                @include('user.invoice.stripe.form')
            </li>
        @endif
        @if (DiligentCreators('stripe_hosted_checkout') == 1)
            <li class="list-inline-item">
                <form action="{{ route('payment-method.stripe.hosted.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <button type="submit" class="btn btn-dark waves-effect waves-light">
                        {{ DiligentCreators('stripe_hosted_checkout_display_name') }}
                    </button>
                </form>
            </li>
        @endif

        {{-- N-Genius Network Payment --}}
        @if (DiligentCreators('ngenius') == 1)
            <li class="list-inline-item">
                <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#addNGeniusNetworkPayment">
                    {{ DiligentCreators('ngenius_display_name') }}
                </button>
                @include('user.invoice.ngenius-network.form')
            </li>
        @endif
        @if (DiligentCreators('ngenius_hosted_checkout') == 1)
            <li class="list-inline-item">
                <form action="{{ route('payment-method.ngenius-network.hosted.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <button type="submit" class="btn btn-dark waves-effect waves-light">
                        {{ DiligentCreators('ngenius_hosted_checkout_display_name') }}
                    </button>
                </form>
            </li>
        @endif
    </ul>
@endif
