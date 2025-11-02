@extends('backend.layouts.app')
@section('title', 'Add New Category')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Category</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.categories.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    All Categories
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Category /
                    Create
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.categories.index') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    All Categories
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Category Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Category Name</label>
                    <input type="text" id="categoryName" name="name" placeholder="Category Name"
                        value="{{ old('name') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <!-- Slug -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Slug</label>
                    <input type="text" id="categorySlug" name="slug" placeholder="category-slug"
                        value="{{ old('slug') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <!-- Category Image -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Category Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500
           file:bg-indigo-600 file:text-white file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
           hover:file:bg-indigo-700 transition-all duration-200">
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, JPEG, PNG, WEBP (max 2MB)</p>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 md:col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed 
                        text-white py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS for Slug Auto Generation -->
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
