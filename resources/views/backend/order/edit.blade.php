@extends('backend.layouts.app')
@section('title', 'Order Details')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">

        <!-- Title -->
        <h1
            class="text-2xl font-semibold mb-6 text-gray-800 relative inline-block 
       after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-indigo-500 after:bottom-[-6px] after:left-0">
            📝 Order Details
        </h1>

        <!-- PRODUCTS FIXED CARD PREVIEW -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">🛒 Ordered Products</h3>

            <div class="w-full">
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">
                                Product
                            </th>
                            <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">
                                Variant
                            </th>
                            <th class="px-3 md:px-4 py-2 text-center text-sm font-medium text-gray-700 whitespace-nowrap">
                                Quantity
                            </th>
                            <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">
                                Price
                            </th>
                            <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">
                                Total,Tk
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-3 md:px-4 py-2 text-sm text-gray-800 flex items-center gap-2">
                                    <img src="{{ $item->product_image }}" class="w-10 h-10 object-cover rounded-full">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-3 md:px-4 py-2 text-sm text-gray-600">
                                    @php
                                        $json = str_replace('\"', '"', $item->attributes);
                                        $attributes = json_decode($json, true);
                                    @endphp

                                    @if ($attributes && is_array($attributes))
                                        @foreach ($attributes as $key => $value)
                                            <span class="mr-2"><strong class="font-normal">{{ $key }}:</strong>
                                                {{ $value }}</span>
                                        @endforeach
                                    @else
                                        Default
                                    @endif
                                </td>
                                <td class="px-3 md:px-4 py-2 text-sm text-gray-700 text-center">{{ $item->quantity }}</td>
                                <td class="px-3 md:px-4 py-2 text-sm text-gray-700">৳{{ number_format($item->price, 0) }}
                                </td>
                                <td class="px-3 md:px-4 py-2 text-sm text-gray-800 font-medium">
                                    ৳{{ number_format($item->price * $item->quantity, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHIPPING FORM -->
        <form action="" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-700 mb-2">📦 Update Shipping Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Customer Name</label>
                        <input type="text" name="name" value="{{ $order->shipping->name }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ $order->shipping->email }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Phone</label>
                        <input type="text" name="phone" value="{{ $order->shipping->phone }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Address</label>
                        <input type="text" name="address" value="{{ $order->shipping->address }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    </div>

                </div>

                <button type="submit" class="mt-4 px-5 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                    💾 Update Shipping
                </button>
            </div>
        </form>

        <div class="bg-white shadow rounded-lg p-6 mb-2">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                <h2 class="text-md font-medium text-gray-700">OrderID <span
                        class="text-indigo-700 font-semibold">#{{ $order->invoice_id }}</span></h2>
                <p class="text-gray-500 text-sm">Placed on: {{ $order->created_at->format('d M, Y H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center">
                <h3 class="text-gray-500 text-sm">Subtotal</h3>
                <p class="text-gray-800 font-semibold text-lg">
                    ৳{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }}
                </p>
            </div>

            <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center">
                <h3 class="text-gray-500 text-sm">Discount</h3>
                <p class="text-gray-800 font-semibold text-lg">
                    ৳{{ number_format($order->discount ?? 0, 2) }}
                </p>
            </div>

            <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center">
                <h3 class="text-gray-500 text-sm">Shipping</h3>
                <p class="text-gray-800 font-semibold text-lg">
                    ৳{{ number_format($order->shipping_charge ?? 0) }}
                </p>
            </div>

            <div class="bg-indigo-50 shadow rounded-lg p-4 flex flex-col items-center justify-center">
                <h3 class="text-gray-700 text-sm">Total Amount</h3>
                <p class="text-indigo-900 font-bold text-lg">
                    ৳{{ number_format(
                        $order->items->sum(fn($i) => $i->price * $i->quantity) - ($order->discount ?? 0) + ($order->shipping_charge ?? 0),
                    ) }}
                </p>
            </div>
        </div>
    </div>
@endsection
