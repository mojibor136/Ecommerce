@extends('backend.layouts.app')
@section('title', 'Edit Social Media')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Social Media</h2>

                <!-- Small Screen Button -->
                <a href="{{ route('admin.social_media.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Social Media
                </a>
            </div>

            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    <a href="{{ route('admin.social_media.index') }}"
                        class="text-[{{ $theme->theme_bg }}] hover:underline">Social Media</a>
                    /
                    Edit
                </p>

                <!-- Large Screen Button -->
                <a href="{{ route('admin.social_media.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Social Media
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.social_media.update', $social->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <!-- Social Media Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">
                        Social Media Name <span class="text-red-500">*</span>
                    </label>
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
                    <select name="name"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-[11px] focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all border-gray-300"
                        required>
                        <option value="">-- Select Social Media --</option>
                        @foreach ($mediaList as $media)
                            <option value="{{ $media }}"
                                {{ old('name', $social->name) == $media ? 'selected' : '' }}>
                                {{ $media }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Social Media Link -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Link <span
                            class="text-red-500">*</span></label>
                    <input type="url" name="link" placeholder="Enter social media URL"
                        value="{{ old('link', $social->link) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-2 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all border-gray-300"
                        required>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 py-[11px] focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all border-gray-300">
                        <option value="1" {{ old('status', $social->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $social->status) == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-3">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 transition-all duration-200">
                        Update Social Media
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
