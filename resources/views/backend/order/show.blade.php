@extends('backend.layouts.app')
@section('title', 'Order Details')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">

        <h1
            class="text-2xl font-semibold mb-6 text-gray-800 relative inline-block 
           after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-indigo-500 after:bottom-[-6px] after:left-0">
            📝 Order Details
        </h1>

        <!-- Company & Customer Info -->
        <div class="bg-white shadow rounded-lg p-6 mb-6 flex flex-col md:flex-row justify-between gap-6">
            <!-- Company Info -->
            <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Customer Information</h3>
                <p class="text-gray-500 text-sm mb-1">Name: {{ $order->shipping->name }}</p>
                <p class="text-gray-500 text-sm mb-1">Email: {{ $order->shipping->email }}</p>
                <p class="text-gray-500 text-sm mb-1">Phone: {{ $order->shipping->phone }}</p>
                <p class="text-gray-500 text-sm mb-1">Address: {{ $order->shipping->address }}</p>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow rounded-lg pb-6 pt-4 px-4 md:px-6 mb-6 overflow-x-auto">

            <div class="flex flex-col mb-3">
                <h2 class="text-lg font-medium text-gray-700 m-0">Order #{{ $order->invoice_id }}</h2>
                <p class="text-gray-500 text-sm m-0 p-0">Placed on: {{ $order->created_at->format('d M, Y H:i') }}</p>
            </div>

            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Product
                        </th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Variant
                        </th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Qty</th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Price
                        </th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Total
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-800 flex items-center gap-2">
                                <img src="{{ asset('uploads/products/' . ($item->product->images->first()->image ?? 'default.png')) }}"
                                    class="w-10 h-10 object-cover rounded">
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
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-700">৳{{ number_format($item->price, 0) }}</td>
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-800 font-medium">
                                ৳{{ number_format($item->price * $item->quantity, 0) }}</td>
                        </tr>
                    @endforeach
                    <!-- Summary Row -->
                    <tr class="bg-gray-50 font-medium">
                        <td colspan="4" class="px-3 md:px-4 py-2 text-right text-sm text-gray-700">Subtotal</td>
                        <td class="px-3 md:px-4 py-2 text-sm text-gray-800">
                            ৳{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50 font-medium">
                        <td colspan="4" class="px-3 md:px-4 py-2 text-right text-sm text-gray-700">Discount</td>
                        <td class="px-3 md:px-4 py-2 text-sm text-gray-800">৳{{ number_format($order->discount ?? 0, 2) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50 font-medium">
                        <td colspan="4" class="px-3 md:px-4 py-2 text-right text-sm text-gray-700">Shipping</td>
                        <td class="px-3 md:px-4 py-2 text-sm text-gray-800">
                            ৳{{ number_format($order->shipping_charge) }}</td>
                    </tr>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="4" class="px-3 md:px-4 py-2 text-right text-sm text-gray-800">Total Amount</td>
                        <td class="px-3 md:px-4 py-2 text-sm text-gray-900">
                            ৳{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity) - ($order->discount ?? 0) + ($order->shipping_charge ?? 0)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ route('admin.orders.index') }}"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-700 text-center w-full sm:w-auto">
                Back to Orders
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-center w-full sm:w-auto">
                Print Invoice
            </a>
        </div>
    </div>
@endsection
