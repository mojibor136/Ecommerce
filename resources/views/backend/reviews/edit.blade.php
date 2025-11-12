@extends('backend.layouts.app')
@section('title', 'Edit Review')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-results__option img {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            object-fit: cover;
            margin-right: 6px;
            vertical-align: middle;
        }

        .select2-selection__rendered img {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            object-fit: cover;
            margin-right: 6px;
            vertical-align: middle;
        }

        .select2-container--default .select2-results__option--highlighted span {
            color: #ffffff !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 4px 10px;
            font-size: 14px;
            border-radius: 0.375rem;
            border: 1px solid #6366f1 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%);
            height: 100%;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important;
            line-height: 32px;
            display: block !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered img {
            display: none !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            color: #374151 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 1px #2563eb !important;
            outline: none !important;
        }

        .select2-container--default .select2-results__option {
            color: #374151 !important;
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }

        .selected-product-card {
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06);
        }

        .selected-product-card img {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .selected-product-card h5 {
            font-size: 14px;
            font-weight: 600;
            color: #424c5c;
            margin: 0;
        }

        .selected-product-card span {
            font-size: 14px;
            color: #6b7280;
        }
    </style>

    <div class="w-full flex flex-col gap-4 mb-20">
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Review</h2>
                <a href="{{ route('admin.reviews.index') }}"
                    class="block md:hidden bg-indigo-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-indigo-700 transition">
                    All Reviews
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Home</a> / Review / Edit
                </p>
                <a href="{{ route('admin.reviews.index') }}"
                    class="hidden md:inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded text-base font-medium hover:bg-indigo-700 transition">
                    All Reviews
                </a>
            </div>
        </div>

        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <div class="col-span-2" id="product-select-edit">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Select Product</label>
                    <select name="product_id" id="productSelect"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-[11px] text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Select a product to review</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-image="{{ asset('uploads/products/' . ($product->images->first()->image ?? 'default.png')) }}"
                                {{ $product->id == $review->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>

                    <div id="selectedProductCard" class="mt-4 transition-all duration-300">
                        @php
                            $selectedProduct = $products->where('id', $review->product_id)->first();
                        @endphp
                        @if ($selectedProduct)
                            <div class="selected-product-card">
                                <img src="{{ asset('uploads/products/' . ($selectedProduct->images->first()->image ?? 'default.png')) }}"
                                    alt="{{ $selectedProduct->name }}">
                                <div>
                                    <h5>{{ $selectedProduct->name }}</h5>
                                    <span>Selected product for review</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Rating (1-5)</label>
                    <input type="number" name="rating" min="1" max="5"
                        value="{{ old('rating', $review->rating) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Review Title</label>
                    <input type="text" name="title" value="{{ old('title', $review->title) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">
                </div>

                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Review Details</label>
                    <textarea name="review" rows="4"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 border-gray-300">{{ old('review', $review->review) }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-[11px] text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="1" {{ $review->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $review->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Update Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function formatProduct(option) {
                if (!option.id) return option.text;
                var image = $(option.element).data('image');
                var name = $(option.element).data('name');

                if (!image) {
                    image =
                        "https://cdni.iconscout.com/illustration/premium/thumb/product-is-empty-illustration-svg-download-png-6430781.png";
                }

                var $option = $(`
                <div style="
                    display: flex; 
                    align-items: center; 
                    gap: 10px;
                ">
                    <img src="${image}" 
                         alt="${name}"
                         style="
                             width: 45px; 
                             height: 45px; 
                             border-radius: 50%; 
                             object-fit: cover;
                             border:1px solid #777;
                         ">
                    <span style="font-size: 14px; color: #374151;">${name}</span>
                </div>
            `);
                return $option;
            }

            $('#productSelect').select2({
                templateResult: formatProduct,
                templateSelection: formatProduct,
                width: '100%',
                placeholder: "Select a product to review",
                allowClear: true
            });

            $('#productSelect').on('change', function() {
                var selected = $(this).find(':selected');
                var name = selected.data('name');
                var image = selected.data('image');

                if (selected.val()) {
                    var cardHTML = `
                    <div class="selected-product-card">
                        <img src="${image}" alt="${name}">
                        <div style="display:flex; flex-direction:column;">
                            <h5>${name}</h5>
                            <span>Selected product for review</span>
                        </div>
                    </div>
                `;
                    $('#selectedProductCard').html(cardHTML).removeClass('hidden');
                } else {
                    $('#selectedProductCard').addClass('hidden').html('');
                }
            });
        });
    </script>
@endpush
