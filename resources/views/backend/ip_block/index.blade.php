@extends('backend.layouts.app')
@section('title', 'IP Management')
@section('content')
    <div class="w-full mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b rounded-md mb-4">
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <h1 class="text-xl font-bold text-gray-800">IP Management</h1>
                <p class="text-sm text-gray-500 ml-1">Manage blocked IPs efficiently</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('admin.ip_block.index') }}"
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2 sm:gap-4">

            <div class="flex flex-col sm:flex-row w-full sm:w-2/3 gap-2">
                <!-- Search Input -->
                <div class="relative w-full sm:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search IPs..."
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 pl-10 pr-3 py-2
                    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200" />
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
            <a href="{{ route('admin.ip_block.index') }}"
                class="flex justify-center items-center px-4 py-2 h-10 md:w-auto w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white font-medium transition-all duration-150 mt-2 sm:mt-0">
                Reset
            </a>
        </form>

        <!-- Blocked IP Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">IP Address</th>
                        <th class="px-4 py-3 text-left">User Agent</th>
                        <th class="px-4 py-3 text-left">Reason</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Blocked At</th>
                        <th class="px-4 py-3 text-right pr-8">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @forelse ($blockedIps as $index => $ip)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $ip->ip_address }}</td>
                            <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($ip->user_agent, 60) }}</td>
                            <td class="px-4 py-3">{{ $ip->reason }}</td>
                            <td class="px-4 py-3 text-center">{{ $ip->created_at->format('d M, Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.ip_block.destroy', $ip->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to unblock this IP?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow text-sm">
                                        <i class="ri-delete-bin-6-line mr-1"></i> Unblock
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-3 text-center text-gray-400">No blocked IPs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($blockedIps->hasPages())
            <div class="mt-4 flex justify-end gap-2">
                @if ($blockedIps->onFirstPage())
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $blockedIps->previousPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                @if ($blockedIps->hasMorePages())
                    <a href="{{ $blockedIps->nextPageUrl() }}"
                        class="px-4 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>
@endsection
