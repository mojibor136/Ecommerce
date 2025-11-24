@extends('backend.layouts.app')
@section('title', 'Shipping Charge')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 gap-3">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-800">Shipping Charge</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition sm:hidden">
                    Dashboard
                </a>
            </div>

            <div class="flex flex-wrap justify-between items-center text-gray-600 text-sm gap-2">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    <span>Shipping Charge</span>
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden sm:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Shipping Charge Form -->
        <div class="w-full bg-white rounded shadow px-4 md:px-6 py-6">
            <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                <div
                    class="flex flex-row justify-between items-start sm:items-center px-4 py-3 bg-[{{ $theme->theme_bg }}] gap-2">
                    <span class="text-white text-xl font-semibold">Shipping Charge</span>
                    <i class="ri-truck-fill text-3xl text-white"></i>
                </div>

                <form action="{{ route('admin.shipping.store') }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 px-4 py-4">
                    @csrf

                    <!-- Inside Dhaka -->
                    <div>
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">
                            Inside Dhaka (৳) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="in_dhaka" placeholder="Enter charge for inside Dhaka"
                            value="{{ old('in_dhaka', $shipping['in_dhaka']) }}" step="0.01" min="0"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900
                           focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all"
                            required>
                    </div>

                    <!-- Outside Dhaka -->
                    <div>
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">
                            Outside Dhaka (৳) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="out_dhaka" placeholder="Enter charge for outside Dhaka"
                            value="{{ old('out_dhaka', $shipping['out_dhaka']) }}" step="0.01" min="0"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900
                           focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] outline-none transition-all"
                            required>
                    </div>

                    <!-- Submit -->
                    <div class="col-span-1 md:col-span-2 mt-3">
                        <button type="submit"
                            class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 font-medium transition-all">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
