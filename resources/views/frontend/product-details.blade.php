@extends('frontend.layouts.master')
@section('title', $product->name)
@section('content')
@section('meta')
    @php
        $ogImage = $product->images->first()
            ? asset('public/uploads/products/' . $product->images->first()->image)
            : asset('public/' . $setting->icon);
    @endphp

    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->desc), 160) }}">
    <meta property="og:url" content="{{ route('product.details', $product->slug) }}">
    <meta property="og:image" content="{{ $ogImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($product->desc), 160) }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
@endsection
<div class="max-w-6xl mx-auto grid grid-cols-12 md:my-4 mb-4">
    <div class="border-b col-span-12 block md:hidden relative">
        <div id="phoneProduct" class="owl-carousel owl-theme flex items-center gap-2">
            @foreach ($allImages as $image)
                @php
                    $productPath = 'public/uploads/products/' . $image;
                    $variantPath = 'public/uploads/products/variants/' . $image;

                    if (file_exists($variantPath)) {
                        $finalPath = $variantPath;
                    } else {
                        $finalPath = $productPath;
                    }
                @endphp
                <img loading="lazy" src="{{ asset($finalPath) }}" alt="{{ $product->name }}"
                    class="w-full h-full max-h-auto object-initial">
            @endforeach
        </div>
        <div id="productCounter"
            class="absolute left-1/2 transform -translate-x-1/2 bottom-5 text-white text-sm bg-black/40 px-3 py-1 rounded z-20">
        </div>
    </div>

    <div class="md:col-span-4 col-span-12 flex flex-col gap-3 items-center justify-start bg-white flex">
        <div id="mainImageContainer" class="w-full border-b border-r border-gray-100 px-3 py-3 hidden md:block">
            <img loading="lazy" id="mainImage"
                src="{{ asset('public/uploads/products/' . $product->images->first()->image) }}"
                alt="{{ $product->name }}" class="w-full h-auto object-cover">
        </div>
        <div id="desktopProduct" class="owl-carousel owl-theme flex gap-2 pb-1 md:pb-3 md:pt-0 pt-2 px-3">
            @foreach ($allImages as $image)
                @php
                    $productPath = 'public/uploads/products/' . $image;
                    $variantPath = 'public/uploads/products/variants/' . $image;

                    if (file_exists($variantPath)) {
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
            const stockEl = document.querySelector('.stock');
            const quantity = document.querySelector('.quantity-input');

            const cartImage = document.getElementById("cartImage");
            const buyNowImage = document.getElementById("buyNowImage");

            const cartVariantId = document.getElementById("cartVariantId");
            const buyNowVariantId = document.getElementById("buyNowVariantId");

            const variants = @json($variants);
            const container = document.getElementById("desktopProduct");


            function updateHiddenInputs(variantId = 0) {
                const currentSrc = mainImage?.getAttribute("src") ?? "";
                if (cartImage) cartImage.value = currentSrc;
                if (buyNowImage) buyNowImage.value = currentSrc;

                if (cartVariantId) cartVariantId.value = variantId;
                if (buyNowVariantId) buyNowVariantId.value = variantId;

                let variant = variants.find(v => v.id == variantId);

                const currentQty = quantity ? parseInt(quantity.value) : 1;

                if (variant) {
                    finalPriceEl.textContent = `৳${variant.new_price.toFixed(2)}`;
                    finalPriceEl.dataset.basePrice = variant.new_price;
                    oldPriceEl.textContent = variant.old_price ? `৳${parseFloat(variant.old_price).toFixed(2)}` :
                        '';
                    savePriceEl.textContent = variant.old_price ?
                        `Save ৳${(parseFloat(variant.old_price) - variant.new_price).toFixed(2)}` : '';
                    if (stockEl) stockEl.textContent = `${variant.stock} Available`;
                    checkStock();
                    if (quantity) {
                        quantity.max = variant.stock;
                        if (currentQty > variant.stock) quantity.value = variant.stock;
                        else quantity.value = currentQty;
                    }
                } else {
                    finalPriceEl.textContent = `৳{{ $product->new_price }}.00`;
                    finalPriceEl.dataset.basePrice = {{ $product->new_price }};
                    @if ($product->old_price)
                        oldPriceEl.textContent = `৳{{ $product->old_price }}.00`;
                        savePriceEl.textContent = `Save ৳-{{ $product->old_price - $product->new_price }}.00`;
                    @endif
                    if (quantity) {
                        quantity.max = `{{ $product->stock }}`;
                        if (currentQty > {{ $product->stock }}) quantity.value = {{ $product->stock }};
                        else quantity.value = currentQty;
                    }
                    if (stockEl) stockEl.textContent = `{{ $product->stock }} Available`;
                }

                checkStock();
            }

            window.addEventListener("load", () => {
                updateHiddenInputs();
                checkStock();
            });

            container.addEventListener("click", function(e) {
                const target = e.target;
                if (target.tagName === "IMG") {
                    mainImage.src = target.src;

                    container.querySelectorAll("img").forEach(img => {
                        img.classList.remove("border-2", "border-[{{ $theme->theme_bg }}]");
                        img.classList.add("border", "border-gray-200");
                    });

                    target.classList.remove("border", "border-gray-200");
                    target.classList.add("border-2", "border-[{{ $theme->theme_bg }}]");

                    const variantId = parseInt(target.getAttribute('data-variant-id'));
                    updateHiddenInputs(variantId);
                }
            });

            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function(e) {
                    const selectedImage = container.querySelector('img.border-2');
                    if (selectedImage) {
                        const variantId = parseInt(selectedImage.getAttribute('data-variant-id')) ||
                            0;
                        updateHiddenInputs(variantId);
                    }
                });
            });

            updateHiddenInputs();

            function checkStock() {
                const stockEl = document.getElementById('stockText');
                if (!stockEl) return;

                let text = stockEl.textContent.trim();
                let stockNumber = parseInt(text);

                if (isNaN(stockNumber)) {
                    stockNumber = 0;
                }

                if (stockNumber === 0) {
                    stockEl.textContent = "Out Stock";
                    stockEl.classList.remove("text-green-600");
                    stockEl.classList.add("text-red-600");
                } else {
                    stockEl.textContent = `${stockNumber} Available`;
                    stockEl.classList.remove("text-red-600");
                    stockEl.classList.add("text-green-600");
                }
            }

            checkStock();
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
            <div class="flex items-left text-[14.5px]">
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
            <span class="text-gray-600 text-sm">({{ $reviewsCount }} Reviews)</span>
        </div>

        <div class="flex items-center mb-3">
            <span class="font-medium text-gray-800 mr-2">Brand:</span>
            <span
                class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm">{{ $product->brand ? $product->brand : 'None' }}</span>
        </div>

        <div class="flex items-center mb-2">
            <span class="font-medium text-gray-800 mr-2">Stock:</span>
            <span id="stockText" class="text-red-600 font-semibold stock">Out Stock</span>
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
                                    class="px-3 py-1 border rounded cursor-pointer text-sm variant-box hover:bg-[{{ $theme->theme_bg }}] hover:text-white">
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
                <input type="number" min="1" value="1"
                    class="w-16 text-center border-gray-300 focus:outline-none quantity-input">
                <button type="button"
                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold quantity-increase">+</button>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex items-center gap-3">
                <span class="text-2xl font-bold text-[{{ $theme->theme_bg }}]"
                    data-base-price="{{ $product->new_price }}" id="finalPrice">৳{{ $product->new_price }}.00</span>
                @if ($product->old_price)
                    <span class="text-gray-400 line-through text-lg" data-old-price="{{ $product->old_price }}"
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
            <form id="globalCartForm" method="POST" class="w-full sm:w-1/2">
                @csrf
                <input type="hidden" name="image" id="cartImage">
                <input type="hidden" name="variant[]" class="cart-variant">
                <input type="hidden" id="cartVariantId" name="cartVariantId">
                <input id="quantity" type="hidden" name="quantity" value="1" class="quantity-input">
                <input type="hidden" name="sales_price" id="cart_sales_price" value="0">
                <input type="hidden" name="product_id" id="cart_product_id">
                <button type="button" data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}" data-product-price="{{ $product->new_price }}"
                    class="CartBtn w-full bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-white font-semibold py-2.5 rounded transition duration-200">
                    <i class="ri-shopping-cart-line"></i>
                    কার্টে রাখুন
                </button>
            </form>

            <form id="globalBuyNowForm" method="POST" class="w-full sm:w-1/2">
                @csrf
                <input type="hidden" name="image" id="buyNowImage">
                <input type="hidden" id="buyNowVariantId" name="buyNowVariantId">
                <input type="hidden" name="variant[]" class="buy-now-variant">
                <input id="quantity" type="hidden" name="quantity" value="1" class="quantity-input">
                <input type="hidden" name="product_id" id="bn_product_id">
                <input type="hidden" name="sales_price" id="bn_sales_price" value="0">
                <button type="button" data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}" data-product-price="{{ $product->new_price }}"
                    class="orderNowBtn w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded transition duration-200">
                    <i class="ri-shopping-bag-line"></i>
                    অর্ডার করুন
                </button>
            </form>
        </div>
    </div>

    <div id="resellerCartPriceModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 xp-2">

        <div class="bg-white rounded-lg w-full md:max-w-md p-6">
            <h3 class="text-lg font-semibold mb-2" id="modalcartProductName"></h3>

            <p class="text-sm text-gray-600 mb-1">
                Original Price: ৳ <span id="modalcartOriginalPrice"></span>
            </p>

            <div class="mt-3">
                <label class="text-sm font-medium">Your Sales Price</label>
                <input type="number" id="modalcartSalesPrice"
                    class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 mt-1"
                    placeholder="Enter sales price" min="0">
            </div>

            <p class="mt-2 text-sm">
                Profit:
                <span class="font-semibold text-green-600">
                    ৳ <span id="modalcartProfit">0</span>
                </span>
            </p>

            <div class="flex gap-2 mt-4">
                <button onclick="closeResellerCartModal()" class="flex-1 border rounded py-2">
                    Cancel
                </button>

                <button onclick="confirmCart()" class="flex-1 bg-green-600 text-white rounded py-2">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <div id="resellerPriceModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 xp-2">

        <div class="bg-white rounded-lg w-full md:max-w-md p-6">
            <h3 class="text-lg font-semibold mb-2" id="modalProductName"></h3>

            <p class="text-sm text-gray-600 mb-1">
                Original Price: ৳ <span id="modalOriginalPrice"></span>
            </p>

            <div class="mt-3">
                <label class="text-sm font-medium">Your Sales Price</label>
                <input type="number" id="modalSalesPrice"
                    class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
                text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 mt-1"
                    placeholder="Enter sales price" min="0">
            </div>

            <p class="mt-2 text-sm">
                Profit:
                <span class="font-semibold text-green-600">
                    ৳ <span id="modalProfit">0</span>
                </span>
            </p>

            <div class="flex gap-2 mt-4">
                <button onclick="closeResellerModal()" class="flex-1 border rounded py-2">
                    Cancel
                </button>

                <button onclick="confirmBuyNow()" class="flex-1 bg-green-600 text-white rounded py-2">
                    Continue
                </button>
            </div>
        </div>
    </div>

    @if (isset($product))
        <script>
            (function() {

                var value = {{ $product->new_price }};
                var ids = ['{{ $product->id }}'];
                var quantity = 1;

                // --- GTM ---
                if (window.dataLayer) {
                    dataLayer.push({
                        event: 'ViewContent',
                        content_ids: ids,
                        content_name: '{{ $product->name }}',
                        content_type: 'product',
                        value: value,
                        currency: 'BDT',
                        quantity: quantity
                    });
                }

                // --- Pixel ---
                if (typeof fbq === 'function') {
                    fbq('track', 'ViewContent', {
                        content_ids: ids,
                        content_name: '{{ $product->name }}',
                        content_type: 'product',
                        value: value,
                        currency: 'BDT',
                        quantity: quantity
                    });
                }

            })();
        </script>
    @endif

    @if (isset($product))
        <script>
            document.getElementById('addToCartBtn').addEventListener('click', function() {

                var qty = parseInt(document.querySelector('.quantity-input').value) || 1;
                var value = {{ $product->new_price }} * qty;

                // --- GTM ---
                if (window.dataLayer) {
                    dataLayer.push({
                        event: 'AddToCart',
                        content_ids: ['{{ $product->id }}'],
                        content_name: '{{ $product->name }}',
                        content_type: 'product',
                        value: value,
                        currency: 'BDT',
                        quantity: qty
                    });
                }

                // --- Pixel ---
                if (typeof fbq === 'function') {
                    fbq('track', 'AddToCart', {
                        content_ids: ['{{ $product->id }}'],
                        content_name: '{{ $product->name }}',
                        content_type: 'product',
                        value: value,
                        currency: 'BDT',
                        quantity: qty
                    });
                }
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantBoxes = document.querySelectorAll('.variant-box');

            variantBoxes.forEach(box => {
                box.addEventListener('click', () => {
                    const attrName = box.parentElement.querySelector('span').innerText.replace(':',
                        '').trim();

                    box.parentElement.querySelectorAll('.variant-box').forEach(b => {
                        b.classList.remove('bg-[{{ $theme->theme_bg }}]', 'text-white');
                    });

                    box.classList.add('bg-[{{ $theme->theme_bg }}]', 'text-white');

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

            const finalPriceEl = document.getElementById('finalPrice');
            const oldPriceEl = document.getElementById('oldPrice');
            const savePriceEl = document.getElementById('savePrice');

            function getCurrentStock() {
                const stockEl = document.querySelector('.stock');
                if (!stockEl) return 0;

                const stockText = stockEl.textContent || '';
                const match = stockText.match(/\d+/); // শুধু number নেবে
                return match ? parseInt(match[0]) : 0;
            }

            function updateFormQuantity(value) {
                document.querySelectorAll('form input.quantity-input[type="hidden"]').forEach(hidden => {
                    hidden.value = value;
                });
                updatePriceDisplay(value);
            }

            function updatePriceDisplay(qty) {
                const basePrice = parseFloat(finalPriceEl.getAttribute('data-base-price')) || 0;
                const oldPrice = parseFloat(oldPriceEl.getAttribute('data-old-price')) || 0;

                const totalPrice = basePrice * qty;
                finalPriceEl.textContent = `৳${totalPrice.toFixed(2)}`;

                if (oldPrice > 0 && oldPrice > basePrice) {
                    oldPriceEl.textContent = `৳${(oldPrice * qty).toFixed(2)}`;
                    savePriceEl.textContent = `Save ৳-${((oldPrice - basePrice) * qty).toFixed(2)}`;
                }
            }

            function syncQuantityInput() {
                const maxStock = getCurrentStock();
                let val = parseInt(quantityInput.value) || 1;
                if (val > maxStock) val = maxStock;
                if (val < 1) val = 1;
                quantityInput.value = val;
                updateFormQuantity(val);
            }

            decreaseBtn.addEventListener('click', () => {
                let val = parseInt(quantityInput.value) || 1;
                if (val > 1) val--;
                quantityInput.value = val;
                updateFormQuantity(val);
            });

            increaseBtn.addEventListener('click', () => {
                const maxStock = getCurrentStock();
                let val = parseInt(quantityInput.value) || 1;
                if (val < maxStock) val++;
                quantityInput.value = val;
                updateFormQuantity(val);
            });

            quantityInput.addEventListener('input', () => {
                syncQuantityInput();
            });

            const variantContainer = document.getElementById('desktopProduct');
            variantContainer.addEventListener('click', (e) => {
                if (e.target.tagName === 'IMG') {
                    setTimeout(syncQuantityInput, 50);
                }
            });

            syncQuantityInput();
        });
    </script>

    <div class="md:col-span-3 col-span-12 bg-gray-50 flex flex-col border-l border-gray-50">

        <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100">
            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">💬 Need Help?</h2>
            <p class="text-sm text-gray-700">📞 Call us at <span
                    class="font-medium text-[{{ $theme->theme_bg }}]">{{ $setting->phone }}</span>
            </p>
            <p class="text-sm text-gray-700 mt-1">📧 Email: <span
                    class="text-[{{ $theme->theme_bg }}]">{{ $setting->email }}</span>
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
                    <span class="font-semibold text-[{{ $theme->theme_bg }}]">৳{{ $inDhakaCharge }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Outside Dhaka:</span>
                    <span class="font-semibold text-[{{ $theme->theme_bg }}]">৳{{ $outDhakaCharge }}</span>
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
                                src="{{ asset('public/upload/user/219969.png') }}" alt="Reviewer">
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
                                @if (strlen($review->review) > 200)
                                    <button id="seeMoreBtn-{{ $review->id }}"
                                        class="text-[{{ $theme->theme_bg }}] font-semibold text-sm"
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
                        <img loading="lazy"
                            src="{{ asset('public/uploads/products/' . $product->images->first()->image) }}"
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
                        <p class="text-[{{ $theme->theme_bg }}] font-bold mb-2 text-left text-[14.5px]">
                            &#2547;{{ $product->new_price }}
                            @if ($product->old_price)
                                <span
                                    class="line-through text-gray-400 text-[14px]">&#2547;{{ $product->old_price }}</span>
                            @endif
                        </p>
                        <form id="globalBuyNowForm" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="sales_price" id="bn_sales_price" value="0">
                            <input type="hidden" name="product_id" id="bn_product_id">
                            <input type="hidden" name="image"
                                value="{{ asset('public/uploads/products/' . $product->images->first()->image) }}">
                            <button type="button" data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->new_price }}"
                                class="orderNowBtn bg-[{{ $theme->theme_bg }}]/90 hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] px-2 py-2 rounded w-full text-[14.5px]">
                                <i class="ri-shopping-bag-line"></i>
                                অর্ডার করুন
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    let cartBasePrice = 0;
    let cartCurrentProductId = null;
    let currentCartForm = null;

    document.querySelectorAll('.CartBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.productId;
            const name = this.dataset.productName;
            const price = Number(this.dataset.productPrice);

            const form = this.closest('form');

            handleCartOrder(id, name, price, form);
        });
    });

    function handleCartOrder(id, name, price, form) {
        @if (auth()->guard('reseller')->check())
            cartCurrentProductId = id;
            cartBasePrice = price;
            currentCartForm = form;

            const productNameEl = document.getElementById('modalcartProductName');
            const originalPriceEl = document.getElementById('modalcartOriginalPrice');
            const salesPriceInput = document.getElementById('modalcartSalesPrice');
            const profitEl = document.getElementById('modalcartProfit');

            if (productNameEl) productNameEl.innerText = name;
            if (originalPriceEl) originalPriceEl.innerText = price;
            if (salesPriceInput) salesPriceInput.value = '';
            if (profitEl) profitEl.innerText = 0;

            openCartResellerModal();
        @else
            submitCart(id, price, form);
        @endif
    }

    function openCartResellerModal() {
        const modal = document.getElementById('resellerCartPriceModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeCartResellerModal() {
        const modal = document.getElementById('resellerCartPriceModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    const salesPriceInput = document.getElementById('modalcartSalesPrice');
    if (salesPriceInput) {
        salesPriceInput.addEventListener('input', function() {
            const profitEl = document.getElementById('modalcartProfit');
            const profit = this.value - cartBasePrice;
            if (profitEl) profitEl.innerText = profit > 0 ? profit : 0;
        });
    }

    function confirmCart() {
        const salesPriceEl = document.getElementById('modalcartSalesPrice');
        if (!salesPriceEl) return alert("Sales price input not found!");

        const salesPrice = Number(salesPriceEl.value);
        if (!salesPrice || salesPrice < cartBasePrice) {
            return alert('Sales price must be greater than original price');
        }

        submitCart(cartCurrentProductId, salesPrice, currentCartForm);
        closeCartResellerModal();
    }

    function submitCart(id, price, form) {
        if (!form) {
            console.error("Add to Cart form not found!");
            return;
        }

        const productInput = form.querySelector('input[name="product_id"]');
        const salesPriceInput = form.querySelector('input[name="sales_price"]');

        if (!productInput || !salesPriceInput) {
            console.error("Hidden inputs not found in the form!");
            return;
        }

        productInput.value = id;
        salesPriceInput.value = price;

        form.action = "{{ url('cart/add') }}/" + id;
        form.submit();
    }
</script>

<script>
    let basePrice = 0;
    let currentProductId = null;

    document.querySelectorAll('.orderNowBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.productId;
            const name = this.dataset.productName;
            const price = Number(this.dataset.productPrice);

            const form = this.closest('form');

            handleOrder(id, name, price, form);
        });
    });

    function handleOrder(id, name, price, form) {
        @if (auth()->guard('reseller')->check())
            currentProductId = id;
            basePrice = price;

            document.getElementById('modalProductName').innerText = name;
            document.getElementById('modalOriginalPrice').innerText = price;
            document.getElementById('modalSalesPrice').value = '';
            document.getElementById('modalProfit').innerText = 0;

            openResellerModal();

            window.currentBuyNowForm = form;
        @else
            submitOrder(id, price, form);
        @endif
    }

    function openResellerModal() {
        const modal = document.getElementById('resellerPriceModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeResellerModal() {
        const modal = document.getElementById('resellerPriceModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('modalSalesPrice')?.addEventListener('input', function() {
        let profit = this.value - basePrice;
        document.getElementById('modalProfit').innerText = profit > 0 ? profit : 0;
    });

    function confirmBuyNow() {
        const salesPrice = Number(document.getElementById('modalSalesPrice').value);

        if (!salesPrice || salesPrice < basePrice) {
            alert('Sales price must be greater than original price');
            return;
        }

        submitOrder(currentProductId, salesPrice, window.currentBuyNowForm);
    }

    function submitOrder(id, price, form) {
        if (!form) {
            console.error("Buy Now form not found!");
            return;
        }

        form.querySelector('#bn_product_id').value = id;
        form.querySelector('#bn_sales_price').value = price;

        form.action = "{{ url('checkout/buy-now') }}/" + id;
        form.submit();
    }
</script>

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
