@extends('backend.layouts.app')
@section('title', 'Edit Category')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Category</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.categories.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Categories
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Category / Edit
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.categories.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-md font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Categories
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Category Name</label>
                    <input type="text" id="categoryName" name="name" placeholder="Category Name"
                        value="{{ old('name', $category->name) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Slug -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Slug</label>
                    <input type="text" id="categorySlug" name="slug" placeholder="category-slug"
                        value="{{ old('slug', $category->slug) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Category Image -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Category Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
           file:bg-[{{ $theme->theme_bg }}] file:text-[{{ $theme->theme_text }}] file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
           hover:file:bg-[{{ $theme->theme_hover }}] transition-all duration-200">
                    @if ($category->image)
                        <div class="mt-3">
                            <p class="text-gray-600 text-sm mb-1">Current Image:</p>
                            <img src="{{ asset($category->image) }}" alt="Category Image"
                                class="w-24 h-24 object-cover rounded border">
                        </div>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, JPEG, PNG, WEBP (max 2MB)</p>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] disabled:opacity-60 disabled:cursor-not-allowed 
                        py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('categoryName');
            const slugInput = document.getElementById('categorySlug');

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
