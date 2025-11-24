@extends('backend.layouts.app')
@section('title', 'Payment Gateways API')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Gateways API</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Payment Gateway / Create
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Bkash -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3" style="background-color: #E2136E;">
                        <span class="text-white text-xl font-semibold">Bkash</span>
                        <img src="https://www.logo.wine/a/logo/BKash/BKash-Icon-Logo.wine.svg" alt="Bkash Logo"
                            class="h-8 w-auto">
                    </div>

                    <form autocomplete="off" action="{{ route('admin.payment_gateways.store') }}" method="POST"
                        enctype="multipart/form-data" class="grid grid-cols-1 gap-3 px-4 py-4">
                        @csrf

                        <!-- Hidden fake fields to prevent browser autofill -->
                        <input type="text" name="fakeusernameremembered" style="display:none">
                        <input type="password" name="fakepasswordremembered" style="display:none">

                        <input type="hidden" value="bkash" name="type">

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Number</label>
                            <input type="text" name="number" placeholder="Enter Number"
                                value="{{ old('number', $bkash->number ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">App Key</label>
                            <input type="text" name="app_key" placeholder="Enter App Key"
                                value="{{ old('app_key', $bkash->app_key ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">App Secret</label>
                            <input type="text" name="app_secret" placeholder="Enter App Secret"
                                value="{{ old('app_secret', $bkash->app_secret ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Base URL</label>
                            <input type="url" name="base_url" placeholder="Enter Base URL"
                                value="{{ old('base_url', $bkash->base_url ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Username</label>
                            <input type="text" name="username" placeholder="Enter Username"
                                value="{{ old('username', $bkash->username ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Password</label>
                            <input type="password" name="password" placeholder="Enter Password"
                                value="{{ old('password', $bkash->password ?? '') }}" autocomplete="new-password"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <label for="payment" class="block text-md text-gray-600 font-medium">Payment Type</label>
                        <select id="option" name="option"
                            class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                            <option value="auto" {{ old('option', $bkash->option ?? '') == 'auto' ? 'selected' : '' }}>
                                Auto</option>
                            <option value="manual" {{ old('option', $bkash->option ?? '') == 'manual' ? 'selected' : '' }}>
                                Manually</option>
                        </select>

                        <div class="flex items-center justify-between">
                            <label class="text-gray-600 font-medium">Enable Bkash</label>
                            <input type="checkbox" name="status"
                                class="toggle-checkbox h-5 w-8 rounded-full bg-gray-300 checked:bg-[#FF6F00] transition duration-200"
                                {{ old('status', $bkash->status ?? 0) ? 'checked' : '' }}>
                        </div>

                        <div class="mt-3">
                            <button type="submit"
                                class="w-full rounded-md bg-[#E2136E] hover:bg-[#c40e5d] text-white py-2.5 font-medium transition-all">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Nagad -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3" style="background-color: #F7941E;">
                        <span class="text-white text-xl font-semibold">Nagad</span>
                        <img src="https://www.bssnews.net/assets/news_photos/2022/02/04/image-42525-1643965434.jpg"
                            alt="Nagad Logo" class="h-8 w-auto">
                    </div>

                    <form autocomplete="off" action="{{ route('admin.payment_gateways.store') }}" method="POST"
                        enctype="multipart/form-data" class="grid grid-cols-1 gap-3 px-4 py-4">
                        @csrf

                        <!-- Hidden fake fields to prevent browser autofill -->
                        <input type="text" name="fakeusernameremembered" style="display:none">
                        <input type="password" name="fakepasswordremembered" style="display:none">

                        <input type="hidden" value="nagad" name="type">

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Number</label>
                            <input type="text" name="number" placeholder="Enter Number"
                                value="{{ old('number', $nagad->number ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">App Key</label>
                            <input type="text" name="app_key" placeholder="Enter App Key"
                                value="{{ old('app_key', $nagad->app_key ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">App Secret</label>
                            <input type="text" name="app_secret" placeholder="Enter App Secret"
                                value="{{ old('app_secret', $nagad->app_secret ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Base URL</label>
                            <input type="url" name="base_url" placeholder="Enter Base URL"
                                value="{{ old('base_url', $nagad->base_url ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Username</label>
                            <input type="text" name="username" placeholder="Enter Username"
                                value="{{ old('username', $nagad->username ?? '') }}" autocomplete="off"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Password</label>
                            <input type="password" name="password" placeholder="Enter Password"
                                value="{{ old('password', $nagad->password ?? '') }}" autocomplete="new-password"
                                class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                        </div>

                        <label for="payment" class="block text-md text-gray-600 font-medium">Payment Type</label>
                        <select id="option" name="option"
                            class="w-full rounded-md text-gray-700 border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                            <option value="auto" {{ old('option', $nagad->option ?? '') == 'auto' ? 'selected' : '' }}>
                                Auto</option>
                            <option value="manual"
                                {{ old('option', $nagad->option ?? '') == 'manual' ? 'selected' : '' }}>Manually</option>
                        </select>

                        <div class="flex items-center justify-between">
                            <label class="text-gray-600 font-medium">Enable Nagad</label>
                            <input type="checkbox" name="status"
                                class="toggle-checkbox h-5 w-8 rounded-full bg-gray-300 checked:bg-[#FF6F00] transition duration-200"
                                {{ old('status', $nagad->status ?? 0) ? 'checked' : '' }}>
                        </div>

                        <div class="mt-3">
                            <button type="submit"
                                class="w-full rounded-md bg-[#F7941E] hover:bg-[#dd7e10] text-white py-2.5 font-medium transition-all">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
