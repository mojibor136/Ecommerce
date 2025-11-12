@extends('frontend.layouts.master')
@section('title', $product->name)
@section('content')
    <div class="max-w-6xl mx-auto grid grid-cols-12 md:my-4 mb-4">
        <div class="border-b col-span-12 block md:hidden relative">
            <div id="phoneProduct" class="owl-carousel owl-theme flex items-center gap-2">
                @foreach ($allImages as $image)
                    @php
                        $productPath = 'uploads/products/' . $image;
                        $variantPath = 'uploads/products/variants/' . $image;

                        if (file_exists(public_path($variantPath))) {
                            $finalPath = $variantPath;
                        } else {
                            $finalPath = $productPath;
                        }
                    @endphp
                    <img loading="lazy" src="{{ asset($finalPath) }}" alt="{{ $product->name }}"
                        class="w-full h-full max-h-80 object-initial">
                @endforeach
            </div>
            <div id="productCounter"
                class="absolute left-1/2 transform -translate-x-1/2 bottom-5 text-white text-sm bg-black/40 px-3 py-1 rounded z-20">
            </div>
        </div>

        <div class="md:col-span-4 col-span-12 flex flex-col gap-3 items-center justify-start bg-white hidden md:flex">
            <div id="mainImageContainer" class="w-full border-b border-r border-gray-100 px-3 py-3">
                <img loading="lazy" id="mainImage" src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                    alt="{{ $product->name }}" class="w-full h-auto object-cover">
            </div>
            <div id="desktopProduct" class="owl-carousel owl-theme flex gap-2 pb-3 px-3 hidden md:block">
                @foreach ($allImages as $image)
                    @php
                        $productPath = 'uploads/products/' . $image;
                        $variantPath = 'uploads/products/variants/' . $image;

                        if (file_exists(public_path($variantPath))) {
                            $finalPath = $variantPath;

                            $variantId = 0;
                            foreach ($variants as $variant) {
                                if (in_array($image, $variant['images'])) {
                                    $variantId = $variant['id'];
                                    break;
                                }
                            }
                        } else {
                            $finalPath = $productPath;
                            $variantId = 0;
                        }
                    @endphp

                    <img loading="lazy" src="{{ asset($finalPath) }}" alt="{{ $product->name }}"
                        class="h-16 w-16 object-cover rounded shadow mx-auto cursor-pointer border transition duration-200"
                        data-variant-id="{{ $variantId }}" onclick="changeMainImage(this)">
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const mainImage = document.getElementById("mainImage");
                const finalPriceEl = document.getElementById("finalPrice");
                const oldPriceEl = document.getElementById("oldPrice");
                const savePriceEl = document.getElementById("savePrice");
                const stockEl = document.querySelector('.text-green-600');

                const cartImage = document.getElementById("cartImage");
                const buyNowImage = document.getElementById("buyNowImage");

                const variants = @json($variants);

                function updateHiddenInputs(variantId = 0) {
                    const currentSrc = mainImage.getAttribute("src");
                    if (cartImage) cartImage.value = currentSrc;
                    if (buyNowImage) buyNowImage.value = currentSrc;

                    let variant = variants.find(v => v.id == variantId);
                    if (variant) {
                        finalPriceEl.textContent = `৳${variant.new_price.toFixed(2)}`;
                        oldPriceEl.textContent = variant.old_price ? `৳${parseFloat(variant.old_price).toFixed(2)}` :
                            '';
                        savePriceEl.textContent = variant.old_price ?
                            `Save ৳${(parseFloat(variant.old_price) - variant.new_price).toFixed(2)}` : '';
                        if (stockEl) stockEl.textContent = `${variant.stock} Available`;
                    } else {
                        finalPriceEl.textContent = `৳{{ $product->new_price }}.00`;
                        @if ($product->old_price)
                            oldPriceEl.textContent = `৳{{ $product->old_price }}.00`;
                            savePriceEl.textContent = `Save ৳-{{ $product->old_price - $product->new_price }}.00`;
                        @endif
                        if (stockEl) stockEl.textContent = `{{ $product->stock }} Available`;
                    }
                }

                const container = document.getElementById("desktopProduct");

                container.addEventListener("click", function(e) {
                    const target = e.target;
                    if (target.tagName === "IMG") {
                        mainImage.src = target.src;

                        container.querySelectorAll("img").forEach(img => {
                            img.classList.remove("border-2", "border-orange-500");
                            img.classList.add("border", "border-gray-200");
                        });

                        target.classList.remove("border", "border-gray-200");
                        target.classList.add("border-2", "border-orange-500");

                        const variantId = parseInt(target.getAttribute('data-variant-id'));
                        updateHiddenInputs(variantId);
                    }
                });

                document.querySelectorAll("form").forEach(form => {
                    form.addEventListener("submit", function() {
                        const variantId = mainImage.closest('div').querySelector('img.border-2')
                            ?.getAttribute('data-variant-id') || 0;
                        updateHiddenInputs(parseInt(variantId));
                    });
                });

                updateHiddenInputs();
            });
        </script>

        <div class="md:col-span-5 col-span-12 bg-white px-4 py-2 flex flex-col justify-start">
            <h1 class="text-xl font-medium text-gray-800 leading-[1.4] line-clamp-2">{{ $product->name }}</h1>

            @if (!empty($product->desc))
                <div class="text-gray-600 text-[14px] mt-1 overflow-hidden lowercase"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                    {!! strtolower($product->desc) !!}
                </div>
            @endif

            <div class="flex items-center gap-1 mb-1">
                <span class="text-yellow-400 text-lg">★ ★ ★ ★ ☆</span>
                <span class="text-gray-600 text-sm">(120 Reviews)</span>
            </div>

            <div class="flex items-center mb-3">
                <span class="font-medium text-gray-800 mr-2">Brand:</span>
                <span
                    class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm">{{ $product->brand ? $product->brand : 'None' }}</span>
            </div>

            <div class="flex items-center mb-2">
                <span class="font-medium text-gray-800 mr-2">Stock:</span>
                <span class="text-green-600 font-semibold">5 Available</span>
            </div>

            @php
                $allAttributes = [];
                foreach ($variants as $variant) {
                    foreach ($variant['attributes'] as $attr) {
                        $attrName = $attr['attribute_name'];
                        if (!isset($allAttributes[$attrName])) {
                            $allAttributes[$attrName] = [];
                        }
                        foreach ($attr['values'] as $val) {
                            if (!in_array($val, $allAttributes[$attrName])) {
                                $allAttributes[$attrName][] = $val;
                            }
                        }
                    }
                }
            @endphp

            @if (!empty($allAttributes))
                <div class="mb-4">
                    <span class="font-medium text-gray-800 block mb-2">Choose Variant</span>
                    <div class="flex flex-col gap-3">
                        @foreach ($allAttributes as $attributeName => $values)
                            <div class="flex gap-2 items-center">
                                <span class="text-gray-700 text-sm">{{ $attributeName }}:</span>
                                @foreach ($values as $value)
                                    <div
                                        class="px-3 py-1 border rounded cursor-pointer text-sm variant-box hover:bg-orange-500 hover:text-white">
                                        {{ $value }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-4 flex items-center gap-3">
                <span class="text-gray-700 font-medium">Quantity:</span>
                <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                    <button type="button"
                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold quantity-decrease">-</button>
                    <input type="number" min="1" max="{{ $product->stock }}" value="1"
                        class="w-16 text-center border-gray-300 focus:outline-none quantity-input">
                    <button type="button"
                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold quantity-increase">+</button>
                </div>
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-bold text-orange-600" id="finalPrice">৳{{ $product->new_price }}.00</span>
                    @if ($product->old_price)
                        <span class="text-gray-400 line-through text-lg"
                            id="oldPrice">৳{{ $product->old_price }}.00</span>
                    @endif
                    @if ($product->old_price && $product->new_price < $product->old_price)
                        <span class="text-sm text-green-600 font-medium px-2 py-1 rounded bg-green-100 animate-pulse"
                            id="savePrice">
                            Save ৳-{{ $product->old_price - $product->new_price }}.00
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-row gap-3 mb-1">
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full sm:w-1/2">
                    @csrf
                    <input type="hidden" name="image" id="cartImage">
                    <input type="hidden" name="variant[]" class="cart-variant">
                    <input id="quantity" type="hidden" name="quantity" value="1" class="quantity-input">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded transition duration-200">
                        Add to Cart
                    </button>
                </form>

                <form method="POST" action="{{ route('checkout.buy-now', $product->id) }}" class="w-full sm:w-1/2">
                    @csrf
                    <input type="hidden" name="image" id="buyNowImage">
                    <input type="hidden" name="variant[]" class="buy-now-variant">
                    <input id="quantity" type="hidden" name="quantity" value="1" class="quantity-input">
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded transition duration-200">
                        Buy Now
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const variantBoxes = document.querySelectorAll('.variant-box');

                variantBoxes.forEach(box => {
                    box.addEventListener('click', () => {
                        const attrName = box.parentElement.querySelector('span').innerText.replace(':',
                            '').trim();

                        box.parentElement.querySelectorAll('.variant-box').forEach(b => {
                            b.classList.remove('bg-orange-500', 'text-white');
                        });

                        box.classList.add('bg-orange-500', 'text-white');

                        const value = box.innerText.trim();

                        const cartForm = document.querySelector('form .cart-variant')?.closest('form');
                        if (cartForm) {
                            let input = cartForm.querySelector(`input[name="variant[${attrName}]"]`);
                            if (!input) {
                                input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = `variant[${attrName}]`;
                                cartForm.appendChild(input);
                            }
                            input.value = value;
                        }

                        const buyNowForm = document.querySelector('form .buy-now-variant')?.closest(
                            'form');
                        if (buyNowForm) {
                            let input = buyNowForm.querySelector(`input[name="variant[${attrName}]"]`);
                            if (!input) {
                                input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = `variant[${attrName}]`;
                                buyNowForm.appendChild(input);
                            }
                            input.value = value;
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const quantityInput = document.querySelector('.quantity-input[type="number"]');
                const decreaseBtn = document.querySelector('.quantity-decrease');
                const increaseBtn = document.querySelector('.quantity-increase');
                const maxStock = parseInt(quantityInput.max);
                const basePrice = {{ $product->new_price ?? 0 }};
                const oldPrice = {{ $product->old_price ?? 0 }};

                const finalPriceEl = document.getElementById('finalPrice');
                const oldPriceEl = document.getElementById('oldPrice');
                const savePriceEl = document.getElementById('savePrice');

                function updateFormQuantity(value) {
                    document.querySelectorAll('form input.quantity-input[type="hidden"]').forEach(hidden => {
                        hidden.value = value;
                    });
                    updatePriceDisplay(value);
                }

                function updatePriceDisplay(qty) {
                    const totalPrice = basePrice * qty;
                    finalPriceEl.textContent = `৳${totalPrice.toFixed(2)}`;

                    if (oldPrice > 0 && oldPrice > basePrice) {
                        oldPriceEl.textContent = `৳${(oldPrice * qty).toFixed(2)}`;
                        savePriceEl.textContent = `Save ৳-${((oldPrice - basePrice) * qty).toFixed(2)}`;
                    }
                }

                updateFormQuantity(parseInt(quantityInput.value));

                decreaseBtn.addEventListener('click', () => {
                    let val = parseInt(quantityInput.value);
                    if (val > 1) val--;
                    quantityInput.value = val;
                    updateFormQuantity(val);
                });

                increaseBtn.addEventListener('click', () => {
                    let val = parseInt(quantityInput.value);
                    if (val < maxStock) val++;
                    quantityInput.value = val;
                    updateFormQuantity(val);
                });

                quantityInput.addEventListener('input', () => {
                    let val = parseInt(quantityInput.value);
                    if (isNaN(val) || val < 1) val = 1;
                    if (val > maxStock) val = maxStock;
                    quantityInput.value = val;
                    updateFormQuantity(val);
                });
            });
        </script>

        <div class="md:col-span-3 col-span-12 bg-gray-50 flex flex-col border-l border-gray-50">

            <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100">
                <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">💬 Need Help?</h2>
                <p class="text-sm text-gray-700">📞 Call us at <span
                        class="font-medium text-orange-600">{{ $setting->phone }}</span>
                </p>
                <p class="text-sm text-gray-700 mt-1">📧 Email: <span
                        class="text-orange-600">{{ $setting->email }}</span>
                </p>
                <p class="text-sm text-gray-700 mt-1">✅ Free delivery on orders over <span
                        class="font-semibold">৳1000</span>.</p>
                <p class="text-sm text-gray-700 mt-1">🔁 Easy 7-day return policy.</p>
            </div>

            <div class="bg-white p-4">
                <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">🚚 Delivery Charges</h2>
                <div class="flex flex-col gap-2 text-sm text-gray-700">
                    <div class="flex justify-between border-b pb-1">
                        <span>Inside Dhaka:</span>
                        <span class="font-semibold text-orange-600">৳{{ $inDhakaCharge }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Outside Dhaka:</span>
                        <span class="font-semibold text-orange-600">৳{{ $outDhakaCharge }}</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">💡 Delivery time 2–5 working days.</p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4">
                <h2 class="text-lg font-semibold mb-3 text-gray-800">Connect With Us</h2>
                <div class="flex flex-col gap-2">
                    <a href="https://wa.me/{{ $setting->whatsapp ?? '4571421852' }}" target="_blank"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg transition duration-200">
                        <i class="ri-whatsapp-line text-lg"></i> WhatsApp Chat
                    </a>

                    <a href="{{ $setting->facebook ?? 'https://www.facebook.com/yourpage' }}" target="_blank"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg transition duration-200">
                        <i class="ri-facebook-fill text-lg"></i> Facebook Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto my-4">
        <div class="w-full bg-white px-6 pb-6">
            <div class="border-b py-4 mb-2">
                <h2 class="text-xl font-semibold text-gray-800">Description</h2>
            </div>

            @if (!empty($product->desc))
                <div class="text-gray-700 text-sm">
                    {!! $product->desc !!}
                </div>
            @else
                <p class="text-gray-500 text-sm">No description available for this product.</p>
            @endif
        </div>
    </div>

    <div class="max-w-6xl mx-auto my-4">
        <div class="w-full bg-white px-6 pb-6">
            <div class="border-b py-4 mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Customer Reviews</h2>
            </div>

            @if ($reviews->isEmpty())
                <div class="text-center py-8 bg-gray-50 rounded-lg shadow-sm">
                    <i class="ri-chat-smile-2-line text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600 text-lg font-medium">No reviews yet</p>
                    <p class="text-gray-500 text-sm">Be the first to share your experience!</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($reviews as $review)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <img loading="lazy" class="w-12 h-12 rounded-full object-cover"
                                    src="{{ asset('upload/user/219969.png') }}" alt="Reviewer">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($review->rating))
                                                <i class="ri-star-fill text-yellow-400"></i>
                                            @elseif ($i == ceil($review->rating) && $review->rating != floor($review->rating))
                                                <i class="ri-star-half-line text-yellow-400"></i>
                                            @else
                                                <i class="ri-star-line text-yellow-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                                </div>

                                <div>
                                    <h3 class="text-md font-medium text-gray-800">{{ $review->title }}</h3>
                                    <p id="description-{{ $review->id }}" class="text-gray-700 text-sm truncate-lines">
                                        {{ $review->review }}
                                    </p>
                                    @if (strlen($review->review) > 100)
                                        <button id="seeMoreBtn-{{ $review->id }}"
                                            class="text-orange-600 font-semibold text-sm"
                                            onclick="toggleDescription({{ $review->id }})">
                                            See More
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white py-4 mb-6">
        <div class="max-w-6xl mx-auto px-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Related Products</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach ($products as $product)
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
                            <img loading="lazy" src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                alt="Smartphone XYZ"
                                class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                        </div>

                        <div class="px-2.5 py-1 pb-2.5 flex flex-col items-left">
                            <h3 class="text-gray-700 font-medium text-left text-[14.5px] line-clamp-2">
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
                            <p class="text-orange-500 font-bold mb-2 text-left text-[14.5px]">
                                &#2547;{{ $product->new_price }}
                                @if ($product->old_price)
                                    <span
                                        class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                                @endif
                            </p>
                            <button
                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md w-full transition text-[14.5px]">Order
                                Now</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleDescription() {
            const description = document.getElementById('description');
            const seeMoreBtn = document.getElementById('seeMoreBtn');

            description.classList.toggle('truncate-lines');

            if (description.classList.contains('truncate-lines')) {
                seeMoreBtn.textContent = 'See More';
            } else {
                seeMoreBtn.textContent = 'See Less';
            }
        }
    </script>

    <style>
        .truncate-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
