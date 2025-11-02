@extends('backend.layouts.app')
@section('title', 'Add New Social Media')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Social Media</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.social_media.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    All Social Media
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Social Media /
                    Create
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.social_media.index') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded font-medium hover:bg-indigo-700 transition">
                    All Social Media
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.social_media.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Social Media Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Social Media Name <span
                            class="text-red-500">*</span></label>
                    <select name="name"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-[11px] focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300"
                        required>
                        <option value="">-- Select Social Media --</option>
                        @php
                            $mediaList = [
                                'Facebook',
                                'Twitter',
                                'WhatsApp API',
                                'Instagram',
                                'LinkedIn',
                                'YouTube',
                                'Pinterest',
                            ];
                        @endphp
                        @foreach ($mediaList as $media)
                            <option value="{{ $media }}" {{ old('name') == $media ? 'selected' : '' }}>
                                {{ $media }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Social Media Link -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Link <span
                            class="text-red-500">*</span></label>
                    <input type="url" name="link" placeholder="Enter social media URL" value="{{ old('link') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300"
                        required>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-[11px] focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-3">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 transition-all duration-200">
                        Create Social Media
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
