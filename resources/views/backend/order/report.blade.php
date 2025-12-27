@extends('backend.layouts.app')
@section('title', 'Order Management')
@section('content')
    <div class="w-full mb-6">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-xl font-bold text-gray-700 flex items-center gap-2">
                <i class="ri-stack-line text-xl text-indigo-500"></i>
                Sales Report
            </h1>
            <nav class="text-sm text-gray-500 mt-2 sm:mt-0">
                <ol class="list-reset flex">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>Orders</li>
                </ol>
            </nav>
        </div>

        <form method="GET" action="{{ route('admin.orders.report') }}"
            class="bg-white p-4 rounded shadow mb-4 flex flex-wrap gap-4 items-end">

            <div>
                <label class="text-sm text-gray-600">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="border rounded px-3 py-2 text-gray-700">
            </div>

            <div>
                <label class="text-sm text-gray-600">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="border rounded px-3 py-2 text-gray-700">
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">
                Search
            </button>

        </form>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Invoice ID</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Customer</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Products</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Buy</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Sales</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Profit</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($orders as $index => $order)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                            onclick="const cb=this.querySelector('input[type=checkbox]'); cb.checked = !cb.checked; updateSelectedIds();">

                            <td class="px-4 py-3 text-left whitespace-nowrap font-medium text-gray-800">
                                {{ $order->invoice_id }}
                            </td>

                            <td class="px-4 py-3 text-left whitespace-nowrap font-medium text-gray-800">
                                <div class="flex flex-col">
                                    <div class="flex flex-row gap-1">
                                        <strong class="text-gray-700">Name:</strong> {{ $order->shipping->name }}
                                    </div>
                                    <div class="flex flex-row gap-1">
                                        <strong class="text-gray-700">Address:</strong>
                                        {{ \Illuminate\Support\Str::limit($order->shipping->address, 30, '...') }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-left whitespace-nowrap font-medium text-gray-800">
                                <div class="flex flex-row items-center">
                                    @foreach ($order->items as $item)
                                        @if ($item->product_image)
                                            <img src="{{ $item->product_image }}" alt="Product Image"
                                                class="w-12 h-12 object-cover rounded-full border border-gray-200 -mr-[10px]"
                                                onclick="window.open('{{ $item->product_image }}', '_blank')">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-sm -mr-[5px]">
                                                N/A
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                ৳{{ number_format($order->order_buy, 2) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                ৳{{ number_format($order->order_sell, 2) }}
                            </td>

                            <td
                                class="px-4 py-3 text-center {{ $order->order_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ৳{{ number_format($order->order_profit, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="8" class="py-4 px-3 text-center text-gray-400">No orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">

            <div class="bg-white p-5 rounded shadow border-l-4 border-green-500">
                <h3 class="text-sm text-gray-500">Total Sale</h3>
                <p class="text-xl font-bold text-green-600">
                    ৳ {{ number_format($totalSell, 2) }}
                </p>
            </div>

            <div class="bg-white p-5 rounded shadow border-l-4 border-blue-500">
                <h3 class="text-sm text-gray-500">Total Buy</h3>
                <p class="text-xl font-bold text-blue-600">
                    ৳ {{ number_format($totalBuy, 2) }}
                </p>
            </div>

            <div class="bg-white p-5 rounded shadow border-l-4 border-indigo-500">
                <h3 class="text-sm text-gray-500">Profit</h3>
                <p class="text-xl font-bold {{ $profit >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                    ৳ {{ number_format($profit, 2) }}
                </p>
            </div>
        </div>
    </div>
@endsection
