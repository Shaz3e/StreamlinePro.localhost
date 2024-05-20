<form action="{{ route('admin.settings.payment-method.store') }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            Stripe Configuration
        </div>
        <div class="card-body">
            {{-- Stripe --}}
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
            <div class="row mt-2">
                <div class="col-md-12 col-sm-12">
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
            </div>
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
