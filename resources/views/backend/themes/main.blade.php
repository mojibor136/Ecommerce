@extends('backend.layouts.app')
@section('title', 'Main Theme')
@section('content')

    <style>
        .color-input {
            width: 100%;
            height: 42px;
            border-radius: 4px;
            border: none;
            padding: 0;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            overflow: hidden;
            background: transparent;
        }

        /* Remove default color UI completely */
        .color-input::-webkit-color-swatch-wrapper {
            padding: 0;
            border: none;
        }

        .color-input::-webkit-color-swatch {
            border: none;
            border-radius: 4px;
        }

        .color-input::-moz-color-swatch {
            border: none;
            border-radius: 4px;
        }
    </style>

    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Theme Customize </h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> /
                    Theme / Main
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    Dashboard
                </a>
            </div>
        </div>

        <form action="{{ route('admin.main.theme.update') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-lg space-y-6">
            @csrf

            <!-- Theme Color -->
            <div class="flex flex-col gap-2 bg-gray-50 p-4 rounded-lg shadow-inner">
                <label class="text-gray-700 font-medium">Theme Color</label>
                <input type="color" id="theme_bg" name="theme_bg" value="{{ $theme->theme_bg ?? '#f5f5f5' }}"
                    class="color-input">
            </div>

            <!-- Theme Hover Color -->
            <div class="flex flex-col gap-2 bg-gray-50 p-4 rounded-lg shadow-inner">
                <label class="text-gray-700 font-medium">Theme Hover</label>
                <input type="color" id="theme_hover" name="theme_hover" value="{{ $theme->theme_hover ?? '#e2e2e2' }}"
                    class="color-input">
            </div>

            <!-- Text Color -->
            <div class="flex flex-col gap-2 bg-gray-50 p-4 rounded-lg shadow-inner">
                <label class="text-gray-700 font-medium">Theme Text</label>
                <input type="color" id="theme_text" name="theme_text" value="{{ $theme->theme_text ?? '#333333' }}"
                    class="color-input">
            </div>

            <div class="text-left">
                <button type="submit"
                    class="bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] px-6 py-2.5 w-full rounded-md transition duration-300 font-medium">
                    Save Theme
                </button>
            </div>

        </form>
    </div>

@endsection
