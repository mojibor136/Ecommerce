@extends('backend.layouts.app')
@section('title', 'Courier Gateway API')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Courier Gateway API</h2>
                <a href="{{ route('admin.courier.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    Dashboard
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Courier / Create
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Forms -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- PATHAO -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3" style="background-color: #E0002D;">
                        <span class="text-white text-xl font-semibold">Pathao</span>
                        <i class="ri-motorbike-fill text-3xl"></i>
                    </div>

                    <form action="{{ route('admin.courier.store') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-1 gap-3 px-4 py-4">
                        @csrf

                        <input type="hidden" name="type" id="pathao" value="pathao">

                        @foreach (['API Key' => 'api_key', 'Secret Key' => 'secret_key', 'Base URL' => 'url', 'Token' => 'token'] as $label => $name)
                            <div>
                                <label class="block text-md text-gray-600 mb-1 font-medium">{{ $label }}</label>
                                <input type="{{ $name === 'url' ? 'url' : 'text' }}" name="{{ $name }}"
                                    placeholder="Enter {{ $label }}" value="{{ old($name, $pathao?->$name) }}"
                                    class="w-full rounded-md border border-gray-300 text-gray-700 px-3 py-2 focus:ring-2 focus:ring-[#E0002D] outline-none transition-all">
                            </div>
                        @endforeach

                        <!-- Toggle -->
                        <div class="flex items-center justify-between">
                            <label class="text-gray-700 font-medium">Enable Pathao</label>
                            <input type="checkbox" name="status" {{ isset($pathao) && $pathao->status ? 'checked' : '' }}
                                class="toggle-checkbox h-5 w-10 rounded-full bg-gray-300 checked:bg-[#E0002D] transition duration-200">
                        </div>

                        <div class="mt-3">
                            <button type="submit"
                                class="w-full rounded-md bg-[#E0002D] hover:bg-[#c10025] text-white py-2.5 font-medium transition-all">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEADFAST -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3" style="background-color: #10B981;">
                        <span class="text-white text-xl font-semibold">Steadfast</span>
                        <i class="ri-truck-fill text-3xl"></i>
                    </div>

                    <form action="{{ route('admin.courier.store') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-1 gap-3 px-4 py-4">
                        @csrf

                        <input type="hidden" name="type" id="steadfast" value="steadfast">

                        @foreach (['API Key' => 'api_key', 'Secret Key' => 'secret_key', 'Base URL' => 'url', 'Token' => 'token'] as $label => $name)
                            <div>
                                <label class="block text-md text-gray-600 mb-1 font-medium">{{ $label }}</label>
                                <input type="{{ $name === 'url' ? 'url' : 'text' }}" name="{{ $name }}"
                                    placeholder="Enter {{ $label }}" value="{{ old($name, $steadfast?->$name) }}"
                                    class="w-full rounded-md border border-gray-300 text-gray-700 px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                            </div>
                        @endforeach

                        <!-- Toggle -->
                        <div class="flex items-center justify-between">
                            <label class="text-gray-700 font-medium">Enable Steadfast</label>
                            <input type="checkbox" name="status"
                                {{ isset($steadfast) && $steadfast->status ? 'checked' : '' }}
                                class="toggle-checkbox h-5 w-10 rounded-full bg-gray-300 checked:bg-[#10B981] transition duration-200">
                        </div>

                        <div class="mt-3">
                            <button type="submit"
                                class="w-full rounded-md bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 font-medium transition-all">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
