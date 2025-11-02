@extends('backend.layouts.app')
@section('title', 'SMS Gateway API')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">SMS Gateway API</h2>
                <a href="{{ route('admin.dashboard') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded font-medium hover:bg-indigo-700 transition">
                    Dashboard
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> /
                    SMS / Create
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

                <!-- Textlocal -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3 text-white text-xl font-semibold"
                        style="background-color: #FF6F00;">
                        <span>Textlocal</span>
                        <i class="ri-message-2-fill text-3xl"></i>
                    </div>

                    <form action="{{ route('admin.sms_email_api.store') }}" method="POST"
                        class="grid grid-cols-1 gap-4 px-5 py-5">
                        @csrf

                        <input type="hidden" name="provider" value="{{ old('provider', $textlocal->provider ?? '') }}">

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">API Key</label>
                            <input type="text" name="api_key" placeholder="Enter API Key"
                                value="{{ old('api_key', $textlocal->api_key ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2 
                                    outline-none focus:ring-2 focus:ring-[#FF6F00] focus:border-[#FF6F00] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Sender</label>
                            <input type="text" name="sender" placeholder="Enter Sender"
                                value="{{ old('sender', $textlocal->sender ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2 
                                    outline-none focus:ring-2 focus:ring-[#FF6F00] focus:border-[#FF6F00] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Base URL</label>
                            <input type="url" name="url" placeholder="Enter Base URL"
                                value="{{ old('url', $textlocal->url ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2 
                                    outline-none focus:ring-2 focus:ring-[#FF6F00] focus:border-[#FF6F00] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 font-medium mb-1">Provider</label>
                            <select name="provider"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2.5 
                                    outline-none focus:ring-2 focus:ring-[#FF6F00] focus:border-[#FF6F00] transition">
                                @foreach (['robi', 'banglalink', 'grameenphone', 'airtel', 'teletalk', 'other'] as $provider)
                                    <option value="{{ $provider }}"
                                        {{ old('provider', $textlocal->provider ?? '') == $provider ? 'selected' : '' }}>
                                        {{ ucfirst($provider) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="text-gray-700 font-medium">Enable Textlocal</label>
                            <input type="checkbox" name="status"
                                {{ old('status', $textlocal->status ?? 0) ? 'checked' : '' }}
                                class="toggle-checkbox h-5 w-10 rounded-full bg-gray-300 checked:bg-[#FF6F00] transition duration-200">
                        </div>

                        <div class="mt-2">
                            <button type="submit"
                                class="w-full rounded-md text-white py-2.5 font-medium transition bg-[#FF6F00] hover:bg-[#e65c00]">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Gmail SMTP -->
                <div class="border border-gray-300 bg-white rounded-lg overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3 text-white text-xl font-semibold"
                        style="background-color: #D44638;">
                        <span>Gmail SMTP</span>
                        <i class="ri-mail-fill text-3xl"></i>
                    </div>

                    <form action="{{ route('admin.sms_email_api.store') }}" method="POST"
                        class="grid grid-cols-1 gap-4 px-5 py-5">
                        @csrf

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Email</label>
                            <input type="text" name="email" placeholder="Enter Email"
                                value="{{ old('email', $gmailSmtp->email ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                                    outline-none focus:ring-2 focus:ring-[#D44638] focus:border-[#D44638] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">App Password</label>
                            <input type="text" name="password" placeholder="Enter App Password"
                                value="{{ old('password', $gmailSmtp->password ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                                    outline-none focus:ring-2 focus:ring-[#D44638] focus:border-[#D44638] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Host</label>
                            <input type="text" name="host" placeholder="Enter Host"
                                value="{{ old('host', $gmailSmtp->host ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                                    outline-none focus:ring-2 focus:ring-[#D44638] focus:border-[#D44638] transition">
                        </div>

                        <div>
                            <label class="block text-md text-gray-600 mb-1 font-medium">Port</label>
                            <input type="number" name="port" placeholder="Enter Port"
                                value="{{ old('port', $gmailSmtp->port ?? '') }}"
                                class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                                    outline-none focus:ring-2 focus:ring-[#D44638] focus:border-[#D44638] transition">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="text-gray-700 font-medium">Enable Gmail SMTP</label>
                            <input type="checkbox" name="status"
                                {{ old('status', $gmailSmtp->status ?? 0) ? 'checked' : '' }}
                                class="toggle-checkbox h-5 w-10 rounded-full bg-gray-300 checked:bg-[#D44638] transition duration-200">
                        </div>

                        <div class="mt-2">
                            <button type="submit"
                                class="w-full rounded-md text-white py-2.5 font-medium transition bg-[#D44638] hover:bg-[#b13a30]">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
