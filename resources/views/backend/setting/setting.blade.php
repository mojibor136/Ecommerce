@extends('backend.layouts.app')
@section('title', 'General Setting')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-800 mb-0">General Setting</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>

            <div class="flex flex-wrap justify-between items-center text-gray-600 text-sm mt-2">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    <span>General Setting</span>
                </p>
            </div>
        </div>

        <!-- Setting Form -->
        <div class="w-full bg-white rounded shadow px-4 md:px-6 py-6">
            <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                <div
                    class="flex flex-row justify-between items-start sm:items-center px-4 py-3 bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  gap-2">
                    <span class="text-[{{ $theme->theme_text }}] text-xl font-semibold">Website Information</span>
                    <i class="ri-settings-4-fill text-3xl text-[{{ $theme->theme_text }}]"></i>
                </div>

                <form action="{{ route('admin.setting.store') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 px-4 py-4">
                    @csrf

                    <!-- Website Headline -->
                    <div class="col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Website Headline</label>
                        <input type="text" name="headline" placeholder="Enter website headline"
                            value="{{ old('headline', $setting->headline ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300"
                            required>
                    </div>

                    <!-- Website Name -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Website Name</label>
                        <input type="text" name="name" placeholder="Enter website name"
                            value="{{ old('name', $setting->name ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300"
                            required>
                    </div>

                    <!-- Support Phone -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Support Phone</label>
                        <input type="number" name="phone" placeholder="+45 71421852"
                            value="{{ old('phone', $setting->phone ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Support Email -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Support Email</label>
                        <input type="email" name="email" placeholder="Enter support email"
                            value="{{ old('email', $setting->email ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Facebook Page -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Facebook Page</label>
                        <input type="text" name="facebook" placeholder="Enter Facebook page URL"
                            value="{{ old('facebook', $setting->facebook ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
              text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- WhatsApp Number -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">WhatsApp Number</label>
                        <input type="tel" name="whatsapp" placeholder="+8801XXXXXXXXX"
                            value="{{ old('whatsapp', $setting->whatsapp ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
              text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Brand Name -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Brand Name</label>
                        <input type="text" name="brand" placeholder="Enter brand name"
                            value="{{ old('brand', $setting->brand ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Meta Title -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Meta Title</label>
                        <input type="text" name="meta_title" placeholder="Enter meta title"
                            value="{{ old('meta_title', $setting->meta_title ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Address -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Address</label>
                        <input type="text" name="address" placeholder="Enter address"
                            value="{{ old('address', $setting->address ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Open Time -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Open Time</label>
                        <input type="text" name="open_time" placeholder="Enter open time"
                            value="{{ old('open_time', $setting->open_time ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
              text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Meta Tags -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Meta Tags</label>
                        @php
                            $metaTags = [];
                            if (!empty($setting->meta_tag)) {
                                $decoded = json_decode($setting->meta_tag, true);
                                if (is_array($decoded)) {
                                    $metaTags = array_map('trim', $decoded);
                                }
                            }
                        @endphp
                        <input type="text" name="meta_tag" placeholder="e.g. ecommerce, online store"
                            value="{{ old('meta_tag', implode(', ', $metaTags)) }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Meta Description -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Meta Description</label>
                        <textarea name="meta_desc" rows="3" placeholder="Enter meta description"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                     text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">{{ old('meta_desc', $setting->meta_desc ?? '') }}</textarea>
                    </div>

                    <!-- Footer Text -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Footer Text</label>
                        <textarea name="footer" rows="3" placeholder="Enter footer content"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                     text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">{{ old('footer', $setting->footer ?? '') }}</textarea>
                    </div>

                    <!-- Website Logo -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Website Logo</label>
                        <input type="file" name="icon"
                            class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
                                  file:bg-[{{ $theme->theme_bg }}] file:text-[{{ $theme->theme_text }}] file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
                                  hover:file:bg-[{{ $theme->theme_hover }}] transition-all duration-200">
                        @if (!empty($setting->icon))
                            <img src="{{ asset($setting->icon) }}" class="h-12 mt-2 rounded" alt="icon">
                        @endif
                    </div>

                    <!-- Favicon -->
                    <div class="w-full">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Favicon</label>
                        <input type="file" name="favicon"
                            class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
                                  file:bg-[{{ $theme->theme_bg }}] file:text-[{{ $theme->theme_text }}] file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
                                  hover:file:bg-[{{ $theme->theme_hover }}] transition-all duration-200">
                        @if (!empty($setting->favicon))
                            <img src="{{ asset($setting->favicon) }}" class="h-12 mt-2 rounded" alt="favicon">
                        @endif
                    </div>

                    <!-- Hot Deals Date -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-md text-gray-700 mb-1.5 font-medium">Hot Deals Date</label>
                        <input type="date" name="hot_deals" value="{{ old('hot_deals', $setting->hot_deals ?? '') }}"
                            class="w-full rounded-md bg-white text-gray-900 border px-3 py-2
                                  text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                    </div>

                    <!-- Submit -->
                    <div class="col-span-1 md:col-span-2 mt-3">
                        <button type="submit"
                            class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 font-medium transition-all">
                            Save Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
