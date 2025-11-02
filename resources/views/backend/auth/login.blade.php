<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-700 min-h-screen flex items-center justify-center">

    <!-- Overlay Pattern -->
    <div
        class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/memphis-mini.png')] opacity-10">
    </div>

    <!-- Login Card -->
    <div class="relative z-10 glass p-8 md:p-10 rounded-2xl shadow-2xl w-[90%] max-w-md text-white">
        <div class="text-center mb-8">
            <div
                class="mx-auto bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mb-3 shadow-lg">
                <i class="ri-store-2-line text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold">Admin Login</h2>
            <p class="text-gray-200 text-sm">Access your e-commerce control panel</p>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-100 text-red-700 py-2 px-4 mb-4 rounded-md border border-red-300 text-sm">
                <i class="ri-error-warning-line mr-1"></i>{{ session()->get('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <input type="text" name="fakeusernameremembered" style="display:none">
            <input type="password" name="fakepasswordremembered" style="display:none">
            <!-- Username -->
            <div>
                <label for="email" class="block text-sm font-semibold mb-1 text-gray-200">
                    <i class="ri-user-3-line mr-1"></i>Email Address
                </label>
                <input type="email" autocomplete="new-email" name="email" id="email"
                    placeholder="Enter your email"
                    class="w-full px-4 py-2.5 rounded-md bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-cyan-400 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-sm text-red-400 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold mb-1 text-gray-200">
                    <i class="ri-lock-2-line mr-1"></i>Password
                </label>
                <input type="password" autocomplete="new-password" name="password" id="password"
                    placeholder="Enter your password"
                    class="w-full px-4 py-2.5 rounded-md bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-cyan-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <div class="text-sm text-red-400 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-sm text-gray-300">
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="accent-cyan-400">
                    Remember me
                </label>
                <a href="#" class="hover:underline hover:text-cyan-300">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 transition-all duration-300 py-2.5 rounded-lg font-semibold text-white flex items-center justify-center gap-2">
                <i class="ri-login-box-line text-lg"></i> Log In
            </button>
        </form>

        <p class="text-center text-sm text-gray-300 mt-6">
            &copy; {{ date('Y') }} E-commerce Admin. All rights reserved.
        </p>
    </div>

</body>

</html>
