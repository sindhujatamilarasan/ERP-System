@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">Create Sales Order</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('sales_orders.store') }}" method="POST" id="salesOrderForm">
                    @csrf
                    <div id="product-items">
                        @php $oldProducts = old('products', [['product_id' => '', 'quantity' => 1]]); @endphp
                        @foreach ($oldProducts as $i => $item)
                            <div class="row mb-2 product-row">
                                <div class="col-md-4">
                                    <select name="products[{{ $i }}][product_id]"
                                        class="form-control product-select @error("products.$i.product_id") is-invalid @enderror">
                                        <option value="">-- Select Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                {{ $item['product_id'] == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (₹{{ $product->price }}, Stock:
                                                {{ $product->quantity }})
                                            </option>
                                        @endforeach
                                                                        @error("products.$i.product_id")
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="products[{{ $i }}][quantity]"
                                        value="{{ $item['quantity'] ?? 1 }}"
                                        class="form-control quantity-input @error("products.$i.quantity") is-invalid @enderror"
                                        placeholder="Quantity" min="1">
                                    @error("products.$i.quantity")
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <span class="subtotal">₹0</span>
                                </div>
                                <div class="col-md-2">
                                    @if ($i > 0)
                                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-product" class="btn btn-success mb-3">Add Another Product</button>
                    <div class="card mt-4">
                        <div class="card-body text-end">
                            <h5>Total: ₹<span id="total">0</span></h5>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Create Order</button>
                        <a href="{{ route('sales_orders.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let index = {{ count($oldProducts) }};
        function calculateTotal() {
            let total = 0;
            $('.product-row').each(function() {
                let price = parseFloat($(this).find('.product-select option:selected').data('price')) || 0;
                let qty = parseInt($(this).find('.quantity-input').val()) || 0;
                let subtotal = price * qty;
                $(this).find('.subtotal').text('₹' + subtotal.toFixed(2));
                total += subtotal;
            });

            $('#total').text(total.toFixed(2));
        }

        $('#add-product').click(function() {
            let newRow = `
        <div class="row mb-2 product-row">
            <div class="col-md-4">
                <select name="products[${index}][product_id]" class="form-control product-select">
                    <option value="">-- Select Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (₹{{ $product->price }}, Stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="products[${index}][quantity]" class="form-control quantity-input" placeholder="Quantity" min="1" value="1">
            </div>
            <div class="col-md-2">
                <span class="subtotal">₹0</span>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-product">Remove</button>
            </div>
        </div>`;
            $('#product-items').append(newRow);
            index++;
            calculateTotal();
        });

        $(document).on('change', '.product-select, .quantity-input', function() {
            calculateTotal();
        });

        $(document).on('click', '.remove-product', function() {
            $(this).closest('.product-row').remove();
            calculateTotal();
        });

        $('#salesOrderForm').submit(function(e) {
            let isValid = true;

            $('.product-row').each(function() {
                let productSelect = $(this).find('.product-select');
                if (!productSelect.val()) {
                    productSelect.addClass('is-invalid');
                    isValid = false;
                } else {
                    productSelect.removeClass('is-invalid');
                }

                let qtyInput = $(this).find('.quantity-input');
                if (!qtyInput.val() || qtyInput.val() < 1) {
                    qtyInput.addClass('is-invalid');
                    isValid = false;
                } else {
                    qtyInput.removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please enter required fields');
            }
        });

        $(document).ready(function() {
            calculateTotal();
        });
    </script>
@endsection
