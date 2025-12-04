@extends('frontend.layouts.master')
@section('title', $setting->meta_title)
@section('content')
    @php
        $randomCategories = $allcategories->shuffle()->take(9);
    @endphp

    <style>
        @keyframes cardFadeUp {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .product-card {
            opacity: 0;
            animation: cardFadeUp 0.6s ease forwards;
        }
    </style>

    <div class="w-full md:py-2 py-0 mb-4">
        <div class="max-w-6xl mx-auto grid grid-cols-12 gap-2">
            <div class="col-span-3 bg-white relative hidden md:block">
                <ul id="categoryList" class="grid grid-cols-1 max-h-[330px]">
                    @foreach ($randomCategories as $category)
                        <li class="group relative">
                            <div onclick="window.location.href='{{ route('category.product', $category->slug) }}'"
                                class="flex items-center font-medium justify-between px-4 py-1 hover:bg-gray-100 cursor-pointer transition">
                                <span class="text-gray-800 text-[14.5px] capitalize">{{ $category->name }}</span>
                                @if ($category->subcategories->count() > 0)
                                    <i class="ri-arrow-right-s-line text-gray-400 text-lg font-normal"></i>
                                @endif
                            </div>
                            @if ($category->subcategories->count() > 0)
                                <ul class="absolute top-0 left-full hidden group-hover:block bg-white w-[220px] z-20">
                                    <div class="bg-white">
                                        @foreach ($category->subcategories as $subcategory)
                                            <li onclick="window.location.href='{{ route('subcategory.product', $subcategory->slug) }}'"
                                                class="px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 cursor-pointer capitalize">
                                                {{ $subcategory->name }}
                                            </li>
                                        @endforeach
                                    </div>
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="md:col-span-9 col-span-12 overflow-hidden shadow-md relative">
                <div id="banner"
                    class="owl-carousel owl-theme w-full md:h-[330px] h-auto bg-gray-100 overflow-hidden flex items-center">
                    @foreach ($mainBanner as $banner)
                        <img loading="lazy" src="{{ asset($banner->image) }}" alt="Banner"
                            class="w-full h-full object-cover">
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white md:py-6 py-3 mb-6">
        <div class="max-w-6xl mx-auto md:px-0 px-2 grid grid-cols-3 gap-2">
            @foreach ($offerBanner->random(3) as $banner)
                <img loading="lazy" src="{{ asset($banner->image) }}" alt="Banner 1"
                    class="w-full h-auto md:min-h-40 min-h-16 object-cover shadow-md">
            @endforeach
        </div>
    </div>

    <div class="bg-white py-4 my-6 hidden md:block">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 px-2">Shop by Category</h2>
            <div id="categoryScroll"
                class="owl-carousel owl-theme flex overflow-x-auto gap-4 scroll-smooth px-2 pb-2 scroll-hidden cursor-grab active:cursor-grabbing">
                @foreach ($allcategories as $category)
                    <div onclick="window.location.href='{{ route('category.product', $category->slug) }}'"
                        class="min-w-[100px] bg-gray-50 border rounded-lg shadow-sm flex flex-col items-center justify-start md:py-4 py-2 hover:shadow-md transition px-2 md:min-h-[140px] min-h-[100px]">
                        <img loading="lazy" src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                            class="w-16 h-14 object-contain mb-2">
                        <span
                            class="text-sm font-medium text-gray-700 text-center capitalize line-clamp-2">{{ $category->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Responsive Grid for Mobile -->
    <div class="bg-white py-4 my-6 block md:hidden">
        <div class="max-w-6xl mx-auto px-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Shop by Category</h2>

            <div class="grid grid-cols-4 overflow-hidden" style="max-height: 220px;">
                @foreach ($allcategories->shuffle()->take(8) as $category)
                    <div onclick="window.location.href='{{ route('category.product', $category->slug) }}'"
                        class="flex flex-col items-center justify-start py-3 hover:shadow transition cursor-pointer">
                        <img loading="lazy" src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                            class="w-14 h-12 object-contain mb-2 border border-gray-50 rounded">
                        <span class="text-xs font-medium capitalize text-gray-700 text-center line-clamp-2">
                            {{ $category->name }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white py-3 my-6">
        <div class="max-w-6xl mx-auto">
            <div class="border-b pb-3 mb-3 flex items-center justify-between px-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2 mt-1">
                    <i class="ri-fire-fill text-[{{ $theme->theme_bg }}]"></i> Hot Deals
                </h2>
                @php
                    $hotDealsDate = $setting->hot_deals ?? null;
                @endphp
                @if ($hotDealsDate)
                    <div class="flex gap-2 items-center" id="hot-deal-timer" data-end-date="{{ $hotDealsDate }}">
                        <div id="hours"
                            class="w-10 h-9 text-sm flex items-center justify-center rounded bg-[{{ $theme->theme_bg }}] text-white font-semibold">
                            00</div>
                        <div id="minutes"
                            class="w-10 h-9 text-sm flex items-center justify-center rounded bg-[{{ $theme->theme_bg }}] text-white font-semibold">
                            00</div>
                        <div id="seconds"
                            class="w-10 h-9 text-sm flex items-center justify-center rounded bg-[{{ $theme->theme_bg }}] text-white font-semibold">
                            00</div>
                    </div>
                @endif
            </div>

            <div id="hotdealScroll" class="owl-carousel owl-theme">
                @foreach ($hotDeals as $product)
                    <div onclick="window.location='{{ route('product.details', $product->slug) }}'"
                        class="product-card relative rounded-md border p-2.5 flex flex-col items-center transition cursor-pointer">
                        @if ($product->old_price && $product->new_price)
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
                                    class="absolute top-3 right-3 {{ $badgeColor }} text-white text-xs font-semibold px-2 py-0.5 rounded z-20">{{ $badgeText }}</span>
                            @endif
                        @endif

                        <div class="w-full h-40 mb-3 overflow-hidden rounded relative">
                            <img loading="lazy" src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                alt="Smartphone XYZ"
                                class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                        </div>
                        <h3 class="text-gray-700 font-semibold text-center capitalize text-[14.5px] line-clamp-2 mb-1">
                            {{ $product->name }}</h3>
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
                        <p class="text-[{{ $theme->theme_bg }}] font-bold mb-2 text-left text-[14.5px]">
                            &#2547;{{ $product->new_price }}
                            @if ($product->old_price)
                                <span
                                    class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                            @endif
                        </p>

                        <div class="flex flex-col gap-1 w-full">
                            <form method="POST" action="{{ route('checkout.buy-now', $product->id) }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="image"
                                    value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                <button type="submit" onclick="event.stopPropagation();"
                                    class="bg-[{{ $theme->nav_bg }}]/90 hover:bg-[{{ $theme->nav_bg }}] text-[{{ $theme->nav_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                    অর্ডার করুন
                                </button>
                            </form>
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="image"
                                    value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                <button type="submit" onclick="event.stopPropagation();"
                                    class="bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                    কার্টে রাখুন
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto md:px-0 px-2 mb-6">
        @foreach ($offerBanner->random(1) as $banner)
            <img loading="lazy" src="{{ asset($banner->image) }}" alt="Banner 1"
                class="w-full h-full md:h-72 object-fill">
        @endforeach
    </div>

    <div class="bg-white py-4 mb-6">
        <div class="max-w-6xl mx-auto px-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Featured Products</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach ($products as $product)
                    <div class="bg-white rounded-md overflow-hidden relative border cursor-pointer product-card"
                        onclick="window.location='{{ route('product.details', $product->slug) }}'">
                        @if ($product->old_price && $product->new_price)
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
                                    class="absolute top-2 right-2 {{ $badgeColor }} text-white text-xs font-semibold px-2 py-0.5 rounded z-20">{{ $badgeText }}</span>
                            @endif
                        @endif

                        <div class="w-full h-48 overflow-hidden relative">
                            <button
                                onclick="event.stopPropagation(); document.getElementById('add_cart_{{ $product->id }}').submit();"
                                class="absolute bottom-2 left-2 bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_bg }}] text-white w-9 h-9 flex items-center justify-center rounded-full transition">
                                <i class="ri-shopping-cart-line text-md"></i>
                            </button>
                            <img loading="lazy" src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                alt="Smartphone XYZ"
                                class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                        </div>

                        <div class="px-2.5 py-1 pb-2.5 flex flex-col items-left">
                            <h3 class="text-gray-700 font-medium capitalize text-left text-[14.5px] line-clamp-2">
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
                            <p class="text-[{{ $theme->theme_bg }}] font-bold mb-2 text-left text-[14.5px]">
                                &#2547;{{ $product->new_price }}
                                @if ($product->old_price)
                                    <span
                                        class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                                @endif
                            </p>
                            <div class="flex flex-row gap-1 w-full">
                                <form method="POST" action="{{ route('checkout.buy-now', $product->id) }}"
                                    class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="image"
                                        value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                    <button type="submit" onclick="event.stopPropagation();"
                                        class="bg-[{{ $theme->nav_bg }}]/90 hover:bg-[{{ $theme->nav_bg }}] text-[{{ $theme->nav_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                        অর্ডার করুন
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto md:px-0 px-2 mb-6">
        @foreach ($offerBanner->random(1) as $banner)
            <img loading="lazy" src="{{ asset($banner->image) }}" alt="Banner 1"
                class="w-full h-full md:h-72 object-fill">
        @endforeach
    </div>

    @foreach ($categories as $category)
        <div class="bg-white py-4 mb-6">
            <div class="max-w-6xl mx-auto px-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">{{ $category->name }}</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach ($category->products as $product)
                        <div class="bg-white rounded-md overflow-hidden relative border cursor-pointer"
                            onclick="window.location='{{ route('product.details', $product->slug) }}'">
                            @if ($product->old_price && $product->new_price)
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
                                        class="absolute top-2 right-2 {{ $badgeColor }} text-white text-xs font-semibold px-2 py-0.5 rounded z-20">{{ $badgeText }}</span>
                                @endif
                            @endif
                            <div class="w-full h-48 overflow-hidden">
                                <img loading="lazy"
                                    src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                            </div>

                            <div class="px-2.5 py-1 pb-2.5 flex flex-col items-left">
                                <h3 class="text-gray-700 font-medium capitalize text-left text-[14.5px] line-clamp-2">
                                    {{ $product->name }}</h3>
                                <div class="flex items-center text-[14.5px]">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $product->rating)
                                            <i class="ri-star-fill text-yellow-400"></i>
                                        @elseif ($i - $product->rating == 0.5)
                                            <i class="ri-star-half-line text-yellow-400"></i>
                                        @else
                                            <i class="ri-star-line text-yellow-400"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-[{{ $theme->theme_bg }}] font-bold mb-2 text-left text-[14.5px]">
                                    &#2547;{{ $product->new_price }}
                                    @if ($product->old_price)
                                        <span
                                            class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                                    @endif
                                </p>
                                <div class="flex flex-row gap-1 w-full">
                                    <form method="POST" action="{{ route('checkout.buy-now', $product->id) }}"
                                        class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="image"
                                            value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                        <button type="submit" onclick="event.stopPropagation();"
                                            class="bg-[{{ $theme->nav_bg }}]/90 hover:bg-[{{ $theme->nav_bg }}] text-[{{ $theme->nav_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                            <i class="ri-shopping-bag-line"></i> অর্ডার করুন
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-12">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="image"
                                            value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                        <button type="submit" onclick="event.stopPropagation();"
                                            class="bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                          <i class="ri-shopping-cart-line text-md"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <div class="bg-white py-6 mb-6">
        <div class="max-w-6xl mx-auto md:px-0 px-2 grid grid-cols-2 gap-2">
            @foreach ($offerBanner->random(2) as $banner)
                <img loading="lazy" src="{{ asset($banner->image) }}" alt="Banner 1"
                    class="w-full h-auto md:max-h-48 md:min-h-48 object-cover shadow-md">
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll(".product-card");

            cards.forEach((card, index) => {
                card.style.animationDelay = (index * 0.3) + "s";
            });
        });
    </script>

@endsection
