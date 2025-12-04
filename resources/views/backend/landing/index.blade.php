@extends('backend.layouts.app')
@section('title', 'Campaign Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">Campaign Management</h1>
                <p class="text-sm text-gray-500 ml-1">Manage your landing efficiently</p>
            </div>
            <div class="flex flex-row gap-2 mt-3 md:mt-0 w-full md:w-auto items-start sm:items-center">
                <a href="{{ route('admin.landing.create') }}"
                    class="flex items-center gap-2 h-10 bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] px-5 py-2 rounded-md shadow font-medium transition-all duration-200">
                    <i class="ri-add-line text-lg"></i> Add Campaign
                </a>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Campaign Title</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($landing as $index => $page)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 text-left">
                                {{ $page->campaign_title }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($page->status)
                                    <span class="px-2 py-1.5 rounded bg-green-500 text-white text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1.5 rounded bg-red-500 text-white text-xs">Inactive</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">
                                    <!-- Show -->
                                    <a href="{{ route('campaign', ['slug' => $page->campaign_slug]) }}"
                                        class="relative group inline-flex items-center justify-center w-9 h-9 bg-green-500 hover:bg-green-600 text-white rounded-full shadow transition-all duration-200">
                                        <i class="ri-eye-line text-md"></i>
                                        <span
                                            class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow">
                                            View
                                        </span>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.landing.edit', $page->id) }}"
                                        class="relative group inline-flex items-center justify-center w-9 h-9 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition-all duration-200">
                                        <i class="ri-edit-2-line text-md"></i>
                                        <span
                                            class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow">Edit</span>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.landing.destroy', $page->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative group inline-flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition-all duration-200">
                                            <i class="ri-delete-bin-6-line text-md"></i>
                                            <span
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 group-hover:scale-100 transition-transform duration-200 bg-gray-800 text-white text-xs px-2 py-1 rounded shadow">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($landing->isEmpty())
                        <tr>
                            <td colspan="4" class="py-4 px-3 text-center text-gray-400">No campaign found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($landing->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($landing->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $landing->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($landing->hasMorePages())
                    <a href="{{ $landing->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
