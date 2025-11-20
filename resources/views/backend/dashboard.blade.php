@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pb-4 text-gray-800">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-2 sm:mt-0">
                Here’s a quick overview of your store statistics.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
            <!-- Orders -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <h2 class="text-3xl font-bold">{{ $ordersCount['all'] ?? 0 }}</h2>
                </div>
                <i class="ri-shopping-cart-2-line text-4xl text-blue-500"></i>
            </div>

            <!-- Products -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Products</p>
                    <h2 class="text-3xl font-bold">{{ $productCount ?? 0 }}</h2>
                </div>
                <i class="ri-box-3-line text-4xl text-indigo-500"></i>
            </div>

            <!-- Categories -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Categories</p>
                    <h2 class="text-3xl font-bold">{{ $categoryCount ?? 0 }}</h2>
                </div>
                <i class="ri-folder-4-line text-4xl text-green-500"></i>
            </div>

            <!-- Subcategories -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Subcategories</p>
                    <h2 class="text-3xl font-bold">{{ $subcategoryCount ?? 0 }}</h2>
                </div>
                <i class="ri-stack-line text-4xl text-orange-500"></i>
            </div>
        </div>

        <!-- Sales Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mb-3">
            <!-- Daily Sales -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Today's Sales</p>
                    <h2 class="text-3xl font-bold">৳ {{ number_format($dailySales ?? 0, 2) }}</h2>
                </div>
                <i class="ri-calendar-line text-4xl text-purple-500"></i>
            </div>

            <!-- Monthly Sales -->
            <div class="bg-white p-5 rounded shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">This Month's Sales</p>
                    <h2 class="text-3xl font-bold">৳ {{ number_format($monthlySales ?? 0, 2) }}</h2>
                </div>
                <i class="ri-calendar-2-line text-4xl text-teal-500"></i>
            </div>
        </div>

        <!-- Orders Status Overview -->
        <div class="bg-white rounded p-5 shadow mb-6">
            <h2 class="font-semibold text-lg mb-4">Orders Status Overview</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($ordersCount as $status => $count)
                    <div class="bg-gray-50 p-4 rounded shadow hover:shadow-md transition text-center">
                        <p class="text-gray-500 capitalize text-sm">{{ $status }}</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $count }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
