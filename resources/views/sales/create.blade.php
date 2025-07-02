<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Sales
                </a>

                <div class="flex items-center">
                    <x-icon.chevron-right class="w-5 h-5 text-gray-400" />
                    <a class="ml-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Create
                    </a>
                </div>
            </li>
        </ol>

        <div class="flex pr-2"></div>
    </nav>

    <div class="overflow-auto">
        <x-validation-message />

        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Create a new sale
                        </h2>
                    </header>

                    <form method="post" action="{{ route('sales.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div id="products">
                            <x-input-label for="date" :value="__('Select product')" />                            

                            <div class="product-row flex gap-2">
                                <select name="products[0][product_id]" class="flex-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->sell_price }}">
                                            {{ $product->name }} [Price: {{ $product->sell_price }}] - [Stock: {{ $product->current_stock }}]
                                        </option>
                                    @endforeach
                                </select>

                                <x-text-input name="products[0][quantity]" type="number" min="1" class="quantity-input mt-1 block w-full" placeholder="Qty"/>
                                <x-text-input name="products[0][unit_price]" type="number" step="0.01" class="unit-price-input mt-1 block w-full" placeholder="Unit Price"/>
                            </div>
                        </div>

                        <x-secondary-button onclick="addProductRow()">
                            + Add Product
                        </x-secondary-button>

                        <div>
                            <x-input-label for="date" value="Date" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', date('Y-m-d'))" autocomplete="date"/>
                            <x-input-error class="mt-2" :messages="$errors->get('date')" />
                        </div>

                        <div>
                            <x-input-label for="discount" value="Discount (Flat)" />
                            <x-text-input id="discount" name="discount" type="number" class="mt-1 block w-full" :value="old('discount', 0)" autocomplete="discount"/>
                            <x-input-error class="mt-2" :messages="$errors->get('discount')" />
                        </div>

                        <div>
                            <x-input-label for="vat" value="VAT (%)" />
                            <x-text-input id="vat" name="vat" type="number" class="mt-1 block w-full" :value="old('vat', 0)" step="0.01" autocomplete="vat"/>
                            <x-input-error class="mt-2" :messages="$errors->get('discount')" />
                        </div>

                        <div>
                            <x-input-label for="paid_amount" value="Paid amount" />
                            <x-text-input id="paid_amount" name="paid_amount" type="number" class="mt-1 block w-full" :value="old('paid_amount')" step="0.01" autocomplete="paid_amount"/>
                            <x-input-error class="mt-2" :messages="$errors->get('discount')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Save</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let productIndex = 1;

            // Calculate Total Amount
            function calculateTotalAmount() {
                let subtotal = 0;
                $('#products .flex.gap-2').each(function() {
                    const $row = $(this);
                    const quantity = parseFloat($row.find('.quantity-input').val()) || 0;
                    const unitPrice = parseFloat($row.find('.unit-price-input').val()) || 0;
                    subtotal += quantity * unitPrice;
                });

                const discount = parseFloat($('#discount').val()) || 0;
                const vatInput = parseFloat($('#vat').val()) || 0;

                const subtotalAfterDiscount = subtotal - discount;
                const vatAmount = (subtotalAfterDiscount * vatInput) / 100;
                const totalAmount = subtotalAfterDiscount + vatAmount;

                $('#paid_amount').val(totalAmount.toFixed(2));
            }

            // Set unit price based on selected product
            function setUnitPrice($row) {
                const $select = $row.find('select');
                const $quantityInput = $row.find('.quantity-input');
                const $unitPriceInput = $row.find('.unit-price-input');

                $quantityInput.on('input', function() {
                    if ($(this).val() > 0) {
                        const selectedOption = $select.find('option:selected');
                        const sellPrice = selectedOption.data('price');
                        $unitPriceInput.val(sellPrice);
                    } else {
                        $unitPriceInput.val('');
                    }
                    calculateTotalAmount();
                });

                $select.on('change', function() {
                    if ($quantityInput.val() > 0) {
                        const selectedOption = $(this).find('option:selected');
                        const sellPrice = selectedOption.data('price');
                        $unitPriceInput.val(sellPrice);
                    }
                    calculateTotalAmount();
                });
            }

            // Apply to existing row
            setUnitPrice($('#products').find('.product-row').first());

            // Update total when discount or vat changes
            $('#discount, #vat').on('input', function() {
                calculateTotalAmount();
            });

            window.addProductRow = function() {
                const $row = $('<div>').addClass('flex gap-2').html(`
                    <select name="products[${productIndex}][product_id]" class="flex-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->sell_price }}">
                                {{ $product->name }} [Price: {{ $product->sell_price }}] - [Stock: {{ $product->current_stock }}]
                            </option>
                        @endforeach
                    </select>
                    <x-text-input name="products[${productIndex}][quantity]" type="number" min="1" class="quantity-input mt-1 block w-full" placeholder="Qty"/>
                    <x-text-input name="products[${productIndex}][unit_price]" type="number" step="0.01" class="unit-price-input mt-1 block w-full" placeholder="Unit Price"/>
                    <button type="button" onclick="removeRow(this)">x</button>
                `);

                $('#products').append($row);
                setUnitPrice($row);
                productIndex++;
            };

            window.removeRow = function(button) {
                $(button).parent().remove();
                calculateTotalAmount();
            };
        });
    </script>
@endpush
</x-app-layout>
