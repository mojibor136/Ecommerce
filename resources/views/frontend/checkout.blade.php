@extends('frontend.layouts.master')
@section('title', 'Checkout')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">
        <h1
            class="text-2xl font-semibold mb-6 text-gray-800 relative inline-block
        after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-orange-500 after:bottom-[-6px] after:left-0">
            🛍️ Checkout
        </h1>

        @php
            $cart = session('cart', []);
            $buyNow = session('buy_now', null);
            $shipping = number_format(session('shippingCharge', 150), 0);
        @endphp

        @if ($buyNow)
            @php $subtotal = $buyNow['price'] * $buyNow['quantity']; @endphp
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="lg:w-2/3 bg-white shadow rounded-lg md:p-6 p-4">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-user-line text-orange-500"></i>Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-md mb-1 text-gray-600">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="Enter your name">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="+8801XXXXXXXXX">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="Enter city">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Delivery Area</label>
                            <select name="charge" id="deliveryArea"
                                class="w-full border border-gray-300 rounded px-3 py-[10px] text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
                                <option value="{{ $inDhakaCharge }}">Inside Dhaka</option>
                                <option value="{{ $outDhakaCharge }}">Outside Dhaka</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Full Address</label>
                            <textarea name="address" rows="3"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="House, Road, Area">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold flex items-center gap-2">
                        <i class="ri-shopping-bag-3-line text-orange-500"></i>Order Details
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
                            class="ri-bill-line text-orange-500"></i>Order Summary</h2>

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
                            class="ri-bank-card-line text-orange-500"></i>Payment Method</h3>
                    <div class="space-y-2 mb-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="cod"
                                class="text-orange-500 focus:ring-orange-500" checked>
                            <span>Cash on Delivery</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="bkash"
                                class="text-orange-500 focus:ring-orange-500">
                            <span>BKash / Nagad / Rocket</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="card"
                                class="text-orange-500 focus:ring-orange-500">
                            <span>Credit / Debit Card</span>
                        </label>
                    </div>

                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                        <i class="ri-lock-line mr-1"></i> Confirm & Place Order
                    </button>
                </div>
            </div>
        @elseif(count($cart) > 0)
            @php $subtotal = 0; @endphp
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="lg:w-2/3 bg-white shadow rounded-lg md:p-6 p-4">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-user-line text-orange-500"></i>Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-md mb-1 text-gray-600">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="Enter your name">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="+8801XXXXXXXXX">
                        </div>
                        <div>
                            <label class="text-md mb-1 text-gray-600">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="Enter city">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Delivery Area</label>
                            <select name="delivery_area" id="deliveryArea"
                                class="w-full border border-gray-300 rounded px-3 py-[10px] text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
                                <option value="{{ $inDhakaCharge }}">Inside Dhaka</option>
                                <option value="{{ $outDhakaCharge }}">Outside Dhaka</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-md mb-1 text-gray-600">Full Address</label>
                            <textarea name="address" rows="3"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none"
                                placeholder="House, Road, Area">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold flex items-center gap-2">
                        <i class="ri-shopping-bag-3-line text-orange-500"></i>Order Details
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
                                                class="w-14 border border-gray-300 rounded px-2 py-0.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition duration-200 outline-none quantity-input"
                                                data-id="{{ $id }}">
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-800 font-semibold">
                                        ৳{{ number_format($item['price'] * $item['quantity'], 0) }}</p>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-xs rounded-3xl hover:underline mt-1 px-3 md:py-0.5 py-1 bg-red-500 text-white">
                                            Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:w-1/3 bg-white shadow rounded-lg md:p-6 p-4 h-fit">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2"><i
                            class="ri-bill-line text-orange-500"></i>Order Summary</h2>

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
                            class="ri-bank-card-line text-orange-500"></i>Payment Method</h3>
                    <div class="space-y-2 mb-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="cod"
                                class="text-orange-500 focus:ring-orange-500" checked>
                            <span>Cash on Delivery</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="bkash"
                                class="text-orange-500 focus:ring-orange-500">
                            <span>BKash / Nagad / Rocket</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment" value="card"
                                class="text-orange-500 focus:ring-orange-500">
                            <span>Credit / Debit Card</span>
                        </label>
                    </div>

                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                        <i class="ri-lock-line mr-1"></i> Confirm & Place Order
                    </button>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-lg shadow">
                <img loading="lazy" src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart"
                    class="w-40 h-40 mb-6 animate-bounce">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-6 text-center px-4">Looks like you haven't added any products yet. Start
                    shopping
                    and fill your cart!</p>
                <a href="{{ route('home') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

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
