@extends('backend.layouts.app')
@section('title', 'Admin Account')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 gap-3">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-800">Admin Account</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition sm:hidden">
                    Dashboard
                </a>
            </div>

            <div class="flex flex-wrap justify-between items-center text-gray-600 text-sm gap-2">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> / Admin Account
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden sm:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}]  px-4 py-2 rounded font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-4 md:px-6 py-6">
            <form action="{{ route('admin.account.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="password" name="fakepasswordremembered" style="display:none">

                <!-- Name -->
                <div>
                    <label class="block text-md text-gray-700 mb-1 font-medium">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" placeholder="Enter your name"
                        value="{{ old('name', $admin->name) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                       text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300"
                        required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-md text-gray-700 mb-1 font-medium">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" placeholder="Enter your email"
                        value="{{ old('email', $admin->email) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                       text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300"
                        required>
                </div>

                <!-- Profile Image -->
                <div>
                    <label class="block text-md text-gray-700 mb-1 font-medium">Profile Image</label>
                    <input type="file" name="image"
                        class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
                       file:bg-[{{ $theme->theme_bg }}] file:text-[{{ $theme->theme_text }}] file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
                       hover:file:bg-[{{ $theme->theme_hover }}] transition-all duration-200">
                    @if ($admin->image)
                        <img src="{{ asset($admin->image) }}" class="h-16 mt-2 rounded-full" alt="Profile Image">
                    @endif
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-md text-gray-700 mb-1 font-medium">New Password</label>
                    <input type="password" autocomplete="new-password" name="password" placeholder="Enter new password"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                       text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-md text-gray-700 mb-1 font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2
                       text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                </div>

                <!-- Submit Button -->
                <div class="col-span-1 md:col-span-2 mt-3">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 font-medium transition-all">
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
