<form action="{{ route('admin.settings.payment-method.store') }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            NGenius Network Payment Configuration
        </div>
        <div class="card-body">
            {{-- NGenius Network Names --}}
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_display_name">NGenius Payment Intent Display Name</label>
                        <input type="text" name="ngenius_display_name" id="ngenius_display_name" class="form-control"
                            value="{{ DiligentCreators('ngenius_display_name') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_hosted_checkout_display_name">NGenius Hosted Checkout Display name</label>
                        <input type="text" name="ngenius_hosted_checkout_display_name"
                            id="ngenius_hosted_checkout_display_name" class="form-control"
                            value="{{ DiligentCreators('ngenius_hosted_checkout_display_name') }}" required>
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
                            <input class="form-check-input" type="radio" name="ngenius" id="showngenius"
                                @if (DiligentCreators('ngenius') == 1) checked @endif value="1">
                            <label class="form-check-label" for="showngenius">
                                Show Ngenius Payment Gateway on Invoice
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ngenius" id="hidengenius"
                                @if (DiligentCreators('ngenius') == 0) checked @endif value="0">
                            <label class="form-check-label" for="hidengenius">
                                Hide Ngenius Payment Gateway on Invoice
                            </label>
                        </div>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-6">
                    <div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="ngenius_hosted_checkout"
                                id="showNgeniusHostedCheckout" @if (DiligentCreators('ngenius_hosted_checkout') == 1) checked @endif
                                value="1">
                            <label class="form-check-label" for="showNgeniusHostedCheckout">
                                Show NGenius Hosted Checkout on Invoice
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ngenius_hosted_checkout"
                                id="hideNgeniusHostedCheckout" @if (DiligentCreators('ngenius_hosted_checkout') == 0) checked @endif
                                value="0">
                            <label class="form-check-label" for="hideNgeniusHostedCheckout">
                                Hide NGenius Hosted Checkout on Invoice
                            </label>
                        </div>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            {{-- NGenius Network API & Outlet Keys --}}
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_api_key">NGenius API Key</label>
                        <input type="text" name="ngenius_api_key" id="ngenius_api_key" class="form-control"
                            value="{{ config('ngenius.api_key') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_outlet">NGenius Outlet Key</label>
                        <input type="text" name="ngenius_outlet" id="ngenius_outlet" class="form-control"
                            value="{{ config('ngenius.outlet') }}" required>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <div class="col-md-7 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_domain">Domain Name Redirect</label>
                        <input type="url" name="ngenius_domain" id="ngenius_domain" class="form-control"
                            value="{{ config('ngenius.domain') }}" required>
                    </div>
                    <small class="text-muted">Do not use trailing slash "/" Only enter https://yourdomain.tld</small>
                </div>
                {{-- /.col --}}
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_environment">Set Your Environment</label>
                        <select name="ngenius_environment" id="ngenius_environment" class="form-control" required>
                            <option value="sandbox" {{ config('ngenius.environment') == 'sandbox' ? 'selected' : '' }}>
                                Sandbox</option>
                            <option value="live" {{ config('ngenius.environment') == 'live' ? 'selected' : '' }}>Live
                            </option>
                        </select>
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <label for="ngenius_slim_mode">Slim Mode</label>
                        <select name="ngenius_slim_mode" id="ngenius_slim_mode" class="form-control" required>
                            <option value="false" {{ strcmp(config('ngenius.slim_mode'), "false") === 0 ? 'selected' : '' }}>False</option>
                            <option value="true" {{ strcmp(config('ngenius.slim_mode'), "true") === 0 ? 'selected' : '' }}>True</option>
                            <option value="0" {{ strcmp(config('ngenius.slim_mode'), "0") === 0 ? 'selected' : '' }}>0</option>
                            <option value="1" {{ strcmp(config('ngenius.slim_mode'), "1") === 0 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ strcmp(config('ngenius.slim_mode'), "2") === 0 ? 'selected' : '' }}>2</option>
                        </select>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="text-muted">Slim Mode Instructions</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Slim Mode</th>
                                    <th>Branding UI displayed</th>
                                    <th>Basket and MCP UI displayed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left;">slim=0</td>
                                    <td style="text-align: left;"><i class="ri-checkbox-line text-success"></i></td>
                                    <td style="text-align: left;"><i class="ri-checkbox-line text-success"></i></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">slim=false</td>
                                    <td style="text-align: left;"><i class="ri-checkbox-line text-success"></i></td>
                                    <td style="text-align: left;"><i class="ri-checkbox-line text-success"></i></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">slim=true</td>
                                    <td style="text-align: left;"><i
                                            class="ri-checkbox-indeterminate-line text-danger"></i></td>
                                    <td style="text-align: left;"><i
                                            class="ri-checkbox-indeterminate-line text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">slim=1</td>
                                    <td style="text-align: left;"><i
                                            class="ri-checkbox-indeterminate-line text-danger"></i></td>
                                    <td style="text-align: left;"><i
                                            class="ri-checkbox-indeterminate-line text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">slim=2</td>
                                    <td style="text-align: left;"><i
                                            class="ri-checkbox-indeterminate-line text-danger"></i></td>
                                    <td style="text-align: left;"><i class="ri-checkbox-line text-success"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-responsive --}}
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <p class="text-danger">Make sure you have selected the acceptable currency by N-Genius Payments. Sandbox
                Currency should be AED</p>
            <x-form.button name="ngeniusNetworkPaymentMethod" text="Save NGenius Network Settings" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}
</form>

@push('styles')
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // input mask should starts with https
            $('#ngenius_domain').inputmask({
                regex: "https://.*"
            });
        });
    </script>
@endpush
