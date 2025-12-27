@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pb-4 text-gray-800">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-2 sm:mt-0">
                Here’s a quick overview of your store statistics.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
            <div class="bg-white cursor-pointer p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center"
                onclick="window.location.href='{{ route('admin.orders.index') }}'">
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <h2 class="text-3xl font-bold">{{ $ordersCount['all order'] ?? 0 }}</h2>
                </div>
                <i class="ri-shopping-cart-2-line text-4xl text-blue-500"></i>
            </div>

            <div class="bg-white cursor-pointer p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center"
                onclick="window.location.href='{{ route('admin.products.index') }}'">
                <div>
                    <p class="text-gray-500 text-sm">Products</p>
                    <h2 class="text-3xl font-bold">{{ $productCount ?? 0 }}</h2>
                </div>
                <i class="ri-box-3-line text-4xl text-indigo-500"></i>
            </div>

            <div class="bg-white cursor-pointer p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center"
                onclick="window.location.href='{{ route('admin.categories.index') }}'">
                <div>
                    <p class="text-gray-500 text-sm">Categories</p>
                    <h2 class="text-3xl font-bold">{{ $categoryCount ?? 0 }}</h2>
                </div>
                <i class="ri-folder-4-line text-4xl text-green-500"></i>
            </div>

            <div class="bg-white cursor-pointer p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center"
                onclick="window.location.href='{{ route('admin.subcategories.index') }}'">
                <div>
                    <p class="text-gray-500 text-sm">Subcategories</p>
                    <h2 class="text-3xl font-bold">{{ $subcategoryCount ?? 0 }}</h2>
                </div>
                <i class="ri-stack-line text-4xl text-orange-500"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mb-3">
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Today's Sales</p>
                    <h2 class="text-3xl font-bold">৳ {{ number_format($dailySales ?? 0, 2) }}</h2>
                </div>
                <i class="ri-calendar-line text-4xl text-purple-500"></i>
            </div>

            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">This Month's Sales</p>
                    <h2 class="text-3xl font-bold">৳ {{ number_format($monthlySales ?? 0, 2) }}</h2>
                </div>
                <i class="ri-calendar-2-line text-4xl text-teal-500"></i>
            </div>
        </div>

        @php
            $colors = [
                'from-lime-400 to-lime-500',
                'from-blue-400 to-blue-500',
                'from-red-400 to-red-500',
                'from-amber-400 to-amber-500',
                'from-emerald-400 to-emerald-500',
                'from-purple-400 to-purple-500',
                'from-pink-400 to-pink-500',
                'from-cyan-400 to-cyan-500',
            ];

            $icons = [
                'pending' => 'ri-time-line',
                'confirmed' => 'ri-checkbox-circle-line',
                'ready' => 'ri-refresh-line',
                'shipped' => 'ri-truck-line',
                'delivered' => 'ri-check-double-line',
                'cancelled' => 'ri-close-circle-line',
                'refunded' => 'ri-money-dollar-circle-line',
            ];
        @endphp

        <h2 class="font-semibold text-lg mb-3 text-gray-700">Orders Overview</h2>

        <div class="bg-white rounded-lg p-5 shadow-lg mb-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($ordersCount as $status => $count)
                    @php
                        $index = array_rand($colors);
                        $gradient = $colors[$index];
                        $icon = $icons[strtolower(str_replace(' ', '', $status))] ?? 'ri-stack-line';
                    @endphp

                    <div
                        class="relative overflow-hidden rounded-lg shadow hover:shadow-xl transition transform hover:-translate-y-1 bg-gradient-to-br {{ $gradient }} text-white p-5 flex flex-col justify-between">
                        <div class="absolute top-3 right-3 opacity-20 text-4xl">
                            <i class="{{ $icon }}"></i>
                        </div>

                        <p class="text-sm font-semibold capitalize">{{ $status }}</p>

                        <h3 class="text-2xl font-bold mt-2">{{ $count }}</h3>

                        <div class="w-full bg-white/30 h-2 rounded-full mt-3">
                            <div class="bg-white h-2 rounded-full" style="width: {{ min($count, 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
