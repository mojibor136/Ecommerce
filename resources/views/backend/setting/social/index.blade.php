@extends('backend.layouts.app')
@section('title', 'Social Media Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Social Media Management</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your social media links efficiently</p>
            </div>
            <div class="flex flex-row gap-2 mt-3 md:mt-0 w-full md:w-auto items-start sm:items-center">
                <a href="{{ route('admin.social_media.create') }}"
                    class="flex items-center gap-2 h-10 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md shadow font-medium transition-all duration-200">
                    <i class="ri-add-line text-lg"></i> Add Social Media
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('admin.social_media.index') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">

                <!-- Search Input -->
                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search social media..."
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200" />

                    <!-- Search Icon -->
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
                        <i class="ri-search-line"></i>
                    </span>
                </div>

                <!-- Search Button -->
                <button type="submit"
                    class="flex justify-center items-center px-4 py-2 h-10 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                    <i class="ri-search-line mr-1"></i> Search
                </button>
            </div>

            <!-- Reset Button -->
            <a href="{{ route('admin.social_media.index') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Social Media Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Link</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @forelse ($socials as $index => $social)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $social->name }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ $social->link }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $social->link }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if ($social->status)
                                    <span class="px-2 py-1.5 rounded bg-green-500 text-white">Active</span>
                                @else
                                    <span class="px-2 py-1.5 rounded bg-red-500 text-white">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Edit Social Media -->
                                    <a href="{{ route('admin.social_media.edit', $social->id) }}"
                                        class="relative group inline-flex items-center justify-center w-9 h-9 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition-all duration-200"
                                        title="Edit Social Media">
                                        <i class="ri-edit-2-line text-md"></i>
                                        <span
                                            class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100
                         transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow whitespace-nowrap">
                                            Edit
                                        </span>
                                    </a>

                                    <!-- Delete Social Media -->
                                    <form action="{{ route('admin.social_media.destroy', $social->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this social media?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative group inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition-all duration-200"
                                            title="Delete Social Media">
                                            <i class="ri-delete-bin-6-line text-md"></i>
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
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-3 text-center text-gray-400">No social media found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($socials->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($socials->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $socials->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($socials->hasMorePages())
                    <a href="{{ $socials->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
