@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pb-4 text-gray-800">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h1 class="text-xl font-bold">Welcome , {{ auth()->guard('web')->user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-2 sm:mt-0">Welcome back, here’s a quick summary of your shop.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Total Orders -->
            <div class="bg-white p-6 rounded shadow-md hover:shadow-lg transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Orders</p>
                        <h2 class="text-3xl font-bold mt-1">1,245</h2>
                        <span class="text-xs text-green-600">+12% from last week</span>
                    </div>
                    <i class="ri-shopping-cart-2-line text-4xl text-blue-500"></i>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white p-6 rounded shadow-md hover:shadow-lg transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Sales</p>
                        <h2 class="text-3xl font-bold mt-1">$24,580</h2>
                        <span class="text-xs text-green-600">+8% growth</span>
                    </div>
                    <i class="ri-money-dollar-circle-line text-4xl text-green-500"></i>
                </div>
            </div>

            <!-- Products in Stock -->
            <div class="bg-white p-6 rounded shadow-md hover:shadow-lg transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Products in Stock</p>
                        <h2 class="text-3xl font-bold mt-1">320</h2>
                        <span class="text-xs text-yellow-600">15 low stock alerts</span>
                    </div>
                    <i class="ri-box-3-line text-4xl text-indigo-500"></i>
                </div>
            </div>

            <!-- Total Checkout -->
            <div class="bg-white p-6 rounded shadow-md hover:shadow-lg transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Checkouts</p>
                        <h2 class="text-3xl font-bold mt-1">980</h2>
                        <span class="text-xs text-red-600">-3% this week</span>
                    </div>
                    <i class="ri-bank-card-line text-4xl text-orange-500"></i>
                </div>
            </div>
        </div>

        <!-- Sales Chart + Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <!-- Sales Overview -->
            <div class="lg:col-span-2 bg-white rounded p-6 shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-lg">Sales Overview</h2>
                    <button class="text-sm text-blue-600 hover:underline">View Details</button>
                </div>
                <div
                    class="h-64 flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-200 rounded-xl">
                    <i class="ri-line-chart-line text-5xl mb-2"></i>
                    <p>Chart Placeholder (Sales Trends)</p>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded p-6 shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-lg">Top Selling Products</h2>
                    <button class="text-sm text-blue-600 hover:underline">See All</button>
                </div>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <div class="flex items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="Product"
                                class="w-10 h-10 rounded-md object-cover">
                            <div>
                                <p class="font-medium">Wireless Earbuds</p>
                                <p class="text-xs text-gray-500">Sold: 320</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-medium">$4,560</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <div class="flex items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="Product"
                                class="w-10 h-10 rounded-md object-cover">
                            <div>
                                <p class="font-medium">Smartwatch</p>
                                <p class="text-xs text-gray-500">Sold: 280</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-medium">$3,200</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <img src="https://via.placeholder.com/40" alt="Product"
                                class="w-10 h-10 rounded-md object-cover">
                            <div>
                                <p class="font-medium">Bluetooth Speaker</p>
                                <p class="text-xs text-gray-500">Sold: 190</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-medium">$2,480</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded p-6 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">Recent Orders</h2>
                <button class="text-sm text-blue-600 hover:underline">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-600">
                            <th class="py-3 px-2">Order ID</th>
                            <th class="py-3 px-2">Customer</th>
                            <th class="py-3 px-2">Total</th>
                            <th class="py-3 px-2">Payment</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-2 font-medium">#10245</td>
                            <td class="py-3 px-2">John Doe</td>
                            <td class="py-3 px-2">$120.00</td>
                            <td class="py-3 px-2">Stripe</td>
                            <td class="py-3 px-2"><span class="text-green-600 font-semibold">Completed</span></td>
                            <td class="py-3 px-2 text-right text-gray-500">Oct 11, 2025</td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-2 font-medium">#10246</td>
                            <td class="py-3 px-2">Sarah Lee</td>
                            <td class="py-3 px-2">$85.00</td>
                            <td class="py-3 px-2">PayPal</td>
                            <td class="py-3 px-2"><span class="text-yellow-600 font-semibold">Pending</span></td>
                            <td class="py-3 px-2 text-right text-gray-500">Oct 10, 2025</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-2 font-medium">#10247</td>
                            <td class="py-3 px-2">David Kim</td>
                            <td class="py-3 px-2">$99.00</td>
                            <td class="py-3 px-2">Cash</td>
                            <td class="py-3 px-2"><span class="text-red-600 font-semibold">Cancelled</span></td>
                            <td class="py-3 px-2 text-right text-gray-500">Oct 9, 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
