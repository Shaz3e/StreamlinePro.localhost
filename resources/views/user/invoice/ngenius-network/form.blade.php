<div class="modal fade" id="addNGeniusNetworkPayment" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNGeniusNetworkPaymentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate id="paymentForm">
            @csrf
            <input type="hidden" name="invoice" value="{{ $invoice->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNGeniusNetworkPaymentLabel">{{ DiligentCreators('stripe_display_name') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- /.modal-header --}}
                <div class="modal-body">
                    <div id="processingPayment" style="display: none;">
                        <div class="alert alert-info">
                            Processing payment, please wait...
                        </div>
                    </div>
                    {{-- /#processingPayment --}}

                    <div id="paymentFormSuccess" style="display: none;">
                        <div class="alert alert-success">
                            <strong>Success!</strong><br><span id="paymentFormSuccessMessage"></span>
                        </div>
                    </div>
                    {{-- /#paymentFormSuccess --}}

                    <div id="paymentFormError" style="display: none;">
                        <div class="alert alert-danger">
                            <strong>Error!</strong><br><span id="paymentFormErrorMessage"></span>
                        </div>
                    </div>
                    {{-- /#paymentFormError --}}

                    <div id="paymentFormFields">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        min="0.05" step="0.01" max="{{ $invoice->total - $invoice->total_paid }}"
                                        value="{{ $invoice->total - $invoice->total_paid }}" required>
                                </div>
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="card-element">Credit or debit card</label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Pay Now</button>
                        </div>
                        {{-- /.modal-footer --}}
                    </div>
                    {{-- /#addNGeniusNetworkPaymentFields --}}
                </div>
                {{-- /.modal-body --}}
            </div>
            {{-- /.modal-content --}}
        </form>
    </div>
    {{-- /.modal-dialog --}}
</div>
{{-- /.modal --}}
@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var stripe = Stripe('{{ config('stripe.public_key') }}');
            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            var form = document.getElementById('paymentForm');
            var paymentFormFields = document.getElementById('paymentFormFields');
            var processingPayment = document.getElementById('processingPayment');
            var paymentFormSuccess = document.getElementById('paymentFormSuccess');
            var paymentFormSuccessMessage = document.getElementById('paymentFormSuccessMessage');
            var paymentFormError = document.getElementById('paymentFormError');
            var paymentFormErrorMessage = document.getElementById('paymentFormErrorMessage');
            var cardErrors = document.getElementById('card-errors');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                paymentFormFields.style.display = 'none';
                processingPayment.style.display = 'block';
                cardErrors.textContent = '';

                stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                }).then(function(result) {
                    if (result.error) {
                        cardErrors.textContent = result.error.message;
                        paymentFormFields.style.display = 'block';
                        processingPayment.style.display = 'none';
                    } else {
                        var amount = document.getElementById('amount').value;
                        fetch('{{ route('payment-method.stripe.process-payment') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                payment_method: result.paymentMethod.id,
                                invoice_id: '{{ $invoice->id }}',
                                amount: amount,
                            }),
                        }).then(function(response) {
                            return response.json();
                        }).then(function(paymentIntentResponse) {
                            if (paymentIntentResponse.error) {
                                paymentFormErrorMessage.textContent = paymentIntentResponse
                                    .error;
                                paymentFormError.style.display = 'block';
                                processingPayment.style.display = 'none';
                                paymentFormFields.style.display = 'block';
                            } else {
                                stripe.confirmCardPayment(paymentIntentResponse
                                    .client_secret).then(function(result) {
                                    if (result.error) {
                                        paymentFormErrorMessage.textContent = result
                                            .error.message;
                                        paymentFormError.style.display = 'block';
                                    } else if (result.paymentIntent.status ===
                                        'succeeded') {
                                        fetch('{{ route('payment-method.stripe.handle-payment-confirmation') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            },
                                            body: JSON.stringify({
                                                payment_intent_id: result
                                                    .paymentIntent
                                                    .id,
                                            }),
                                        }).then(function(response) {
                                            return response.json();
                                        }).then(function(confirmationResponse) {
                                            if (confirmationResponse
                                                .error) {
                                                paymentFormErrorMessage
                                                    .textContent =
                                                    confirmationResponse
                                                    .error;
                                                paymentFormError.style
                                                    .display = 'block';
                                            } else {
                                                paymentFormSuccessMessage
                                                    .textContent =
                                                    confirmationResponse
                                                    .success;
                                                paymentFormSuccess.style
                                                    .display = 'block';
                                            }
                                            processingPayment.style
                                                .display = 'none';
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
