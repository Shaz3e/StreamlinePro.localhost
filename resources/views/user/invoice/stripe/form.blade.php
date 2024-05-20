<div class="modal fade" id="addStripePayment" tabindex="-1" role="dialog" aria-labelledby="addStripePaymentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate id="paymentForm">
            @csrf
            <input type="hidden" name="invoice" value="{{ $invoice->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStripePaymentLabel">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- /.modal-header --}}
                <div class="modal-body">
                    <div id="paymentFormSuccess" style="display: none;">
                        <div class="alert alert-success">
                            <strong>Success!</strong><br><span id="paymentFormSuccessMessage"></span>
                        </div>
                    </div>
                    {{-- /.paymentFormSuccess --}}

                    <div id="paymentFormError" style="display: none;">
                        <div class="alert alert-danger">
                            <strong>Error!</strong><br><span id="paymentFormErrorMessage"></span>
                        </div>
                    </div>
                    {{-- /.paymentFormError --}}

                    <div id="paymentFormFields">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        max="{{ $invoice->total - $invoice->total_paid }}" value="{{ $invoice->total - $invoice->total_paid }}" required>
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
                    {{-- /#addStripePaymentFields --}}
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
        $(document).ready(function() {
            var stripe = Stripe('{{ config('stripe.public_key') }}');
            console.log(stripe);
            var elements = stripe.elements();

            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            var card = elements.create('card', {
                style: style
            });
            card.mount('#card-element');

            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('paymentForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                var form = document.getElementById('paymentForm');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                $.ajax({
                    url: '{{ route('payment-method.stripe.payment-process') }}',
                    method: 'POST',
                    data: $('#paymentForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // if (response.success) {
                        //     alert(response.success);
                        // } else {
                        //     alert(response.error);
                        // }
                        if (response.success) {
                            $('#paymentFormFields').hide();
                            $('#paymentFormError').hide();
                            $('#paymentFormSuccessMessage').text(response.success);
                            $('#paymentFormSuccess').show();
                            // refresh page after 5 seconds
                            setTimeout(function() {
                                location.reload();
                            }, 5000)
                        } else {
                            $('#paymentFormSuccess').hide();
                            $('#paymentFormErrorMessage').text(response.error);
                            $('#paymentFormError').show();
                        }
                    },
                    error: function(response) {
                        // alert('An error occurred. Please try again.');
                        $('#paymentFormSuccess').hide();
                        $('#paymentFormErrorMessage').text('An error occurred. Please try again.');
                        $('#paymentFormError').show();
                    }
                });
            }
        });
    </script>
@endpush
