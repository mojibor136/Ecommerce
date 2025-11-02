@extends('backend.layouts.app')
@section('title', 'Edit Attribute Value')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Attribute Value</h2>
                <!-- Small Screen Button -->
                <a href="{{ route('admin.attribute_values.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    All Attribute Values
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> /
                    <a href="{{ route('admin.attribute_values.index') }}" class="text-blue-600 hover:underline">Attribute
                        Values</a> / Edit
                </p>
                <!-- Large Screen Button -->
                <a href="{{ route('admin.attribute_values.index') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    All Attribute Values
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.attribute_values.update', $value->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <!-- Attribute Selection -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Select Attribute</label>
                    <select name="attribute_id" required
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                        <option value="">-- Select Attribute --</option>
                        @foreach ($attributes as $attribute)
                            <option value="{{ $attribute->id }}"
                                {{ $value->attribute_id == $attribute->id ? 'selected' : '' }}>
                                {{ $attribute->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Attribute Value -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Value</label>
                    <input type="text" name="value" placeholder="Attribute Value" value="{{ $value->value }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <!-- Color Code -->
                <div class="col-span-2 md:col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Color Code (Optional)</label>
                    <input type="text" name="color_code" placeholder="#ffffff" value="{{ $value->color_code }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <!-- Status -->
                <div class="col-span-2 md:col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                        text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                        <option value="1" {{ $value->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $value->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 md:col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed 
                        text-white py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Update Attribute Value
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
