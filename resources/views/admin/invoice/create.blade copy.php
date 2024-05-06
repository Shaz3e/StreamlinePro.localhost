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
        <form action="{{ route('admin.invoices.store') }}" method="POST" class="needs-validation" novalidate id="invoice-form">
            @csrf
            {{-- Invoice Details --}}
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card" style="height:  calc(100% - 30px);">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                        <label class="form-check-label" for="user">
                                            <input class="form-check-input" id="user" type="radio" name="invoice_to"
                                                value="user" checked>
                                            Invoice to Customer
                                        </label>
                                        <label class="form-check-label" for="company">
                                            <input class="form-check-input" id="company" type="radio" name="invoice_to"
                                                value="company">
                                            Invoice to Company
                                        </label>
                                        @error('invoice_to')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3" id="invoice_to_user">
                                        <div class="form-group">
                                            <label for="user_id">Select Customer</label>
                                            <select name="user_id" class="form-control select2">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('user_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3" id="invoice_to_company"
                                        style="display: none;">
                                        <div class="form-group">
                                            <label for="company_id">Select Company</label>
                                            <select name="company_id" class="form-control select2">
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('company_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="is_published">Publish Invoice</label>
                                            <select name="is_published" class="form-control" id="is_published">
                                                <option value="0">Not Published</option>
                                                <option value="1">Published</option>
                                            </select>
                                        </div>
                                        <small class="text-muted">Invoice will be avilable at client dashboard</small>
                                        @error('is_published')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="published_on">Publish Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="published_on" class="form-control" id="published_on"
                                                value="{{ old('published_on', now()->format('Y-m-d')) }}"
                                                min="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <small class="text-muted">Invoice will be sent via email to this date</small>
                                        @error('published_on')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-md-12">
                                        <p class="text-muted">Invoice status will be automatically updated based on the
                                            payment transactions</p>
                                    </div>
                                </div>
                                {{-- /.row --}}
                            </div>
                            {{-- /.card-body --}}
                        </div>
                        {{-- /.card --}}
                    </div>
                    {{-- /.col --}}
                    <div class="col-md-4">
                        <div class="card" style="height:  calc(100% - 30px);">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="invoice_label_id">Label As</label>
                                            <select name="invoice_label_id" class="form-control select2" required>
                                                @foreach ($invoiceLabels as $label)
                                                    <option value="{{ $label->id }}"
                                                        {{ old('invoice_label_id') == $label->id ? 'selected' : '' }}>
                                                        {{ $label->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div><small class="text-muted">for internal use only</small></div>
                                        @error('invoice_label_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date</label>
                                            <input type="date" name="invoice_date" class="form-control" id="invoice_date"
                                                value="{{ old('invoice_date') }}">
                                        </div>
                                        <div><small class="text-muted">Invoice Creation Date for Client</small></div>
                                        @error('invoice_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="due_date">Due Date</label>
                                            <input type="date" name="due_date" class="form-control" id="due_date"
                                                value="{{ old('due_date') }}">
                                        </div>
                                        <div><small class="text-muted">Email reminder will be sent based on this
                                                date</small></div>
                                        @error('due_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- /.col --}}
                                </div>
                                {{-- /.row --}}
                            </div>
                            {{-- /.card-body --}}
                        </div>
                        {{-- /.card --}}
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}
            </div>
            {{-- /.col --}}

            {{-- Invoice Items --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Invoice Items</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 45%">Item</th>
                                        <th class="text-center" style="width: 10">Quantity</th>
                                        <th class="text-center" style="width: 15%">Unit Price</th>
                                        <th class="text-center" style="width: 10%">Discount</th>
                                        <th class="text-center" style="width: 10%">Tax</th>
                                        <th class="text-center" style="width: 15%">Total Price</th>
                                        <th class="text-end" style="width: 5%"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th class="text-center">
                                            <label class="form-check-label" for="percentage">
                                                <input class="form-check-input" id="percentage" type="radio"
                                                    name="discount_type" value="percentage" checked>
                                                %
                                            </label>
                                            <label class="form-check-label" for="amount">
                                                <input class="form-check-input" id="amount" type="radio"
                                                    name="discount_type" value="amount">
                                                $
                                            </label>
                                        </th>
                                        <th colspan="3"></th>
                                    </tr>
                                </thead>
                                <tbody id="item-list">
                                </tbody>
                            </table>
                        </div>
                        {{-- /.table-responsive --}}

                        {{-- Add Product or Services --}}
                        <div class="row">

                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light add-product"
                                    data-bs-toggle="modal" data-bs-target="#selectProduct">
                                    <i class="ri-add-line align-middle me-2"></i> Add Product(s) or Service(s)
                                </button>
                                @include('admin.invoice.product-selection')
                            </div>
                            {{-- /.col-md-12 --}}
                        </div>
                        {{-- /.row --}}

                        {{-- Calculation --}}
                        <div class="row mt-5">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td id="subTotal">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Discountl</td>
                                        <td id="discountTotal">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td id="taxTotal">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td id="total">0.00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}

            {{-- Invoice Buttons --}}
            <div class="col-md-12 mb-5">
                <x-form.button />
                <x-form.button-save-view />
                <x-form.button-save-create-new />
            </div>
            {{-- /.col --}}
        </form>
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2();

            // Change invoice to option based on radio check
            $('[name="invoice_to"]').change(function() {
                if ($(this).val() == 'user') {
                    $('#invoice_to_user').show();
                    $('#invoice_to_company').hide();
                } else {
                    $('#invoice_to_user').hide();
                    $('#invoice_to_company').show();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Product modal
            const modal = document.getElementById('selectProduct');
            // Prepair item list in the table
            const itemList = document.getElementById('item-list');

            // Add event listener to the "Add Product" button in the modal
            modal.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-item')) {
                    const productName = event.target.dataset.productName;
                    const productPrice = event.target.dataset.productPrice;

                    // Add a new row in the table
                    const row = document.createElement('tr');

                    // prepair tr#item-list
                    row.innerHTML = `
                        <td>
                            <textarea name="item_description[]" class="form-control" required>${productName}</textarea>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" value="1" min="1" required oninput="calculateTotal(this)">
                        </td>
                        <td>
                            <input type="number" name="unit_price[]" class="form-control" value="${productPrice}" min="0" required oninput="calculateTotal(this)">
                        </td>
                        <td>
                            <input type="number" name="discount_value[]" class="form-control" value="0" min="0" required oninput="calculateTotal(this)">
                        </td>
                        <td>
                            <select name="tax_value[]" class="form-control" oninput="calculateTotal(this)" required>
                                <option value="0">none</option>
                                <option value="10.00">10%</option>
                                <option value="17.00">17%</option>
                                <option value="21.00">21%</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="total_price[]" class="form-control" value="${productPrice}" readonly>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                        </td>
                    `;

                    // Add the new row to the table
                    itemList.appendChild(row);

                    // Close the modal
                    modal.querySelector('.btn-close').click();
                }
            });

            // Add event listener to remove a row when the "Remove" button is clicked
            itemList.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-row')) {
                    const row = event.target.closest('tr');
                    itemList.removeChild(row);
                }
            });

            // Event listener for discount type change
            const discountTypeInputs = document.querySelectorAll('input[name="discount_type"]');
            discountTypeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Recalculate total price for each row when discount type changes
                    const rows = itemList.querySelectorAll('tr');
                    rows.forEach(row => {
                        calculateTotal(row.querySelector('input'));
                    });
                });
            });
        });

        // Calculate Total
        function calculateTotal(element) {
            const row = element.closest('tr');

            // Access the input fields within the row
            const quantityInput = row.querySelector('input[name="quantity[]"]');
            const unitPriceInput = row.querySelector('input[name="unit_price[]"]');
            const discountValueInput = row.querySelector('input[name="discount_value[]"]');
            const taxValueSelect = row.querySelector('select[name="tax_value[]"]');
            const totalPriceInput = row.querySelector('input[name="total_price[]"]');

            // Access the discount type from the table head
            const discountTypeInput = document.querySelector('input[name="discount_type"]:checked');
            if (!discountTypeInput) {
                console.error('No discount type selected in the table head.');
                return;
            }
            const discountType = discountTypeInput.value;
            // console.log('Discount Type:', discountType);

            // Function to convert a value to a two-decimal place number
            function toDecimal(value) {
                return parseFloat(value).toFixed(2);
            }

            // Parse the input values as floats
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const discountValue = parseFloat(discountValueInput.value) || 0;
            const taxPercentage = parseFloat(taxValueSelect.value) || 0;

            // Calculate the subtotal (unit price * quantity)
            const subtotal = unitPrice * quantity;

            // Calculate discount amount based on the selected discount type
            let discountAmount = 0;
            if (discountType === 'percentage') {
                discountAmount = subtotal * (discountValue / 100);
            } else if (discountType === 'amount') {
                discountAmount = discountValue;
            }

            // Calculate tax amount as a percentage of the subtotal
            const taxAmount = subtotal * (taxPercentage / 100);

            // Calculate total price: subtotal + tax amount - discount amount
            const totalPrice = subtotal + taxAmount - discountAmount;

            // Set the calculated total price in the total price input field
            // totalPriceInput.value = totalPrice.toFixed(2);
            totalPriceInput.value = toDecimal(totalPrice);
            // console.log('Total Price Input:', totalPriceInput.value);
        }

        // Calculate Sub Total, Discount, Tax, and Total
        function showTotalSummary() {
            const tableRows = document.querySelectorAll('#item-list tr');
            let subTotal = 0;
            let discountTotal = 0;
            let taxTotal = 0;
            let total = 0;

            tableRows.forEach(row => {
                const quantityInput = row.querySelector('input[name="quantity[]"]');
                const unitPriceInput = row.querySelector('input[name="unit_price[]"]');
                const discountValueInput = row.querySelector('input[name="discount_value[]"]');
                const taxValueSelect = row.querySelector('select[name="tax_value[]"]');

                const quantity = parseFloat(quantityInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const discountValue = parseFloat(discountValueInput.value) || 0;
                const taxPercentage = parseFloat(taxValueSelect.value) || 0;

                const subtotal = unitPrice * quantity;
                const discountAmount = subtotal * (discountValue / 100);
                const taxAmount = subtotal * (taxPercentage / 100);
                const totalPrice = subtotal - discountAmount + taxAmount;

                subTotal += subtotal;
                discountTotal += discountAmount;
                taxTotal += taxAmount;
                total += totalPrice;
            });

            document.getElementById("subTotal").innerText = subTotal.toFixed(2);
            document.getElementById("discountTotal").innerText = discountTotal.toFixed(2);
            document.getElementById("taxTotal").innerText = taxTotal.toFixed(2);
            document.getElementById("total").innerText = total.toFixed(2);
        }
    </script>
@endpush
