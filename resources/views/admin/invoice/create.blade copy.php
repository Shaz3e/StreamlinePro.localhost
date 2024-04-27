@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Invoice',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Invoice List', 'link' => route('admin.invoices.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.invoices.store') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data" id="invoiceForm">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_id">Invoice To</label>
                                    <select name="company_id" class="form-control select2" id="company_id" required>
                                        <option value="">Select</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('company_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_status_id">Invoice Status</label>
                                    <select name="invoice_status_id" class="form-control select2" id="invoice_status_id"
                                        required>
                                        @foreach ($invoiceStatus as $status)
                                            <option value="{{ $status->id }}"
                                                {{ old('invoice_status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('invoice_status_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_date">Invoice Date</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                                        value="{{ old('invoice_date') }}">
                                    </select>
                                </div>
                                @error('invoice_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control" name="due_date" id="due_date"
                                        value="{{ old('due_date') }}">
                                    </select>
                                </div>
                                @error('due_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%">Item</th>
                                                <th style="width: 5%">Quantity</th>
                                                <th style="width: 15%">Unit Price</th>
                                                <th style="width: 10%">Tax</th>
                                                <th style="width: 10%">
                                                    Discount
                                                    <label>%
                                                        <input type="radio" name="discount_type" value="percentage"
                                                            checked>
                                                    </label>
                                                    <label>$
                                                        <input type="radio" name="discount_type" value="amount">
                                                    </label>
                                                </th>
                                                <th style="width: 15%">Total Price</th>
                                                <th class="text-right" style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item-list">
                                            <!-- input boxes will be added here -->
                                        </tbody>
                                    </table>

                                    <button type="button"
                                        class="btn btn-sm btn-primary waves-effect waves-light add-product"
                                        data-bs-toggle="modal" data-bs-target="#selectProduct">
                                        <i class="ri-add-line align-middle me-2"></i> Add Product
                                    </button>
                                    @include('admin.invoice.product-selection')

                                </div>
                                {{-- /.table-responsive --}}
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light" id="createInvoice">
                            <i class="ri-save-line align-middle me-2"></i> Create
                        </button>
                    </div>
                    {{-- /.card-footer --}}
                </form>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        // Input mask
        $('.select2').select2();
        $(".input-mask").inputmask();

        $(document).ready(function() {
            // Add items
            var itemCount = 0;

            $('.add-item').on('click', function() {
                itemCount++;

                var productName = $(this).data('productName');
                var productPrice = $(this).data('productPrice');

                var html = '<tr>';
                html += '<td><input type="text" name="item[]" value="' + productName +
                    '" class="form-control"></td>';
                html +=
                    '<td><input type="number" name="quantity[]" value="1" min="1" class="form-control" onchange="updateTotalPrice(this)"></td>';
                html += '<td><input type="number" name="unit_price[]" value="' + productPrice +
                    '" class="form-control" onchange="updateTotalPrice(this)"></td>';
                html +=
                    '<td><input type="number" name="tax[]" placeholder="Tax" value="0" min="0" max="100" class="form-control" onchange="updateTotalPrice(this)"></td>';
                html +=
                    '<td><input type="number" name="discount[]" placeholder="Discount" value="0" class="form-control" onchange="updateTotalPrice(this)"></td>';
                html += '<td><input type="number" name="total_price[]" placeholder="Total Price" value="' +
                    productPrice + '" class="form-control"></td>';
                html +=
                    '<td><button type="button" class="btn btn-sm btn-danger remove-item">Remove</button></td>';
                html += '</tr>';

                $('#item-list').append(html);
                // $(this).hide();
            });

            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
            });

            // Update Total Price when discount type changes
            $('thead input[name="discount_type"]').on('change', function() {
                updateTotalPrice();
            });
        });

        // Update Total Price
        function updateTotalPrice() {
            console.log("updateTotalPrice function called!");
            var rows = $('#item-list tr');
            rows.each(function() {
                var row = $(this);
                var quantity = parseInt(row.find('input[name="quantity[]"]').val());
                var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val());
                var taxPercentage = parseFloat(row.find('input[name="tax[]"]').val());
                var discountType = $('thead input[name="discount_type"]:checked').val();
                var discountValue = parseFloat(row.find('input[name="discount[]"]').val());

                var subTotal = (quantity * unitPrice);
                var taxAmount = (subTotal * taxPercentage / 100);
                var totalPrice = subTotal + taxAmount;

                if (discountType === 'percentage') {
                    totalPrice -= (totalPrice * discountValue / 100);
                    console.log(totalPrice);
                } else if (discountType === 'amount') {
                    console.log(totalPrice);
                    totalPrice -= discountValue;
                }

                row.find('input[name="total_price[]"]').val(totalPrice.toFixed(2));
            });
        }

        // Update products
        function updateProducts() {
            var products = [];
            $('#item-list tr').each(function() {
                var product = {
                    id: $(this).find('input[name="id[]"]').val(),
                    name: $(this).find('input[name="name[]"]').val(),
                    quantity: $(this).find('input[name="quantity[]"]').val(),
                    price: $(this).find('input[name="price[]"]').val(),
                    tax: $(this).find('input[name="tax[]"]').val(),
                    discount: $(this).find('input[name="discount[]"]').val(),
                    total: $(this).find('input[name="total_price[]"]').val(),
                };
                products.push(product);
            });
            $('form#invoiceForm').append('<input type="hidden" name="products" value="' + JSON.stringify(products) + '">');

            // Submit the form
            $('form#invoiceForm').submit();
        }

        // Add an event listener to the form's submit event
        $('form#invoiceForm').on('submit', function() {
            updateProducts();
        });
    </script>
@endpush
