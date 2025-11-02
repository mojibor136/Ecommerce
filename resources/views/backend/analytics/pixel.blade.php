@extends('backend.layouts.app')
@section('title', 'Pixel Configuration')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pixel Configuration</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    Dashboard
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Analytics /
                    Pixel
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Pixel Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                <div class="flex justify-between items-center px-4 py-3" style="background-color: #3B82F6;">
                    <span class="text-white text-xl font-semibold">Pixel Setup</span>
                    <i class="ri-share-forward-fill text-3xl"></i>
                </div>

                <form action="{{ route('admin.analytics.pixel.store') }}" method="POST"
                    class="grid grid-cols-1 gap-3 px-4 py-4">
                    @csrf

                    <div>
                        <label class="block text-md text-gray-600 mb-1 font-medium">Pixel ID</label>
                        <input type="text" name="key" placeholder="Enter Pixel ID"
                            value="{{ old('key', $pixel?->key) }}"
                            class="w-full rounded-md border border-gray-300 text-gray-700 px-3 py-2 focus:ring-2 focus:ring-[#3B82F6] outline-none transition-all">
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <label class="text-gray-700 font-medium">Enable Pixel</label>
                        <input type="checkbox" name="status" {{ $pixel && $pixel->status ? 'checked' : '' }}
                            class="toggle-checkbox h-5 w-10 rounded-full bg-gray-300 checked:bg-[#3B82F6] transition duration-200">
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                            class="w-full rounded-md bg-[#3B82F6] hover:bg-[#2563eb] text-white py-2.5 font-medium transition-all">
                            {{ $pixel ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>

                @if ($pixel)
                    <div class="px-4 py-4 border-t mt-4 bg-gray-50">
                        <p class="text-gray-700 text-sm mb-1"><strong>Last Updated:</strong>
                            {{ $pixel->updated_at?->format('d M, Y h:i A') ?? '—' }}</p>
                        <p class="text-gray-700 text-sm"><strong>Status:</strong>
                            {{ $pixel->status ? 'Active' : 'Inactive' }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
