@extends('frontend.layouts.master')
@section('title', 'Shopping Cart')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">
        <h1
            class="text-2xl font-medium mb-6 text-gray-800 relative inline-block after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-orange-500 after:bottom-[-6px] after:left-0">
            🛍️ Shopping Cart
        </h1>

        @if (session('cart') && count(session('cart')) > 0)

            <div class="flex flex-col lg:flex-row gap-4">
                <div class="lg:w-2/3 bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-medium">Your Products</h2>

                    @php $subtotal = 0; @endphp

                    @if (session('cart') && count(session('cart')) > 0)
                        @foreach (session('cart') as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <div class="flex items-center justify-between border-b border-gray-200 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                        class="w-[68px] h-[68px] object-cover rounded">
                                    <div>
                                        <h3 class="font-medium text-gray-800 text-md">
                                            {{ \Illuminate\Support\Str::limit($item['name'], 30) }}</h3>
                                        <div class="flex items-center gap-2">
                                            <p class="text-gray-500 text-sm">Variation:</p>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                @if (!empty($item['variants']) && is_array($item['variants']))
                                                    @foreach ($item['variants'] as $key => $value)
                                                        <div
                                                            class="bg-white border rounded text-xs text-gray-700 px-3 py-1">
                                                            {{ ucfirst($key) }}: {{ $value }}
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
                                    <p class="text-gray-800 font-medium">
                                        ৳{{ number_format($item['price'] * $item['quantity'], 0) }}</p>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-xs rounded-3xl hover:underline mt-1 px-3 py-0.5 bg-red-500 text-white">X
                                            Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="lg:w-1/3 bg-white shadow rounded-lg p-4 h-fit">
                    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2"><i
                            class="ri-bill-line text-orange-500"></i>Order Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Your Location</span>
                        <span class="text-gray-800 font-medium customer-location">Detecting...</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-800 font-medium subtotal">৳{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping Charge</span>
                        @php
                            $shipping = number_format(session('shippingCharge', 150), 0);
                        @endphp
                        <span class="text-gray-800 font-medium shipping">৳{{ $shipping }}</span>
                    </div>
                    <div class="border-t border-gray-200 mt-2 mb-4"></div>
                    <div class="flex justify-between text-lg font-medium mb-6">
                        <span>Total</span>
                        <span class="total">৳{{ number_format($subtotal + $shipping, 0) }}</span>
                    </div>

                    @if (session('cart') && count(session('cart')) > 0)
                        <a href="{{ route('checkout.index') }}"
                            class="w-full block text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 rounded-lg transition">
                            Proceed to Checkout
                        </a>
                    @else
                        <button class="w-full bg-gray-300 text-white font-medium py-3 rounded-lg cursor-not-allowed"
                            disabled>
                            Proceed to Checkout
                        </button>
                    @endif
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-lg shadow">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart"
                    class="w-40 h-40 mb-6 animate-bounce">
                <h2 class="text-2xl font-medium text-gray-700 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-6 text-center px-4">Looks like you haven't added any products yet. Start shopping
                    and fill your cart!</p>
                <a href="{{ route('home') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-lg transition">
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
