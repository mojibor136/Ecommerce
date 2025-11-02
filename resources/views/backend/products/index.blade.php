@extends('backend.layouts.app')
@section('title', 'Products Management')
@section('content')
    <div class="w-full mb-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Products Management</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your products efficiently</p>
            </div>
            <div class="flex flex-row gap-2 mt-3 md:mt-0 w-full md:w-auto items-start sm:items-center">
                <a href="{{ route('admin.products.create') }}"
                    class="flex items-center gap-2 h-10 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md shadow font-medium transition-all duration-200">
                    <i class="ri-add-line text-lg"></i> Add Products
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.products.index') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">

                <!-- Search Input -->
                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search SKU..."
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200" />

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                        <i class="ri-search-line"></i>
                    </span>
                </div>

                <!-- Category Filter -->
                <select name="category_id" id="categoryFilter"
                    class="w-full sm:w-1/2 rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                    <option value="">-- All Categories --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Subcategory Filter -->
                <select name="subcategory_id" id="subcategoryFilter"
                    class="w-full sm:w-1/2 rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
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

            <!-- Reset Button -->
            <a href="{{ route('admin.products.index') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Products Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Image</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Name</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">SKU</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Stock</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Price (New)</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Variants</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($products as $index => $product)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 text-center whitespace-nowrap">{{ $products->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">
                                @if ($product->images && $product->images->first())
                                    <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-10 h-10 rounded object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                        N/A
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">
                                @if ($product->hot_deal == 1)
                                    <i class="ri-fire-fill text-orange-500"></i>
                                @else
                                    <i class="ri-checkbox-blank-circle-line text-gray-400" title="Normal Product"></i>
                                @endif
                                {{ Str::limit($product->name, 20) }}
                            </td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center">
                                    <div class="w-12 h-6 rounded bg-gray-500 text-white flex justify-center items-center">
                                        {{ $product->stock }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">৳
                                {{ number_format($product->new_price, 2) }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center">
                                    <div class="w-12 h-6 rounded bg-blue-500 text-white flex justify-center items-center">
                                        {{ $product->variants->count() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if ($product->status)
                                    <span class="px-2 py-1.5 rounded bg-green-500 text-white text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1.5 rounded bg-red-500 text-white text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="inline-flex items-center justify-center w-20 h-8 bg-blue-500 hover:bg-blue-600 text-white rounded shadow text-sm">
                                        <i class="ri-edit-2-line mr-1"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-24 h-8 bg-red-500 hover:bg-red-600 text-white rounded shadow text-sm">
                                            <i class="ri-delete-bin-6-line mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="8" class="py-4 px-3 text-center text-gray-400">No products found.</td>
                        </tr>
                    @endif
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
