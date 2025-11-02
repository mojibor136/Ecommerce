@extends('frontend.layouts.master')
@section('title', 'Order Tracking')
@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Track Your Order</h2>

            <!-- Order Tracking Form -->
            <form id="orderTrackingForm" class="space-y-4">
                <div>
                    <label for="order_id" class="block text-gray-700 font-medium mb-2">Order ID</label>
                    <input type="text" id="order_id" name="order_id" placeholder="Enter your Order ID"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-md transition duration-200">
                    Track Order
                </button>
            </form>

            <!-- Order Details Section -->
            <div id="orderDetails" class="mt-6 hidden bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Order Details</h3>
                <p class=" mb-1 block"><span class="font-medium">Order ID:</span> <span id="detailOrderId"></span></p>
                <p class=" mb-1 block"><span class="font-medium">Customer Name:</span> <span id="detailCustomerName"></span>
                </p>
                <p class=" mb-1 block"><span class="font-medium">Shipping Address:</span> <span id="detailShipping"></span>
                </p>
                <p class=" mb-1 block"><span class="font-medium">Order Status:</span> <span id="detailStatus"></span></p>
                <p class=" mb-1 block"><span class="font-medium">Total Amount:</span> <span id="detailTotal"></span></p>
                <a href="{{ route('home') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-medium mt-4 block text-center py-3 px-6 rounded-lg transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <script>
        // Example JS to show how order details can be filled
        const form = document.getElementById('orderTrackingForm');
        const detailsBox = document.getElementById('orderDetails');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const orderId = document.getElementById('order_id').value;

            if (!orderId) {
                alert('Please enter an Order ID');
                return;
            }

            // Example: manually filling data for now
            // Later connect this with AJAX to backend API
            document.getElementById('detailOrderId').textContent = orderId;
            document.getElementById('detailCustomerName').textContent = "John Doe";
            document.getElementById('detailShipping').textContent = "123, Dhaka, Bangladesh";
            document.getElementById('detailStatus').textContent = "Processing";
            document.getElementById('detailTotal').textContent = "৳2500";

            detailsBox.classList.remove('hidden');
        });
    </script>
@endsection
