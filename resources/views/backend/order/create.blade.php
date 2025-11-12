@extends('backend.layouts.app')
@section('title', 'Create Order')
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

        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 4px 10px;
            font-size: 14px;
            border-radius: 0.375rem;
            border: 1px solid #6366f1 !important;
        }

        .select2-container--default .select2-results__option--highlighted span {
            color: #ffffff !important;
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

        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🛒 Select Product / Variant</h2>

            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Select Product</label>
                    <select name="product_id" id="productSelect"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-[11px] text-sm sm:text-base focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Select product or variant</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-image="{{ asset('uploads/products/' . ($product->images->first()->image ?? 'default.png')) }}">
                                {{ $product->name }}
                            </option>

                            @foreach ($product->variants as $variant)
                                @php
                                    $variantName = $product->name;
                                    if ($variant->attributes && is_array($variant->attributes)) {
                                        $values = collect($variant->attributes)
                                            ->pluck('values')
                                            ->flatten()
                                            ->implode(', ');
                                        $variantName .= ' (' . $values . ')';
                                    }
                                @endphp
                                <option value="variant_{{ $variant->id }}" data-name="{{ $variantName }}"
                                    data-image="{{ asset('uploads/products/variants/' . ($variant->images->first()->image ?? 'default.png')) }}">
                                    {{ $variantName }} @if ($variant->attributes && is_array($variant->attributes))
                                        <span class="text-xs text-gray-500 ml-1">
                                            —
                                            {{ collect($variant->attributes)->pluck('values')->flatten()->implode(', ') }}
                                        </span>
                                    @endif
                                </option>
                            @endforeach
                        @endforeach
                    </select>

                    <div id="selectedProductCard" class="hidden mt-4 transition-all duration-300"></div>
                </div>

                <div class="mt-4">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Quantity</label>
                    <input type="number" name="quantity" min="1" value="1"
                        class="w-full rounded-md border border-gray-300 text-gray-900 px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full rounded-md bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 text-sm sm:text-base transition-all duration-200">
                        Add to Order
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
                var $option = $(`
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="${image}" alt="${name}" style="width: 40px; height: 40px; border-radius: 4px; border:1px solid #ccc;">
                    <span>${name}</span>
                </div>
            `);
                return $option;
            }

            $('#productSelect').select2({
                templateResult: formatProduct,
                templateSelection: formatProduct,
                width: '100%',
                placeholder: "Select a product or variant",
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
                        <div>
                            <h5 class="font-semibold text-gray-800">${name}</h5>
                            <span class="text-sm text-gray-600">Selected item for order</span>
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
