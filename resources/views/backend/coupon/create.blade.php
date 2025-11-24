@extends('backend.layouts.app')
@section('title', 'Add New Coupon')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Add New Coupon</h2>

                <!-- Small Screen Button -->
                <a href="{{ route('admin.coupons.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Coupons
                </a>
            </div>

            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Coupons Create
                </p>

                <!-- Large Screen Button -->
                <a href="{{ route('admin.coupons.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Coupons
                </a>
            </div>
        </div>

        <!-- Coupon Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.coupons.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Coupon Code -->
                <div>
                    <label for="code" class="block text-md text-gray-700 mb-1 font-medium">Coupon Code <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" placeholder="Enter coupon code (e.g. OFFER50)"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all"
                        required>
                </div>

                <!-- Discount Type -->
                <div>
                    <label for="type" class="block text-md text-gray-700 mb-1 font-medium">Discount Type</label>
                    <select name="type" id="type"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2.5 text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount (৳)</option>
                    </select>
                </div>

                <!-- Discount Value -->
                <div>
                    <label for="value" class="block text-md text-gray-700 mb-1 font-medium">Discount Value <span
                            class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="value" id="value" placeholder="Enter discount value"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        required>
                </div>

                <!-- Minimum Purchase -->
                <div>
                    <label for="min_purchase" class="block text-md text-gray-700 mb-1 font-medium">Minimum Purchase
                        (৳)</label>
                    <input type="number" step="0.01" name="min_purchase" id="min_purchase" placeholder="Optional"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Apply on Category -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Apply To Category</label>
                    <select name="category"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-[12px] text-sm sm:text-base focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-md text-gray-700 mb-1 font-medium">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-md text-gray-700 mb-1 font-medium">Status</label>
                    <select name="status" id="status"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-[12px] text-sm sm:text-base focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-3">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 text-sm sm:text-base transition-all duration-200">
                        Create Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
