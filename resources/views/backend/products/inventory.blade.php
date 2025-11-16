@extends('backend.layouts.app')
@section('title', 'Inventory Tracking')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Inventory Tracking</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your products efficiently</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <form method="GET" action="{{ route('admin.products.inventory') }}"
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
            <a href="{{ route('admin.products.inventory') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Inventory Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-center">Stock</th>
                        <th class="px-4 py-3 text-center">Price</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($products as $index => $product)
                        <tr class="bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $products->firstItem() + $index }}</td>
                            <td class="px-4 py-2">
                                @if ($product->images->first())
                                    <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                        class="w-10 h-10 rounded object-cover border">
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                        N/A</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2 text-center {{ $product->stock == 0 ? 'text-red-600 font-bold' : '' }}">
                                {{ $product->stock }}
                            </td>
                            <td class="px-4 py-2 text-center">৳{{ number_format($product->new_price, 2) }}</td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <form action="{{ route('admin.products.updateStock', ['id' => $product->id]) }}"
                                        method="POST" class="flex gap-1 justify-end">
                                        @csrf
                                        <input type="number" name="stock_add" min="1" value=""
                                            placeholder="{{ $product->stock }}"
                                            class="md:w-32 w-20 rounded bg-white text-gray-900 border border-gray-300 px-4 h-8 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                                            required>
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-12 h-8 bg-green-500 hover:bg-green-600 
               text-white rounded shadow transition-all duration-200 relative group"
                                            title="Add Stock">
                                            <i class="ri-add-fill text-lg"></i>

                                            <span
                                                class="absolute bottom-12 scale-0 group-hover:scale-100 transition-all duration-200
                   bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                                Add Stock
                                            </span>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 
               text-white rounded-full shadow transition-all duration-200 relative group"
                                            title="Delete Product">
                                            <i class="ri-delete-bin-6-line text-md"></i>

                                            <span
                                                class="absolute bottom-12 scale-0 group-hover:scale-100 transition-all duration-200
                   bg-gray-800 text-white text-xs px-2 py-1 rounded shadow">
                                                Delete
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @foreach ($product->variants as $variant)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 text-center"></td>
                                <td class="px-4 py-2">
                                    @if ($variant->images->first())
                                        <img src="{{ asset('uploads/products/variants/' . $variant->images->first()->image) }}"
                                            class="w-10 h-10 rounded object-cover border">
                                    @else
                                        <div
                                            class="w-10 h-10 bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                            N/A
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $product->name }}
                                    @if ($variant->attributes && is_array($variant->attributes))
                                        <span class="text-xs text-gray-500 ml-1">
                                            —
                                            {{ collect($variant->attributes)->pluck('values')->flatten()->implode(', ') }}
                                        </span>
                                    @endif
                                </td>
                                <td
                                    class="px-4 py-2 text-center {{ $variant->stock == 0 ? 'text-red-600 font-bold' : '' }}">
                                    {{ $variant->stock }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    ৳{{ number_format($variant->new_price ?? $product->new_price, 2) }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <form
                                            action="{{ route('admin.products.updateStock', ['id' => $product->id, 'variantId' => $variant->id]) }}"
                                            method="POST" class="flex gap-1 justify-end items-center">
                                            @csrf

                                            <input type="number" name="stock_add" min="1" value=""
                                                placeholder="{{ $variant->stock }}"
                                                class="md:w-32 w-20 rounded bg-white text-gray-900 border border-gray-300 px-4 h-9 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200"
                                                required>

                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-12 h-9 bg-green-500 hover:bg-green-600 
               text-white rounded shadow transition-all duration-200 relative group"
                                                title="Add Stock">
                                                <i class="ri-add-fill text-lg"></i>

                                                <span
                                                    class="absolute bottom-12 scale-0 group-hover:scale-100 transition-all duration-200
                   bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                                    Add Stock
                                                </span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.products.variant.destroy', $variant->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this variant?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-10 h-10 bg-red-500 hover:bg-red-600 
                       text-white rounded-full shadow transition-all duration-200 relative group"
                                                title="Delete Variant">
                                                <i class="ri-delete-bin-6-line text-lg"></i>

                                                <span
                                                    class="absolute bottom-12 scale-0 group-hover:scale-100 transition-all duration-200
                           bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                                    Delete
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
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
