@extends('backend.layouts.app')
@section('title', 'Order Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Page Heading / Breadcrumb -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-xl font-bold text-gray-700 flex items-center gap-2">
                <i class="ri-stack-line text-xl text-indigo-500"></i>
                Confirmed Orders
            </h1>
            <nav class="text-sm text-gray-500 mt-2 sm:mt-0">
                <ol class="list-reset flex">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>Orders</li>
                </ol>
            </nav>
        </div>

        @php
            $statuses = [
                [
                    'name' => 'All Orders',
                    'color' => 'from-amber-400 to-amber-500',
                    'icon' => 'ri-stack-line',
                    'count' => $allOrdersCount ?? 0,
                    'route' => route('admin.orders.index'),
                ],
                [
                    'name' => 'Pending',
                    'color' => 'from-orange-400 to-orange-500',
                    'icon' => 'ri-time-line',
                    'count' => $pendingCount ?? 0,
                    'route' => route('admin.orders.pending'),
                ],
                [
                    'name' => 'Confirmed',
                    'color' => 'from-sky-400 to-sky-500',
                    'icon' => 'ri-checkbox-circle-line',
                    'count' => $confirmedCount ?? 0,
                    'route' => route('admin.orders.confirmed'),
                ],
                [
                    'name' => 'Ready to Ship',
                    'color' => 'from-indigo-400 to-indigo-500',
                    'icon' => 'ri-refresh-line',
                    'count' => $readyCount ?? 0,
                    'route' => route('admin.orders.ready'),
                ],
                [
                    'name' => 'Shipped',
                    'color' => 'from-violet-400 to-violet-500',
                    'icon' => 'ri-truck-line',
                    'count' => $shippedCount ?? 0,
                    'route' => route('admin.orders.shipped'),
                ],
                [
                    'name' => 'Delivered',
                    'color' => 'from-green-400 to-emerald-500',
                    'icon' => 'ri-check-double-line',
                    'count' => $deliveredCount ?? 0,
                    'route' => route('admin.orders.delivered'),
                ],
                [
                    'name' => 'Cancelled',
                    'color' => 'from-rose-400 to-rose-500',
                    'icon' => 'ri-close-circle-line',
                    'count' => $cancelledCount ?? 0,
                    'route' => route('admin.orders.cancelled'),
                ],
                [
                    'name' => 'Refunded',
                    'color' => 'from-slate-400 to-slate-500',
                    'icon' => 'ri-money-dollar-circle-line',
                    'count' => $refundedCount ?? 0,
                    'route' => route('admin.orders.refunded'),
                ],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 mb-4">
            @foreach ($statuses as $status)
                <div onclick="window.location.href='{{ $status['route'] }}'"
                    class="bg-gradient-to-br {{ $status['color'] }} cursor-pointer text-white rounded-md shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 p-4 flex flex-col justify-between h-20 relative overflow-hidden">

                    <div
                        class="absolute inset-0 bg-white/10 opacity-0 hover:opacity-20 transition-opacity duration-300 rounded-xl">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <h3 class="text-sm font-semibold tracking-wide">{{ $status['name'] }}</h3>
                            <p class="text-lg font-bold mt-1">{{ $status['count'] }}</p>
                        </div>
                        <i class="{{ $status['icon'] }} text-2xl opacity-80"></i>
                    </div>
                </div>
            @endforeach
        </div>

        <form id="orderForm" method="POST" class="w-full mb-4" x-data="{ open: false }">
            @csrf
            <input type="hidden" name="ids[]" id="ids">

            <div class="flex items-center gap-2">
                <!-- Status Change Button -->
                <button type="button" @click="open = true"
                    class="relative inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow font-medium transition-all duration-200 group"
                    title="Change Status">
                    <i class="ri-refresh-line mr-2"></i> Status Change
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                        Change the order status
                    </span>
                </button>

                <!-- Add Order Button -->
                <button type="button" onclick="window.location.href='{{ route('admin.orders.create') }}'"
                    class="relative inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow font-medium transition-all duration-200 group"
                    title="Add New Order">
                    <i class="ri-add-line mr-2"></i> Add Order
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                        Add a new order
                    </span>
                </button>

                <!-- Delete Button -->
                <button type="button" onclick="submitForm('{{ route('admin.orders.destroy') }}')"
                    class="relative inline-flex items-center bg-[#E83330] hover:bg-[#E83330] text-white px-4 py-2 rounded-md shadow font-medium transition-all duration-200 group"
                    title="Delete Order">
                    <i class="ri-delete-bin-6-line mr-2"></i> Delete
                    <span
                        class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-all duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                        Delete this order
                    </span>
                </button>
            </div>

            <!-- Status Modal -->
            <div x-show="open" x-transition
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div @click.away="open = false"
                    class="bg-white rounded-lg shadow-lg w-[450px] max-w-full p-6 flex flex-col gap-4 relative">

                    <button @click="open = false" type="button"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        <i class="ri-close-line text-xl"></i>
                    </button>

                    <h3 class="text-lg font-bold text-gray-800 text-center">Change Status</h3>

                    <div class="flex flex-wrap w-full gap-2">
                        @php
                            $statuses = [
                                'pending' => 'bg-yellow-500',
                                'confirmed' => 'bg-blue-500',
                                'Ready to Ship' => 'bg-indigo-500',
                                'shipped' => 'bg-purple-500',
                                'delivered' => 'bg-green-500',
                                'cancelled' => 'bg-red-500',
                                'refunded' => 'bg-gray-600',
                            ];
                        @endphp

                        @foreach ($statuses as $status => $color)
                            <button type="button"
                                onclick="changeStatus('{{ $status }}', '{{ route('admin.orders.status') }}')"
                                class="{{ $color }} text-white flex-1 h-10 min-w-[100px] rounded shadow hover:opacity-90 transition-all duration-150 text-sm font-medium text-center">
                                {{ ucfirst($status) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Invoice ID</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Customer</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Products</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Amount</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Orders</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Payment</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($orders as $index => $order)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                            onclick="const cb=this.querySelector('input[type=checkbox]'); cb.checked = !cb.checked; updateSelectedIds();">

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <input type="checkbox" name="orders[]" value="{{ $order->id }}"
                                    class="order-checkbox w-[16px] h-[16px] text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    onclick="event.stopPropagation(); updateSelectedIds();">
                            </td>

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

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                ৳{{ number_format($order->total, 2) }}
                            </td>

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500',
                                        'confirmed' => 'bg-blue-500',
                                        'processing' => 'bg-indigo-500',
                                        'shipped' => 'bg-purple-500',
                                        'delivered' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500',
                                        'refunded' => 'bg-gray-600',
                                    ];
                                    $color = $statusColors[$order->order_status] ?? 'bg-gray-400';
                                @endphp
                                <span class="px-2 py-1.5 rounded text-white text-xs {{ $color }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if ($order->payment_status === 'paid')
                                    <span class="px-2 py-1.5 rounded bg-green-500 text-white text-xs">Paid</span>
                                @else
                                    <span class="px-2 py-1.5 rounded bg-red-500 text-white text-xs">Unpaid</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-center md:justify-end items-center gap-2">
                                    <!-- View -->
                                    <div class="relative group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-indigo-500 hover:bg-indigo-600 
                text-white rounded-full shadow transition-all duration-200">
                                            <i class="ri-eye-line text-md"></i>
                                        </a>
                                        <span
                                            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 text-xs bg-gray-800 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap">
                                            View Order
                                        </span>
                                    </div>
{{-- 
                                    <!-- Edit -->
                                    <div class="relative group">
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-green-500 hover:bg-green-600 
                text-white rounded-full shadow transition-all duration-200">
                                            <i class="ri-edit-2-line text-md"></i>
                                        </a>
                                        <span
                                            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 text-xs bg-gray-800 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap">
                                            Edit Order
                                        </span>
                                    </div> --}}

                                    <!-- Delete -->
                                    <div class="relative group">
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this order?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 
                    text-white rounded-full shadow transition-all duration-200">
                                                <i class="ri-delete-bin-6-line text-md"></i>
                                            </button>
                                        </form>
                                        <span
                                            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 text-xs bg-gray-800 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap">
                                            Delete Order
                                        </span>
                                    </div>
                                </div>
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
    </div>
@endsection
@push('scripts')
    <script>
        function updateSelectedIds() {
            const checkboxes = document.querySelectorAll('.order-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);
            document.getElementById('ids').value = JSON.stringify(ids);
        }

        function submitForm(action) {
            const form = document.getElementById('orderForm');
            const ids = document.getElementById('ids').value;

            if (!ids || ids === '[]') {
                alert('Please select at least one order first!');
                return;
            }

            form.action = action;
            form.method = 'POST';
            form.submit();
        }

        function changeStatus(status, action) {
            const form = document.getElementById('orderForm');
            const ids = document.getElementById('ids').value;

            if (!ids || ids === '[]') {
                alert('Please select at least one order first!');
                return;
            }

            form.action = action;
            form.method = 'POST';
            let statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = status;
            form.appendChild(statusInput);
            form.submit();
        }
    </script>
@endpush
