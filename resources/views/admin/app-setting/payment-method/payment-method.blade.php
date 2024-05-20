<form action="{{ route('admin.settings.payment-method.store') }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            Stripe Configuration
        </div>
        <div class="card-body">
            {{-- Stripe Names --}}
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="stripe_display_name">Stripe Payment Intent Display name</label>
                        <input type="text" name="stripe_display_name" id="stripe_display_name" class="form-control"
                            value="{{ DiligentCreators('stripe_display_name') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="stripe_hosted_checkout_display_name">Stripe Hosted Checkout Display name</label>
                        <input type="text" name="stripe_hosted_checkout_display_name" id="stripe_hosted_checkout_display_name" class="form-control"
                            value="{{ DiligentCreators('stripe_hosted_checkout_display_name') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            {{-- Options --}}
            <div class="row mb-3">
                <div class="col-md-6 col-sm-6">
                    <div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="stripe" id="showStripe"
                                @if (DiligentCreators('stripe') == 1) checked @endif value="1">
                            <label class="form-check-label" for="showStripe">
                                Show Stripe Payment Gateway on Invoice
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stripe" id="hideStripe"
                                @if (DiligentCreators('stripe') == 0) checked @endif value="0">
                            <label class="form-check-label" for="hideStripe">
                                Hide Stripe Payment Gateway on Invoice
                            </label>
                        </div>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-6">
                    <div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="stripe_hosted_checkout"
                                id="showStripeHostedCheckout" @if (DiligentCreators('stripe_hosted_checkout') == 1) checked @endif
                                value="1">
                            <label class="form-check-label" for="showStripeHostedCheckout">
                                Show Stripe Hosted Checkout on Invoice
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stripe_hosted_checkout"
                                id="hideStripeHostedCheckout" @if (DiligentCreators('stripe_hosted_checkout') == 0) checked @endif
                                value="0">
                            <label class="form-check-label" for="hideStripeHostedCheckout">
                                Hide Stripe Hosted Checkout on Invoice
                            </label>
                        </div>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            {{-- Stripe Keys --}}
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="stripe_key">Stripe Public Key</label>
                        <input type="text" name="stripe_key" id="stripe_key" class="form-control"
                            value="{{ config('stripe.public_key') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="stripe_secret">Stripe Secret Key</label>
                        <input type="text" name="stripe_secret" id="stripe_secret" class="form-control"
                            value="{{ config('stripe.secret_key') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button name="stripePaymentMethod" text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}
</form>

@push('styles')
@endpush

@push('scripts')
@endpush
