@extends('backend.layouts.app')
@section('title', 'Order by Products')
@section('content')
    <div class="w-full mb-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Order by Products</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your order by products efficiently</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <form method="GET" action="{{ route('admin.order.products') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">
                <!-- Search -->
                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search SKU"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200" />
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                        <i class="ri-search-line"></i>
                    </span>
                </div>

                <!-- Category -->
                <select name="category_id" id="categoryFilter"
                    class="w-full sm:w-1/2 rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    <option value="">-- All Categories --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Subcategory -->
                <select name="subcategory_id" id="subcategoryFilter"
                    class="w-full sm:w-1/2 rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    <option value="">-- All Subcategories --</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Search Button -->
                <button type="submit"
                    class="flex justify-center items-center px-4 py-2 h-10 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                    <i class="ri-search-line mr-1"></i> Search
                </button>
            </div>

            <!-- Reset -->
            <a href="{{ route('admin.order.products') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Order by Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">#</th>
                        <th class="px-4 py-3 text-left w-14">Image</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Category</th>
                        <th class="px-4 py-3 text-right w-40">Order by Serial</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @forelse ($products as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $products->firstItem() + $index }}</td>

                            <td class="px-4 py-2">
                                @if ($product->images->first())
                                    <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                        class="w-10 h-10 rounded object-cover border">
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-200 flex items-center justify-center text-gray-500 text-xs rounded">
                                        N/A
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-2 font-medium">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->category->name ?? 'N/A' }}</td>

                            <td class="px-4 py-2 text-right">
                                <form action="{{ route('admin.products.updateOrders') }}" method="POST"
                                    class="flex justify-end gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="category_id" value="{{ $product->category_id }}">

                                    <input type="number" name="orders[{{ $product->id }}]"
                                        value="{{ $product->orders }}" min="0" placeholder="Enter Serial"
                                        class="w-14 md:w-24 border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                        required>

                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1.5 rounded">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($products->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
