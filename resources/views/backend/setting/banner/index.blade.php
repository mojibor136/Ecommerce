@extends('backend.layouts.app')
@section('title', 'Banner Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-3 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Banner Management</h1>
                <p class="text-sm text-gray-500">Manage your banners efficiently</p>
            </div>
            <div class="flex flex-row gap-2 mt-3 md:mt-0 w-full md:w-auto items-start sm:items-center">
                <a href="{{ route('admin.banners.create') }}"
                    class="flex items-center gap-2 h-10 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md shadow font-medium transition-all duration-200">
                    <i class="ri-add-line text-lg"></i> Add Banner
                </a>
            </div>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('admin.banners.index') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">

                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search banners..."
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200" />

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                        <i class="ri-search-line"></i>
                    </span>
                </div>

                <button type="submit"
                    class="flex justify-center items-center px-4 py-2 h-10 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                    <i class="ri-search-line mr-1"></i> Search
                </button>
            </div>

            <a href="{{ route('admin.banners.index') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Banner Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left">Banner Name</th>
                        <th class="px-4 py-3 text-left">Banner Image</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-200 capitalize">
                    @foreach ($banners as $index => $banner)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $banner->name }} banner</td>
                            <td class="px-4 py-3">
                                @if ($banner->image)
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->name }}"
                                        class="w-20 h-12 rounded object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-20 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                        N/A
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Delete Banner -->
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative group inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition-all duration-200"
                                            title="Delete Banner">
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
                    @if ($banners->isEmpty())
                        <tr>
                            <td colspan="4" class="py-4 px-3 text-center text-gray-400">No banners found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($banners->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($banners->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $banners->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($banners->hasMorePages())
                    <a href="{{ $banners->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
