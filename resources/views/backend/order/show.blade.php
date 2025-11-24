@extends('backend.layouts.app')
@section('title', 'Order Details')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">
        <h1
            class="text-2xl font-semibold mb-6 text-gray-800 relative inline-block 
           after:content-[''] after:absolute after:w-1/2 after:h-[3px] after:bg-[{{ $theme->theme_bg }}] after:bottom-[-6px] after:left-0">
            📝 Order Details
        </h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6 flex flex-col md:flex-row justify-between gap-6">
            <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-700 mb-2 flex items-center gap-2">
                    Customer Information
                </h3>

                <p class="text-gray-500 text-sm mb-2 flex items-center gap-2">
                    <i class="ri-user-line text-[{{ $theme->theme_bg }}]"></i>
                    Name: {{ $order->shipping->name }}
                </p>

                <p class="text-gray-500 text-sm mb-2 flex items-center gap-2">
                    <i class="ri-mail-line text-[{{ $theme->theme_bg }}]"></i>
                    Email: {{ $order->shipping->email }}
                </p>

                <p class="text-gray-500 text-sm mb-2 flex items-center gap-2">
                    <i class="ri-phone-line text-[{{ $theme->theme_bg }}]"></i>
                    Phone: {{ $order->shipping->phone }}
                </p>

                <p class="text-gray-500 text-sm mb-2 flex items-center gap-2">
                    <i class="ri-map-pin-line text-[{{ $theme->theme_bg }}]"></i>
                    Address: {{ $order->shipping->address }}
                </p>
            </div>
        </div>

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
                        <th class="px-3 md:px-4 py-2 text-center text-sm font-medium text-gray-700 whitespace-nowrap">
                            Quantity</th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Price
                        </th>
                        <th class="px-3 md:px-4 py-2 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Total,Tk
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
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-700">৳{{ number_format($item->price, 0) }}</td>
                            <td class="px-3 md:px-4 py-2 text-sm text-gray-800 font-medium">
                                ৳{{ number_format($item->price * $item->quantity, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ route('admin.orders.index') }}"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-700 text-center w-full sm:w-auto">
                Back to Orders
            </a>
            <form action="{{ route('admin.orders.invoice') }}" method="POST" target="_blank" style="display:inline;">
                @csrf
                <input type="hidden" name="ids" value="{{ $order->id }}">

                <button type="submit"
                    class="px-4 py-2 bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  rounded hover:bg-[{{ $theme->theme_hover }}] text-center w-full sm:w-auto">
                    Print Invoice
                </button>
            </form>
        </div>
    </div>
@endsection
