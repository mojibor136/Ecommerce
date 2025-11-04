@extends('frontend.layouts.master')
@section('title', $subcategory->name)
@section('content')
    <div class="bg-gray-50 py-4 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-12 gap-4">
            <form action="{{ route('subcategory.product', $subcategory->slug) }}" method="GET"
                class="col-span-12 md:col-span-3 hidden md:block bg-white h-fit rounded-lg shadow p-4 sticky top-4"
                id="categoryList">
                <h3 class="text-lg font-semibold mb-4">Filter Products</h3>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Categories</h4>
                    <ul class="space-y-2 text-sm">
                        @foreach ($allcategories as $category)
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="form-checkbox"
                                        {{ in_array($category->id, request()->categories ?? []) ? 'checked' : '' }}>
                                    <span>{{ $category->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Price</h4>
                    <div class="flex items-center gap-2">
                        <input type="number" name="min_price" placeholder="Min"
                            value="{{ request()->min_price ?? $minPrice }}"
                            class="w-1/2 border px-3 py-1.5 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <input type="number" name="max_price" placeholder="Max"
                            value="{{ request()->max_price ?? $maxPrice }}"
                            class="w-1/2 border px-3 py-1.5 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Rating</h4>
                    <div class="flex flex-col gap-1">
                        @for ($i = 5; $i >= 1; $i--)
                            <label class="flex items-center gap-2 cursor-pointer text-sm">
                                <input type="radio" name="rating" value="{{ $i }}" class="form-radio"
                                    {{ request()->rating == $i ? 'checked' : '' }}>
                                <span class="flex gap-1">
                                    @for ($j = 0; $j < $i; $j++)
                                        <i class="ri-star-fill text-yellow-400"></i>
                                    @endfor
                                    @for ($k = $i; $k < 5; $k++)
                                        <i class="ri-star-line text-yellow-400"></i>
                                    @endfor
                                </span>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit"
                        class="w-1/2 bg-orange-500 hover:bg-orange-600 text-white py-2 rounded transition">Apply</button>
                    <a href="{{ route('subcategory.product', $subcategory->slug) }}"
                        class="w-1/2 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded transition text-center">Reset</a>
                </div>
            </form>

            <!-- ================= Products Grid ================= -->
            <main class="col-span-12 md:col-span-9">

                <div class="md:hidden mb-3 -mt-1 flex justify-between items-center">
                    <div>
                        <select class="border border-gray-300 rounded-md px-3 py-[10px] text-sm focus:outline-none">
                            <option>Sort by</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating">Top Rated</option>
                        </select>
                    </div>
                    <button id="openFilter" type="button"
                        class="flex items-center gap-2 bg-orange-500 text-white px-4 py-[7px] rounded-md shadow hover:bg-orange-600 transition">
                        <i class="ri-filter-3-line text-lg"></i> Filter
                    </button>
                </div>

                <!-- Mobile Filter Drawer -->
                <div id="mobileFilterDrawer" class="fixed inset-0 z-50 bg-black/40 hidden justify-end md:hidden">
                    <div class="bg-white w-full h-full p-5 overflow-y-auto transform translate-x-full transition-transform duration-300"
                        id="filterPanel">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Filter Products</h3>
                            <button id="closeFilter" type="button" class="text-gray-600 hover:text-gray-900 text-xl">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>

                        <!-- Filter Form (same logic as desktop) -->
                        <form action="{{ route('shop') }}" method="GET" class="space-y-6">
                            <!-- Categories -->
                            <div>
                                <h4 class="font-medium mb-2 text-gray-700">Categories</h4>
                                <ul class="space-y-2 text-sm">
                                    @foreach ($allcategories as $category)
                                        <li>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                    class="form-checkbox"
                                                    {{ in_array($category->id, request()->categories ?? []) ? 'checked' : '' }}>
                                                <span>{{ $category->name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Price -->
                            <div>
                                <h4 class="font-medium mb-2 text-gray-700">Price</h4>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="min_price" placeholder="Min"
                                        value="{{ request()->min_price ?? $minPrice }}"
                                        class="w-1/2 border px-3 py-1.5 rounded focus:ring-2 focus:ring-orange-500">
                                    <input type="number" name="max_price" placeholder="Max"
                                        value="{{ request()->max_price ?? $maxPrice }}"
                                        class="w-1/2 border px-3 py-1.5 rounded focus:ring-2 focus:ring-orange-500">
                                </div>
                            </div>

                            <!-- Rating -->
                            <div>
                                <h4 class="font-medium mb-2 text-gray-700">Rating</h4>
                                <div class="flex flex-col gap-1">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                                            <input type="radio" name="rating" value="{{ $i }}"
                                                class="form-radio" {{ request()->rating == $i ? 'checked' : '' }}>
                                            <span class="flex gap-1">
                                                @for ($j = 0; $j < $i; $j++)
                                                    <i class="ri-star-fill text-yellow-400"></i>
                                                @endfor
                                                @for ($k = $i; $k < 5; $k++)
                                                    <i class="ri-star-line text-yellow-400"></i>
                                                @endfor
                                            </span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-2 pt-2">
                                <button type="submit"
                                    class="w-1/2 bg-orange-500 hover:bg-orange-600 text-white py-2 rounded transition">Apply</button>
                                <a href="{{ route('shop') }}"
                                    class="w-1/2 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded transition text-center">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-y-4 gap-x-2">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-md overflow-hidden relative border cursor-pointer"
                            onclick="window.location='{{ route('product.details', $product->slug) }}'">
                            @if ($product->hot_deal == 1)
                                <span
                                    class="absolute top-2 right-2 bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded z-20">
                                    Hot
                                </span>
                            @elseif ($product->old_price && $product->new_price)
                                @php
                                    if ($product->old_price > $product->new_price) {
                                        $discount = round(
                                            (($product->old_price - $product->new_price) / $product->old_price) * 100,
                                        );
                                        $badgeText = "-{$discount}%";
                                        $badgeColor = 'bg-red-500';
                                    } elseif ($product->old_price < $product->new_price) {
                                        $discount = round(
                                            (($product->new_price - $product->old_price) / $product->old_price) * 100,
                                        );
                                        $badgeText = "+{$discount}%";
                                        $badgeColor = 'bg-green-500';
                                    } else {
                                        $badgeText = null;
                                    }
                                @endphp
                                @if ($badgeText)
                                    <span
                                        class="absolute top-2 right-2 {{ $badgeColor }} text-white text-xs font-semibold px-2 py-0.5 rounded z-20">
                                        {{ $badgeText }}
                                    </span>
                                @endif
                            @endif

                            <div class="w-full h-48 overflow-hidden">
                                <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                    alt="Smartphone XYZ"
                                    class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                            </div>

                            <div class="px-2.5 py-1 pb-2.5 flex flex-col items-left">
                                <h3 class="text-gray-700 font-medium text-left text-[14.5px] line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center text-[14.5px]">
                                    @php
                                        $rating = $product->averageRating();
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="ri-star-fill text-yellow-400"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="ri-star-half-line text-yellow-400"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="ri-star-line text-yellow-400"></i>
                                    @endfor
                                </div>
                                <p class="text-orange-500 font-bold mb-2 text-left text-[14.5px]">
                                    &#2547;{{ $product->new_price }}
                                    @if ($product->old_price)
                                        <span
                                            class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                                    @endif
                                </p>
                                <form method="POST" action="{{ route('checkout.buy-now', $product->id) }}"
                                    class="w-auto">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="image"
                                        value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                    <button type="submit" onclick="event.stopPropagation();"
                                        class="bg-orange-600 hover:bg-orange-700 text-white px-2 py-2 rounded w-full text-[14.5px]">
                                        Buy Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    <!-- JS for Mobile Filter -->
    <script>
        const openBtn = document.getElementById('openFilter');
        const closeBtn = document.getElementById('closeFilter');
        const drawer = document.getElementById('mobileFilterDrawer');
        const panel = document.getElementById('filterPanel');

        openBtn.addEventListener('click', () => {
            drawer.classList.remove('hidden');
            setTimeout(() => panel.classList.remove('translate-x-full'), 10);
        });

        closeBtn.addEventListener('click', () => {
            panel.classList.add('translate-x-full');
            setTimeout(() => drawer.classList.add('hidden'), 300);
        });

        drawer.addEventListener('click', (e) => {
            if (e.target === drawer) {
                panel.classList.add('translate-x-full');
                setTimeout(() => drawer.classList.add('hidden'), 300);
            }
        });
    </script>
@endsection
