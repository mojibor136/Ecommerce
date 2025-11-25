@extends('frontend.layouts.master')
@section('title', 'Checkout')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">
        <h1
            class="text-2xl font-semibold mb-6 text-gray-800 relative inline-block
        after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-[{{ $theme->theme_bg }}] after:bottom-[-6px] after:left-0">
            🛍️ Checkout
        </h1>

        @php
            $cart = session('cart', []);
            $buyNow = session('buy_now', null);
            $shipping = number_format(session('shippingCharge', 150), 0);
        @endphp

        @if ($buyNow)
            @php $subtotal = $buyNow['price'] * $buyNow['quantity']; @endphp
            <form action="{{ route('payment') }}" method="POST" class="flex flex-col lg:flex-row gap-4">
                @csrf
                <input type="hidden" name="product[id]" value="{{ $buyNow['id'] }}">
                <input type="hidden" name="product[name]" value="{{ $buyNow['name'] }}">
                <input type="hidden" name="product[price]" value="{{ $buyNow['price'] }}">
                <input type="hidden" name="product[quantity]" value="{{ $buyNow['quantity'] }}">
                <input type="hidden" name="product[variant_id]" value="{{ $buyNow['variant_id'] }}">
                <input type="hidden" name="product[image]" value="{{ $buyNow['image'] }}">
                @if (!empty($buyNow['variants']) && is_array($buyNow['variants']))
                    <input type="hidden" name="product[attributes]" value='@json($buyNow['variants'])'>
                @else
                    <input type="hidden" name="product[attributes]" value="{}">
                @endif
                <div class="lg:w-2/3 bg-white shadow rounded-lg md:p-6 p-4">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-user-line text-[{{ $theme->theme_bg }}]"></i>Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-md mb-1 text-gray-600">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="Enter your name">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="+8801XXXXXXXXX">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="Enter city">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Delivery Area</label>
                            <select name="charge" id="deliveryArea" required
                                class="w-full border border-gray-300 rounded px-3 py-[10px] text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none">
                                <option value="{{ $inDhakaCharge }}">Inside Dhaka</option>
                                <option value="{{ $outDhakaCharge }}">Outside Dhaka</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Full Address</label>
                            <textarea name="address" rows="3" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="House, Road, Area">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold flex items-center gap-2">
                        <i class="ri-shopping-bag-3-line text-[{{ $theme->theme_bg }}]"></i>Order Details
                    </h2>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between border-b border-gray-200 py-4 cart-item"
                            data-id="{{ $buyNow['id'] }}">
                            <div class="flex items-center md:gap-4 gap-3">
                                <img loading="lazy" src="{{ $buyNow['image'] }}" alt="{{ $buyNow['name'] }}"
                                    class="w-[68px] md:h-[68px] h-[86px] object-cover rounded">
                                <div>
                                    <h3 class="font-medium text-gray-800 line-clamp-1">
                                        {{ \Illuminate\Support\Str::limit($buyNow['name'], 30) }}</h3>
                                    <div class="flex md:flex-row flex-col md:items-center items-start md:gap-2">
                                        <p class="text-gray-500 text-sm">Variation:</p>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if (!empty($buyNow['variants']) && is_array($buyNow['variants']))
                                                @foreach ($buyNow['variants'] as $key => $value)
                                                    <div class="bg-white border rounded text-xs text-gray-700 px-3 py-1">
                                                        <span class="hidden md:inline">{{ ucfirst($key) }}: </span>
                                                        {{ $value }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="bg-white border rounded text-xs text-gray-700 px-3 py-1">Default
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-1">Qty: {{ $buyNow['quantity'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-800 font-semibold">
                                    ৳{{ number_format($buyNow['price'] * $buyNow['quantity'], 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3 bg-white shadow rounded-lg p-6 h-fit">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2"><i
                            class="ri-bill-line text-[{{ $theme->theme_bg }}]"></i>Order Summary</h2>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Your Location</span>
                        <span class="text-gray-800 font-medium customer-location">Detecting...</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-800 subtotal">৳{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping Charge</span>
                        <span class="font-medium text-gray-800 shipping">৳{{ number_format($shipping, 0) }}</span>
                    </div>
                    <div class="border-t border-gray-200 mt-2 mb-4"></div>
                    <div class="flex justify-between text-lg font-semibold mb-6">
                        <span>Total</span>
                        <span class="total">৳{{ number_format($subtotal + $shipping, 0) }}</span>
                    </div>

                    <h3 class="text-md font-semibold mb-3 flex items-center gap-2"><i
                            class="ri-bank-card-line text-[{{ $theme->theme_bg }}]"></i>Payment Method</h3>
                    <div class="space-y-3 mb-6">
                        <h2 class="font-semibold text-gray-800 mb-2">Select Payment Method</h2>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="payment-card border border-gray-300 rounded-lg px-2 cursor-pointer text-center transition-all duration-300 hover:scale-95"
                                data-method="cod" onclick="selectPayment('cod')">

                                <img src="https://cdn-icons-png.freepik.com/512/5278/5278605.png" alt="Cash on Delivery"
                                    class="w-24 h-12 mx-auto">
                            </div>

                            <div class="payment-card border border-gray-300 rounded-lg px-2 text-center transition-all duration-300 
                                {{ $bkashStatus == 1 ? 'cursor-pointer hover:scale-95' : 'opacity-40 cursor-not-allowed' }}"
                                data-method="bkash"
                                @if ($bkashStatus == 1) onclick="selectPayment('bkash')" @endif>

                                <img src="https://www.logo.wine/a/logo/BKash/BKash-bKash-Logo.wine.svg" alt="bKash"
                                    class="w-24 h-12 mx-auto">
                            </div>

                            <div class="payment-card border border-gray-300 rounded-lg px-2 text-center transition-all duration-300 
                                {{ $nagadStatus == 1 ? 'cursor-pointer hover:scale-95' : 'opacity-40 cursor-not-allowed' }}"
                                data-method="nagad"
                                @if ($nagadStatus == 1) onclick="selectPayment('nagad')" @endif>

                                <img src="https://www.logo.wine/a/logo/Nagad/Nagad-Logo.wine.svg" alt="Nagad"
                                    class="w-24 h-12 mx-auto">
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="cod">
                    </div>

                    <style>
                        .payment-card {
                            transition: all 0.3s ease;
                        }

                        .payment-card.active {
                            border: 2px solid;
                            border-color: #f97316;
                            background-color: #fff7ed;
                        }
                    </style>

                    <script>
                        const paymentCards = document.querySelectorAll('.payment-card');
                        const hiddenInput = document.getElementById('selectedPaymentMethod');

                        paymentCards.forEach(card => {
                            card.addEventListener('click', () => {
                                // সব কার্ড থেকে active ক্লাস রিমুভ
                                paymentCards.forEach(c => c.classList.remove('active'));

                                // ক্লিক করা কার্ডে active ক্লাস অ্যাড
                                card.classList.add('active');

                                // Hidden input এর value আপডেট
                                hiddenInput.value = card.getAttribute('data-method');
                            });
                        });

                        // ডিফল্ট selected card
                        document.addEventListener('DOMContentLoaded', () => {
                            const defaultCard = document.querySelector('[data-method="cod"]');
                            if (defaultCard) defaultCard.classList.add('active');
                        });
                    </script>

                    <button type="submit"
                        class="w-full bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] font-semibold py-3 rounded-lg transition">
                        <i class="ri-lock-line mr-1"></i> Confirm & Place Order
                    </button>
                </div>
            </form>
        @elseif(count($cart) > 0)
            @php $subtotal = 0; @endphp
            <form action="{{ route('payment') }}" method="POST" class="flex flex-col lg:flex-row gap-4">
                @csrf
                @foreach ($cart as $id => $item)
                    <input type="hidden" name="products[{{ $id }}][id]" value="{{ $id }}">
                    <input type="hidden" name="products[{{ $id }}][name]" value="{{ $item['name'] }}">
                    <input type="hidden" name="products[{{ $id }}][price]" value="{{ $item['price'] }}">
                    <input type="hidden" name="products[{{ $id }}][quantity]"
                        value="{{ $item['quantity'] }}">
                    <input type="hidden" name="products[{{ $id }}][variant_id]"
                        value="{{ $item['variant_id'] }}">
                    <input type="hidden" name="products[{{ $id }}][image]" value="{{ $item['image'] }}">
                    @if (!empty($item['variants']) && is_array($item['variants']))
                        <input type="hidden" name="products[{{ $id }}][attributes]"
                            value='@json($item['variants'])'>
                    @else
                        <input type="hidden" name="products[{{ $id }}][attributes]" value="{}">
                    @endif
                @endforeach
                <div class="lg:w-2/3 bg-white shadow rounded-lg md:p-6 p-4">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-user-line text-[{{ $theme->theme_bg }}]"></i>Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-md mb-1 text-gray-600">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="Enter your name">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="+8801XXXXXXXXX">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="Enter city">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Delivery Area</label>
                            <select name="charge" id="deliveryArea" required
                                class="w-full border border-gray-300 rounded px-3 py-[10px] text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none">
                                <option value="{{ $inDhakaCharge }}">Inside Dhaka</option>
                                <option value="{{ $outDhakaCharge }}">Outside Dhaka</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Full Address</label>
                            <textarea name="address" rows="3" required
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] outline-none"
                                placeholder="House, Road, Area">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold flex items-center gap-2">
                        <i class="ri-shopping-bag-3-line text-[{{ $theme->theme_bg }}]"></i>Order Details
                    </h2>
                    <div class="flex flex-col gap-2">
                        @foreach ($cart as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <div class="flex items-center justify-between border-b border-gray-200 py-4 cart-item"
                                data-id="{{ $id }}">
                                <div class="flex items-center md:gap-4 gap-3">
                                    <img loading="lazy" src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                        class="w-[68px] md:h-[68px] h-[86px] object-cover rounded">
                                    <div>
                                        <h3 class="font-medium text-gray-800 line-clamp-1">
                                            {{ \Illuminate\Support\Str::limit($item['name'], 30) }}</h3>
                                        <div class="flex md:flex-row flex-col md:items-center items-start md:gap-2">
                                            <p class="text-gray-500 text-sm">Variation:</p>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                @if (!empty($item['variants']) && is_array($item['variants']))
                                                    @foreach ($item['variants'] as $key => $value)
                                                        <div
                                                            class="bg-white border rounded text-xs text-gray-700 px-3 py-1">
                                                            <span class="hidden md:inline">{{ ucfirst($key) }}: </span>
                                                            {{ $value }}
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="bg-white border rounded text-xs text-gray-700 px-3 py-1">
                                                        Default</div>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-gray-500 text-sm mt-1">Qty:
                                            <input type="number" value="{{ $item['quantity'] }}" min="1"
                                                class="w-14 border border-gray-300 rounded px-2 py-0.5 text-sm focus:border-[{{ $theme->theme_bg }}] focus:ring-1 focus:ring-[{{ $theme->theme_bg }}] transition duration-200 outline-none quantity-input"
                                                data-id="{{ $id }}">
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-800 font-semibold">
                                        ৳{{ number_format($item['price'] * $item['quantity'], 0) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:w-1/3 bg-white shadow rounded-lg md:p-6 p-4 h-fit">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2"><i
                            class="ri-bill-line text-[{{ $theme->theme_bg }}]"></i>Order Summary</h2>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Your Location</span>
                        <span class="text-gray-800 font-medium customer-location">Detecting...</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-800 subtotal">৳{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping Charge</span>
                        <span class="font-medium text-gray-800 shipping">৳{{ number_format($shipping, 0) }}</span>
                    </div>
                    <div class="border-t border-gray-200 mt-2 mb-4"></div>
                    <div class="flex justify-between text-lg font-semibold mb-6">
                        <span>Total</span>
                        <span class="total">৳{{ number_format($subtotal + $shipping, 0) }}</span>
                    </div>

                    <h3 class="text-md font-semibold mb-3 flex items-center gap-2"><i
                            class="ri-bank-card-line text-[{{ $theme->theme_bg }}]"></i>Payment Method</h3>

                    <div class="space-y-3 mb-6">
                        <h2 class="font-semibold text-gray-800 mb-2">Select Payment Method</h2>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="payment-card border border-gray-300 rounded-lg px-2 cursor-pointer text-center transition-all duration-300 hover:scale-95"
                                data-method="cod" onclick="selectPayment('cod')">

                                <img src="https://cdn-icons-png.freepik.com/512/5278/5278605.png" alt="Cash on Delivery"
                                    class="w-24 h-12 mx-auto">
                            </div>

                            <div class="payment-card border border-gray-300 rounded-lg px-2 text-center transition-all duration-300 
                                {{ $bkashStatus == 1 ? 'cursor-pointer hover:scale-95' : 'opacity-40 cursor-not-allowed' }}"
                                data-method="bkash"
                                @if ($bkashStatus == 1) onclick="selectPayment('bkash')" @endif>

                                <img src="https://www.logo.wine/a/logo/BKash/BKash-bKash-Logo.wine.svg" alt="bKash"
                                    class="w-24 h-12 mx-auto">
                            </div>

                            <div class="payment-card border border-gray-300 rounded-lg px-2 text-center transition-all duration-300 
                                {{ $nagadStatus == 1 ? 'cursor-pointer hover:scale-95' : 'opacity-40 cursor-not-allowed' }}"
                                data-method="nagad"
                                @if ($nagadStatus == 1) onclick="selectPayment('nagad')" @endif>

                                <img src="https://www.logo.wine/a/logo/Nagad/Nagad-Logo.wine.svg" alt="Nagad"
                                    class="w-24 h-12 mx-auto">
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="cod">
                    </div>

                    <style>
                        .payment-card {
                            transition: all 0.3s ease;
                        }

                        .payment-card.active {
                            border: 2px solid;
                            border-color: #f97316;
                            background-color: #fff7ed;
                        }
                    </style>

                    <script>
                        const paymentCards = document.querySelectorAll('.payment-card');
                        const hiddenInput = document.getElementById('selectedPaymentMethod');

                        paymentCards.forEach(card => {
                            card.addEventListener('click', () => {
                                paymentCards.forEach(c => c.classList.remove('active'));

                                card.classList.add('active');

                                hiddenInput.value = card.getAttribute('data-method');
                            });
                        });

                        document.addEventListener('DOMContentLoaded', () => {
                            const defaultCard = document.querySelector('[data-method="cod"]');
                            if (defaultCard) defaultCard.classList.add('active');
                        });
                    </script>
                    <button type="submit"
                        class="w-full bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] font-semibold py-3 rounded-lg transition">
                        <i class="ri-lock-line mr-1"></i> Confirm & Place Order
                    </button>
                </div>
            </form>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-lg shadow">
                <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart"
                    class="w-40 h-40 mb-6 animate-bounce">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-6 text-center px-4">Looks like you haven't added any products yet. Start
                    shopping
                    and fill your cart!</p>
                <a href="{{ route('home') }}"
                    class="bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] font-semibold py-3 px-6 rounded-lg transition">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- GTM + Pixel: InitiateCheckout -->

    @if ($buyNow)
        <script>
            (function() {
                var value = {{ $buyNow['price'] * $buyNow['quantity'] }};
                var ids = @json([$buyNow['id']]);

                if (window.dataLayer) {
                    dataLayer.push({
                        event: 'InitiateCheckout',
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product'
                    });
                }

                if (typeof fbq === 'function') {
                    fbq('track', 'InitiateCheckout', {
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product'
                    });
                }
            })();
        </script>
    @elseif(count($cart) > 0)
        <script>
            (function() {
                var value = {{ collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']) }};
                var ids = @json(array_column($cart, 'id'));

                if (window.dataLayer) {
                    dataLayer.push({
                        event: 'InitiateCheckout',
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product'
                    });
                }

                if (typeof fbq === 'function') {
                    fbq('track', 'InitiateCheckout', {
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product'
                    });
                }

            })();
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.quantity-input').on('change', function() {
                var id = $(this).data('id');
                var quantity = $(this).val();

                $.ajax({
                    url: '/cart/update/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            $('input[data-id="' + id + '"]').closest(
                                '.flex.items-center.justify-between').find(
                                'p.text-gray-800').text('৳' + response.item_total
                                .toLocaleString());

                            $('.lg\\:w-1\\/3 span.subtotal').text('৳' + response.subtotal
                                .toLocaleString());
                            $('.lg\\:w-1\\/3 span.total').text('৳' + response.total
                                .toLocaleString());
                        }
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationSpan = document.querySelector('.customer-location');

            if (!navigator.geolocation) {
                locationSpan.textContent = "Location not supported";
                return;
            }

            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

            function successCallback(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (data.address) {
                            const city = data.address.city || data.address.town || data.address.village ||
                                "Unknown city";
                            const country = data.address.country || "Unknown country";

                            locationSpan.textContent = `${city}, ${country}`;

                            sessionStorage.setItem('customerCity', city);
                            sessionStorage.setItem('customerCountry', country);
                        } else {
                            locationSpan.textContent = "Location not available";
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        locationSpan.textContent = "Location not available";
                    });
            }

            function errorCallback(err) {
                locationSpan.textContent = "Permission denied";
            }
        });
    </script>
@endsection
