@extends('backend.layouts.app')
@section('title', 'Loss/Profit')
@section('content')
    <div class="w-full mb-6">

        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-xl font-bold text-gray-700 flex items-center gap-2">
                <i class="ri-stack-line text-xl text-indigo-500"></i>
                Loss/Profit
            </h1>
            <nav class="text-sm text-gray-500 mt-2 sm:mt-0">
                <ol class="list-reset flex">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>Orders</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">

            <div class="bg-white p-6 rounded shadow border-l-4 border-green-500">
                <h3 class="text-sm text-gray-500">Total Sale</h3>
                <p class="text-2xl font-bold text-green-600">
                    ৳ {{ number_format($totalSell, 2) }}
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
                <h3 class="text-sm text-gray-500">Total Buy</h3>
                <p class="text-2xl font-bold text-blue-600">
                    ৳ {{ number_format($totalBuy, 2) }}
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow border-l-4 border-indigo-500">
                <h3 class="text-sm text-gray-500">Profit</h3>
                <p class="text-2xl font-bold {{ $profit >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                    ৳ {{ number_format($profit, 2) }}
                </p>
            </div>

        </div>
    </div>
@endsection
