@extends('frontend.layouts.master')
@section('title', 'Order Tracking')

@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Track Your Order</h2>

            {{-- Error message --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tracking Form -->
            <form action="{{ route('order.tracking.check') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="order_id" class="block text-gray-700 font-medium mb-2">
                        Order ID or Invoice ID
                    </label>

                    <input type="text" id="order_id" name="order_id" placeholder="Enter your Order/Invoice ID"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white font-semibold py-2.5 rounded-md">
                    Track Order
                </button>
            </form>

            {{-- Show Order Details if exists --}}
            @if (session('order'))
                @php $order = session('order'); @endphp
                <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Details</h3>

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">

                        <!-- Order ID -->
                        <div class="flex items-center gap-3">
                            <i class="ri-hashtag# ri-hashtag text-xl text-gray-600"></i>
                            <p class="text-gray-700">
                                <b class="text-gray-900">Order ID:</b> {{ $order->id }}
                            </p>
                        </div>

                        <!-- Invoice ID -->
                        <div class="flex items-center gap-3">
                            <i class="ri-file-list-3-line text-xl text-gray-600"></i>
                            <p class="text-gray-700">
                                <b class="text-gray-900">Invoice ID:</b> {{ $order->invoice_id }}
                            </p>
                        </div>

                        <!-- Customer -->
                        <div class="flex items-center gap-3">
                            <i class="ri-user-3-line text-xl text-gray-600"></i>
                            <p class="text-gray-700">
                                <b class="text-gray-900">Customer:</b> {{ $order->shipping->name }}
                            </p>
                        </div>

                        <!-- Address -->
                        <div class="flex items-center gap-3">
                            <i class="ri-map-pin-line text-xl text-gray-600"></i>
                            <p class="text-gray-700">
                                <b class="text-gray-900">Address:</b> {{ $order->shipping->address }}
                            </p>
                        </div>

                        <!-- Status with Color Badge -->
                        <div class="flex items-center gap-3">
                            <i class="ri-timer-flash-line text-xl text-gray-600"></i>

                            @php
                                $statusColor = match ($order->order_status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <p class="text-gray-700">
                                <b class="text-gray-900">Order Status:</b>
                                <span class="px-2 py-1 rounded-md text-sm font-semibold capitalize {{ $statusColor }}">
                                    {{ $order->order_status }}
                                </span>
                            </p>
                        </div>

                        <!-- Amount -->
                        <div class="flex items-center gap-3">
                            <i class="ri-money-dollar-circle-line text-xl text-gray-600"></i>
                            <p class="text-gray-700">
                                <b class="text-gray-900">Total Amount:</b> {{ number_format($order->total, 2) }} ৳
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
