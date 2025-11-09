@extends('frontend.layouts.master')
@section('title', 'Order Success')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-5 px-4">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-xl w-full text-center">
            <!-- Success Icon -->
            <div class="text-green-500 text-6xl mb-6">
                <i class="ri-check-line"></i>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Thank You!</h1>

            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Your order has been successfully placed. We have sent you an email confirmation with your order details.
            </p>

            <!-- Order Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
                <p class="text-gray-700 mb-2"><span class="font-medium">Order ID:</span> #{{ request('invoice_id') }}</p>
                <p class="text-gray-700 mb-2"><span class="font-medium">Total Amount:</span>
                    ৳{{ number_format(request('amount'), 2) }}</p>
                <p class="text-gray-700"><span class="font-medium">Payment Method:</span> {{ request('method') }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                    <i class="ri-home-5-line mr-1"></i> Back to Home
                </a>
                <a href="email"
                    class="w-full border border-orange-500 text-orange-500 hover:bg-orange-50 font-semibold py-3 rounded-lg transition">
                    <i class="ri-file-list-line mr-1"></i> View My Orders
                </a>
            </div>
        </div>
    </div>
@endsection
