@extends('backend.layouts.app')
@section('title', 'Add New Banner')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Banner</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.banners.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    All banners
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Banner /
                    Create
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.banners.index') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    All banners
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Name Dropdown -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Select Name</label>
                    <select name="name"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
            text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                        <option value="">-- Select Name --</option>
                        <option value="main">Main Banner</option>
                        <option value="offer">Offer Banner</option>
                    </select>
                </div>

                <!-- Banner Image -->
                <div class="flex flex-col col-span-2">
                    <label for="image" class="text-sm font-medium text-gray-700 mb-1">Banner Image <span
                            class="text-red-500">*</span></label>
                    <input type="file" name="image" id="image"
                        class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500
           file:bg-indigo-600 file:text-white file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
           hover:file:bg-indigo-700 transition-all duration-200"
                        accept="image/*" required>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Image Preview -->
                    <div id="previewContainer" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-1">Preview:</p>
                        <img id="previewImage" src="#" alt="Banner Preview"
                            class="w-40 h-24 object-cover rounded border border-gray-200 shadow-sm">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 md:col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed 
                        text-white py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS for Slug Auto Generation -->
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    </script>
@endsection
