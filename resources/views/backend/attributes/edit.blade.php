@extends('backend.layouts.app')
@section('title', 'Edit Attribute')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Attribute</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.attributes.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:[{{ $theme->theme_hover }}] transition">
                    All Attributes
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Attribute / Edit
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.attributes.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-base font-medium hover:[{{ $theme->theme_hover }}] transition">
                    All Attributes
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <!-- Attribute Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Attribute Name</label>
                    <input type="text" id="attributeName" name="name" placeholder="Attribute Name"
                        value="{{ old('name', $attribute->name) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Slug -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Slug</label>
                    <input type="text" id="attributeSlug" name="slug" placeholder="attribute-slug"
                        value="{{ old('slug', $attribute->slug) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Status -->
                <div class="col-span-2 md:col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="1" {{ old('status', $attribute->status) == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status', $attribute->status) == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 md:col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] disabled:opacity-60 disabled:cursor-not-allowed 
                        py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Update Attribute
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS for Slug Auto Generation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('attributeName');
            const slugInput = document.getElementById('attributeSlug');

            nameInput.addEventListener('input', function() {
                let slug = this.value.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                slugInput.value = slug;
            });
        });
    </script>
@endsection
