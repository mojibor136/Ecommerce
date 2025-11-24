@extends('backend.layouts.app')
@section('title', 'Category Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Category Management</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your categories efficiently</p>
            </div>
            <div class="flex flex-row gap-2 mt-3 md:mt-0 w-full md:w-auto items-start sm:items-center">
                <a href="{{ route('admin.categories.create') }}"
                    class="flex items-center gap-2 h-10 bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] px-5 py-2 rounded-md shadow font-medium transition-all duration-200">
                    <i class="ri-add-line text-lg"></i> Add Category
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('admin.categories.index') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">

                <!-- Search Input -->
                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2
                text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200" />

                    <!-- Search Icon -->
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                        <i class="ri-search-line"></i>
                    </span>
                </div>

                <!-- Search Button -->
                <button type="submit"
                    class="flex justify-center items-center px-4 py-2 h-10 rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] font-medium transition-all duration-150 mt-2 sm:mt-0">
                    <i class="ri-search-line mr-1"></i> Search
                </button>
            </div>

            <!-- Reset Button -->
            <a href="{{ route('admin.categories.index') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Category Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Category-Image</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Slug</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Subcategory</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Products</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($categories as $index => $category)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-left whitespace-nowrap flex items-center gap-2">
                                @if ($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                        class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                        N/A
                                    </div>
                                @endif
                                <span>{{ $category->name }}</span>
                            </td>
                            <td class="px-4 py-3 text-left whitespace-nowrap">{{ $category->slug }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center">
                                    <div class="w-12 h-6 rounded bg-gray-500 text-white flex justify-center items-center">
                                        {{ $category->subcategories_count }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center">
                                    <div class="w-12 h-6 rounded bg-gray-500 text-white flex justify-center items-center">
                                        {{ $category->products_count }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if ($category->status)
                                    <span class="px-2 py-1.5 rounded bg-green-500 text-white text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1.5 rounded bg-red-500 text-white text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Edit Category Button -->
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="relative group inline-flex items-center justify-center w-9 h-9 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition-all duration-200"
                                        title="Edit Category">
                                        <i class="ri-edit-2-line text-md"></i>

                                        <!-- Tooltip -->
                                        <span
                                            class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100
                         transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                            Edit
                                        </span>
                                    </a>

                                    <!-- Delete Category Button -->
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative group inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition-all duration-200"
                                            title="Delete Category">
                                            <i class="ri-delete-bin-6-line text-md"></i>

                                            <!-- Tooltip -->
                                            <span
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100
                             transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                                Delete
                                            </span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($categories->isEmpty())
                        <tr>
                            <td colspan="5" class="py-4 px-3 text-center text-gray-400">No categories found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($categories->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($categories->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
