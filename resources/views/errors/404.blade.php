@extends('frontend.layouts.master')
@section('title', 'Oops! Page Not Found')
@section('content')
    <div class="max-w-6xl mx-auto my-4 px-4 md:px-6 lg:px-0">
        <div class="text-center px-4 md:px-0">
            <h1 class="text-8xl md:text-9xl font-extrabold text-orange-500 mb-4 animate-pulse">404</h1>

            <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-3">Oops! Page Not Found</h2>

            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                The page you are looking for might have been removed, had its name changed,
                or is temporarily unavailable. Let's get you back home.
            </p>

            <a href="{{ url('/') }}"
                class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-md shadow-lg transition duration-200 transform hover:scale-105">
                Go Back Home
            </a>
        </div>
    </div>
@endsection
