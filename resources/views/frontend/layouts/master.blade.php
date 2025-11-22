<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        $favicon = $setting->favicon;
        $logo = $setting->icon;
    @endphp
    @if ($favicon && file_exists(public_path($favicon)))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
    @endif
    <title>{{ $setting->meta_title ?? 'Bangladesh Technical Education Institute' }}</title>
    @if (!empty($setting->meta_desc))
        <meta name="description" content="{{ $setting->meta_desc }}">
    @endif
    @if (!empty($setting->meta_tag) && is_array($setting->meta_tag))
        <meta name="keywords" content="{{ implode(', ', $setting->meta_tag) }}">
    @endif
    <style>
        body {
            font-family: 'Roboto', 'Poppins', sans-serif;
        }

        .scroll-hidden::-webkit-scrollbar {
            display: none;
        }

        .category-scroll {
            scroll-behavior: smooth;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .search-box {
            scroll-behavior: smooth;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

@include('massage.index')

<body class="bg-gray-100 text-gray-800">

    <div class="bg-gray-800 w-full">
        <div class="max-w-6xl mx-auto flex items-center py-2">
            <marquee class="text-white text-sm leading-tight">
                Gadget BD অনলাইন শপে আপনাকে স্বাগতম || অনলাইনে আস্থা ও বিশ্বস্ততার সাথে সারা বাংলাদেশে হোম ডেলিভারী
                দিয়ে থাকি অর্ডার করতে অগ্রিম টাকা দিতে হবে না এ্যাডভান্স বিকাশ পেমেন্টে ৫% ডিসকাউন্ট ৩-৫ দিনে সারাদেশে
                হোম ডেলিভারী দেওয়া হয় ক্যাশঅন ডেলিভারীর সুবিধা রয়েছে, তাই অর্ডার করুন নিশ্চিন্তে ধন্যবাদ
            </marquee>
        </div>
    </div>

    <div class="sticky top-0 z-50 ">
        <header class="bg-white shadow-sm hidden md:block relative">
            <div class="max-w-6xl mx-auto py-4 flex items-center justify-between">
                <!-- Logo -->
                <h1 onclick="window.location.href='/'"
                    class="text-2xl font-bold text-orange-600 flex items-center gap-1 cursor-pointer">
                    <img class="max-w-48 w-auto h-16" src="{{ asset($logo) }}" alt="">
                </h1>

                <!-- Search Bar -->
                <div id="searchEngine" class="relative flex items-center justify-center mx-6 w-[500px] lg:w-[600px]">
                    <input id="searchInput" type="text" name="search"
                        placeholder="Search in {{ $setting->name }}..."
                        class="w-full px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:border-orange-500 focus:ring-0 transition-colors duration-200">
                    <button
                        class="bg-orange-500 border border-orange-500 text-white px-4 py-2 rounded-r-md hover:bg-orange-600">
                        <i class="ri-search-line"></i>
                    </button>

                    <div id="searchBox" data-lenis-disabled
                        class="search-box absolute left-0 top-full mt-2 bg-white shadow-md border border-gray-200 rounded-md max-h-80 overflow-y-auto hidden">
                        <!-- JS will populate products here -->
                    </div>
                </div>

                <!-- Cart + Tracking -->
                <div class="flex items-center gap-5">

                    <!-- Tracking Order -->
                    <a href="/order/tracking"
                        class="flex items-center gap-1 text-gray-700 hover:text-orange-600 font-medium">
                        <i class="ri-map-pin-line text-xl"></i>
                        <span class="font-normal">Tracking Order</span>
                    </a>

                    <!-- Shopping Cart -->
                    <div class="relative cursor-pointer" onclick="window.location.href='/shipping/cart'">
                        <i
                            class="ri-shopping-cart-line  text-xl text-gray-700 hover:text-orange-600 cursor-pointer text-2xl"></i>
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 font-semibold">
                            {{ count(session('cart', [])) }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- ================= {{ $setting->name }} MOBILE HEADER ================= -->
        <header class="bg-white shadow-sm w-full z-50 md:hidden relative">
            <!-- Top Bar: Menu, Logo, Cart -->
            <div class="flex items-center justify-between px-4 py-4">
                <!-- ☰ Menu Button -->
                <button class="mobileMenuBtn text-gray-700 text-2xl hover:text-orange-500">
                    <i class="ri-menu-line"></i>
                </button>

                <!-- 🛍️ Logo -->
                <a href="/" class="flex items-center gap-1 text-orange-600 font-bold text-xl">
                    <img class="max-w-48 w-auto h-12"
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Daraz_Logo.png/1200px-Daraz_Logo.png"
                        alt="">
                </a>

                <!-- 🛒 Cart Icon -->
                <div class="relative" onclick="window.location.href='/shipping/cart'">
                    <i class="ri-shopping-cart-line text-2xl text-gray-700 hover:text-orange-500 cursor-pointer"></i>
                    <span
                        class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-xs rounded-full px-1.5 font-semibold">
                        {{ count(session('cart', [])) }}
                    </span>
                </div>
            </div>

            <!-- 🔍 Search Bar -->
            <div class="px-4 pb-4">
                <div id="MobilesearchEngine" class="relative flex items-center bg-gray-100 rounded bg-white">
                    <input id="MobilesearchInput" type="text" placeholder="Search products..."
                        class="w-full bg-[transparent] px-3 py-2 outline-none rounded-l ring-1 ring-offset-1 ring-gray-200 text-sm text-gray-700 transition-colors duration-200
                focus:outline-none focus:ring-1 focus:ring-orange-500 focus:ring-offset-1">
                    <button class="bg-orange-500 px-3 py-2 text-white hover:bg-orange-600 rounded-r">
                        <i class="ri-search-line"></i>
                    </button>
                    <div id="MobilesearchBox" data-lenis-disabled
                        class="search-box absolute left-0 top-full mt-2 bg-white shadow-md border border-gray-200 rounded-md max-h-96 overflow-y-auto hidden">
                        <!-- JS will populate products here -->
                    </div>
                </div>
            </div>
        </header>


        <!-- 📂 Mobile Dropdown Menu (Hidden by default) -->
        <div id="mobileMenu"
            class="fixed h-full w-72 left-0 top-0 bg-white border-t border-gray-200 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <nav class="flex flex-col text-gray-700 text-sm h-full">
                <!-- Header -->
                <div
                    class="flex items-center justify-between px-4 py-2 border-b border-gray-200 sticky top-0 bg-white z-50">
                    <img class="max-w-48 w-auto h-10"
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Daraz_Logo.png/1200px-Daraz_Logo.png"
                        alt="">
                    <button id="closeCategorySidebar" class="text-gray-600 hover:text-orange-500">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <!-- Category List with Smooth Subcategories -->
                <ul class="flex flex-col divide-y divide-gray-200 overflow-auto">
                    @foreach ($allcategories as $category)
                        <li class="flex flex-col">
                            <!-- Main Category -->
                            <div class="flex items-center justify-between px-4 py-3 hover:bg-orange-50 cursor-pointer"
                                onclick="window.location.href='{{ route('category.product', $category->slug) }}'">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($category->image ?? 'default-category.png') }}"
                                        alt="{{ $category->name }}" class="w-8 h-8 object-cover rounded">
                                    <span class="text-gray-700 font-medium">{{ $category->name }}</span>
                                </div>
                                @if ($category->subcategories->count())
                                    <i class="ri-arrow-down-s-line text-gray-500 text-xl"
                                        onclick="event.stopPropagation(); toggleSubcategory(this)"></i>
                                @endif
                            </div>

                            <!-- Subcategory List -->
                            @if ($category->subcategories->count())
                                <ul
                                    class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out flex-col divide-y divide-gray-200 bg-gray-50">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li class="flex items-center gap-3 px-8 py-3 hover:bg-orange-100 cursor-pointer"
                                            onclick="window.location.href='{{ route('subcategory.product', $subcategory->slug) }}'">
                                            <span class="text-gray-600 text-sm">{{ $subcategory->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <!-- Desktop Navigation Bar -->
        <div class="bg-gray-800 w-full hidden sm:block">
            <div class="max-w-6xl mx-auto flex items-center justify-between h-12">
                <!-- Left: All Categories -->
                <div id="categoryButton"
                    class="mobileMenuBtn flex items-center justify-between gap-2 bg-orange-600 px-3 h-full cursor-pointer hover:bg-orange-700 transition">
                    <span class="text-white font-medium text-[14.5px] uppercase">All Categories</span>
                    <i class="ri-menu-line text-white text-lg"></i>
                </div>

                <!-- Right: Nav Links -->
                <div class="flex items-center gap-6">
                    <a href="{{ url('/') }}"
                        class="text-white text-[14.5px] hover:text-orange-500 transition">Home</a>
                    <a href="{{ url('/your/shop') }}"
                        class="text-white text-[14.5px] hover:text-orange-500 transition">Shop</a>
                    <a href="{{ url('deals') }}"
                        class="text-white text-[14.5px] hover:text-orange-500 transition">Deals</a>
                    <a href="{{ url('/contact') }}"
                        class="text-white text-[14.5px] hover:text-orange-500 transition">Contact</a>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- =================== {{ $setting->name }} FOOTER =================== -->

    <!-- =================== {{ $setting->name }} FOOTER =================== -->
    <footer class="bg-gray-900 text-gray-300 pt-12 pb-6">
        <div class="max-w-6xl mx-auto px-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

                <!-- Brand Info -->
                <div>
                    <img class="max-w-48 w-auto h-20 mb-4" src="{{ asset($logo) }}" alt="">
                    <p class="text-sm text-gray-400 leading-relaxed mb-4">
                        Your trusted online store for smart gadgets, electronics, fashion and more.
                        Shop confidently — fast delivery, secure payment, and 24/7 customer support.
                    </p>

                    @php
                        $socialStyles = [
                            'Facebook' => [
                                'icon' => 'ri-facebook-fill',
                                'hover' => 'hover:bg-blue-600',
                            ],
                            'Instagram' => [
                                'icon' => 'ri-instagram-line',
                                'hover' => 'hover:bg-pink-500',
                            ],
                            'Twitter' => [
                                'icon' => 'ri-twitter-x-line',
                                'hover' => 'hover:bg-blue-400',
                            ],
                            'YouTube' => [
                                'icon' => 'ri-youtube-fill',
                                'hover' => 'hover:bg-red-600',
                            ],
                            'LinkedIn' => [
                                'icon' => 'ri-linkedin-fill',
                                'hover' => 'hover:bg-blue-700',
                            ],
                            'Pinterest' => [
                                'icon' => 'ri-pinterest-fill',
                                'hover' => 'hover:bg-red-500',
                            ],
                            'WhatsApp API' => [
                                'icon' => 'ri-whatsapp-line',
                                'hover' => 'hover:bg-green-500',
                            ],
                        ];
                    @endphp

                    <div class="flex gap-3 mt-4">
                        @foreach ($socials as $item)
                            @php
                                $style = $socialStyles[$item->name] ?? null;
                            @endphp

                            @if ($style)
                                <a href="{{ $item->link }}" target="_blank"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-800 rounded-full transition {{ $style['hover'] }}">
                                    <i class="{{ $style['icon'] }} text-white text-lg"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Top Categories -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Top Categories</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach ($topCategories as $category)
                            <li><a href="{{ route('category.product', $category->slug) }}"
                                    class="hover:text-orange-400 transition">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Our Services</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-orange-400 transition">Free Shipping</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition">Easy Returns</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition">24/7 Support</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition">Warranty Policy</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition">Affiliate Program</a></li>
                    </ul>
                </div>

                <!-- Newsletter & Payment -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Stay Connected</h3>
                    <p class="text-sm text-gray-400 mb-3">
                        Subscribe to our newsletter for latest product updates, offers & news.
                    </p>
                    <form class="flex bg-gray-800 rounded-lg overflow-hidden mb-3">
                        <input type="email" placeholder="Enter your email"
                            class="w-full px-3 py-2 bg-gray-800 text-gray-300 text-sm focus:outline-none">
                        <button
                            class="bg-orange-500 hover:bg-orange-600 px-4 text-white font-semibold text-sm transition">Join</button>
                    </form>
                    <p class="text-xs text-gray-500 mb-4">We respect your privacy. Unsubscribe anytime.</p>

                    <h3 class="text-lg font-semibold text-white mb-2">Payment Methods</h3>
                    <div class="flex gap-3 mt-2">
                        <img src="https://www.projapotishop.com/public/frontEnd/images/payment2.png" alt="Visa"
                            class="w-72">
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-700 my-6"></div>

            <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-400">
                <p>© {{ date('Y') }} <span class="text-white font-semibold">{{ $setting->name }}</span> — All
                    rights reserved.
                </p>
                <div class="flex flex-wrap justify-center gap-4 mt-3 sm:mt-0">
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-orange-400 transition">Privacy
                        Policy</a>
                    <a href="{{ url('/terms-and-conditions') }}" class="hover:text-orange-400 transition">Terms of
                        Use</a>
                    <a href="{{ url('/help-center') }}" class="hover:text-orange-400 transition">Help Center</a>
                    <a href="{{ url('/order/tracking') }}" class="hover:text-orange-400 transition">Track Order</a>
                </div>
            </div>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBox = document.getElementById('searchBox');

            async function handleSearch() {
                const query = searchInput.value.trim();
                if (query.length === 0) {
                    searchBox.classList.add('hidden');
                    searchBox.innerHTML = '';
                    return;
                }

                try {
                    const response = await fetch(`/search/products?query=${encodeURIComponent(query)}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const products = await response.json();

                    searchBox.innerHTML = '';
                    if (products.length === 0) {
                        searchBox.innerHTML =
                            `<div class="p-4 text-center text-gray-500">Products not found</div>`;
                    } else {
                        products.forEach(product => {

                            const imageUrl = product.image ?
                                `/uploads/products/${product.image}` :
                                '/uploads/products/placeholder.jpg';

                            const item = document.createElement('div');
                            item.className =
                                "flex items-center justify-between p-3 hover:bg-gray-50 border-b border-gray-50 cursor-pointer";
                            item.innerHTML = `
                        <div class="flex items-center gap-3">
                            <img src="${imageUrl}" alt="Product" class="w-10 h-10 object-cover rounded-full">
                            <div>
                                <p class="text-gray-800 line-clamp-1 mb-0.5">${product.name}</p>
                                <p class="text-gray-500 text-sm">&#2547;${product.price}</p>
                            </div>
                        </div>
                        <div class="text-gray-500 text-xl">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                    `;
                            item.addEventListener('click', () => {
                                window.location.href = `/product/${product.slug}`;
                            });
                            searchBox.appendChild(item);
                        });
                    }
                    searchBox.classList.remove('hidden');
                } catch (error) {
                    searchBox.innerHTML =
                        `<div class="p-4 text-center text-red-500">Error loading products</div>`;
                    searchBox.classList.remove('hidden');
                    console.error(error);
                }
            }

            // Debounce function to limit AJAX calls
            function debounce(func, delay = 300) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                }
            }

            searchInput.addEventListener('input', debounce(handleSearch, 300));

            // Hide dropdown on click outside
            document.addEventListener('click', (e) => {
                if (!document.getElementById('searchEngine').contains(e.target)) {
                    searchBox.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const MobilesearchInput = document.getElementById('MobilesearchInput');
            const MobilesearchBox = document.getElementById('MobilesearchBox');

            async function handleSearch() {
                const query = MobilesearchInput.value.trim();
                if (query.length === 0) {
                    MobilesearchBox.classList.add('hidden');
                    MobilesearchBox.innerHTML = '';
                    return;
                }

                try {
                    const response = await fetch(`/search/products?query=${encodeURIComponent(query)}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const products = await response.json();

                    MobilesearchBox.innerHTML = '';
                    if (products.length === 0) {
                        MobilesearchBox.innerHTML =
                            `<div class="p-4 text-center text-gray-500">Products not found</div>`;
                    } else {
                        products.forEach(product => {

                            const imageUrl = product.image ?
                                `/uploads/products/${product.image}` :
                                '/uploads/products/placeholder.jpg';

                            const item = document.createElement('div');
                            item.className =
                                "flex items-center justify-between p-3 hover:bg-gray-50 border-b border-gray-50 cursor-pointer";
                            item.innerHTML = `
                        <div class="flex items-center gap-3">
                            <img src="${imageUrl}" alt="Product" class="w-10 h-10 object-cover rounded-full">
                            <div>
                                <p class="text-gray-800 line-clamp-1 mb-0.5">${product.name}</p>
                                <p class="text-gray-500 text-sm">&#2547;${product.price}</p>
                            </div>
                        </div>
                        <div class="text-gray-500 text-xl">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                    `;
                            item.addEventListener('click', () => {
                                window.location.href = `/product/${product.slug}`;
                            });
                            MobilesearchBox.appendChild(item);
                        });
                    }
                    MobilesearchBox.classList.remove('hidden');
                } catch (error) {
                    MobilesearchBox.innerHTML =
                        `<div class="p-4 text-center text-red-500">Error loading products</div>`;
                    MobilesearchBox.classList.remove('hidden');
                    console.error(error);
                }
            }

            // Debounce function to limit AJAX calls
            function debounce(func, delay = 300) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                }
            }

            MobilesearchInput.addEventListener('input', debounce(handleSearch, 300));

            // Hide dropdown on click outside
            document.addEventListener('click', (e) => {
                if (!document.getElementById('MobilesearchEngine').contains(e.target)) {
                    searchBox.classList.add('block');
                }
            });
        });
    </script>

    <script>
        function toggleSubcategory(icon) {
            const subList = icon.closest('li').querySelector('ul');
            if (!subList) return;

            if (subList.style.maxHeight && subList.style.maxHeight !== '0px') {
                // slide up
                subList.style.maxHeight = '0px';
                icon.classList.remove('ri-arrow-up-s-line');
                icon.classList.add('ri-arrow-down-s-line');
            } else {
                // slide down
                subList.style.maxHeight = subList.scrollHeight + 'px';
                icon.classList.remove('ri-arrow-down-s-line');
                icon.classList.add('ri-arrow-up-s-line');
            }
        }

        // Optional: Reset all sublists on page load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('ul > li > ul').forEach(ul => {
                ul.style.maxHeight = '0px';
            });
        });
    </script>

    <script>
        const categoryButton = document.getElementById('categoryButton');
        const categoryList = document.getElementById('categoryList');

        function syncCategoryWidth() {
            if (categoryList && categoryButton) {
                const width = categoryList.offsetWidth;
                categoryButton.style.width = width + 'px';
            }
        }

        syncCategoryWidth();

        window.addEventListener('resize', syncCategoryWidth);

        const observer = new ResizeObserver(syncCategoryWidth);
        observer.observe(categoryList);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBox = document.getElementById('searchBox');

            function syncSearchBoxWidth() {
                if (searchInput && searchBox) {
                    const width = searchInput.getBoundingClientRect().width;
                    searchBox.style.width = width + 'px';
                }
            }

            setTimeout(() => {
                requestAnimationFrame(syncSearchBoxWidth);
            }, 100);

            window.addEventListener('resize', syncSearchBoxWidth);

            const observer = new ResizeObserver(syncSearchBoxWidth);
            observer.observe(searchInput);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoryScroll').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 1000,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 3
                    },
                    640: {
                        items: 4
                    },
                    768: {
                        items: 5
                    },
                    1024: {
                        items: 7
                    },
                    1280: {
                        items: 8
                    }
                }
            });

            $('#hotdealScroll').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 2000,
                smartSpeed: 1000,
                autoplayHoverPause: true,
                stagePadding: 5,
                responsive: {
                    0: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 4
                    },
                    1024: {
                        items: 5
                    }
                },
            });

            $('#banner').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 2000,
                smartSpeed: 1000,
                autoplayHoverPause: true,
                stagePadding: 0,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    1024: {
                        items: 1
                    }
                },
            });

            $('#desktopProduct').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplaySpeed: 2000,
                smartSpeed: 1000,
                autoplayHoverPause: true,
                stagePadding: 0,
                responsive: {
                    0: {
                        items: 5
                    },
                    480: {
                        items: 5
                    },
                    768: {
                        items: 5
                    },
                    1024: {
                        items: 5
                    }
                },
            });

            $(document).ready(function() {
                var owl = $('#phoneProduct');
                owl.owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: false,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplaySpeed: 2000,
                    smartSpeed: 1000,
                    autoplayHoverPause: true,
                    stagePadding: 0,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        768: {
                            items: 1
                        },
                        1024: {
                            items: 1
                        }
                    },
                    onInitialized: updateCounter,
                    onTranslated: updateCounter
                });

                function updateCounter(event) {
                    var element = event.target;
                    var items = event.item.count;
                    var item = event.item.index - event.relatedTarget._clones.length / 2;
                    if (item > items || item === 0) {
                        item = items;
                    }
                    $('#productCounter').text(item + ' / ' + items);
                }
            });

        });
    </script>

    <script>
        document.getElementById('categoryButton').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        // Multiple buttons by class
        const menuBtns = document.querySelectorAll('.mobileMenuBtn'); // note: class, not id
        const menu = document.getElementById('mobileMenu');
        const categoryCloseBtn = document.getElementById('closeCategorySidebar');

        function openMenu() {
            menu.style.transform = 'translateX(0)';
        }

        function closeMenu() {
            menu.style.transform = 'translateX(-100%)';
        }

        // Loop through all buttons and attach click
        menuBtns.forEach(btn => {
            btn.addEventListener('click', openMenu);
        });

        categoryCloseBtn.addEventListener('click', closeMenu);

        // Close menu if click outside
        document.addEventListener('click', function(event) {
            let clickedInsideMenuBtn = false;
            menuBtns.forEach(btn => {
                if (btn.contains(event.target)) clickedInsideMenuBtn = true;
            });

            if (!menu.contains(event.target) && !clickedInsideMenuBtn) {
                closeMenu();
            }
        });

        // Subcategory toggle
        function toggleSubcategory(icon) {
            const subList = icon.closest('li').querySelector('ul');
            if (!subList) return;

            if (subList.style.maxHeight && subList.style.maxHeight !== '0px') {
                // slide up
                subList.style.maxHeight = '0px';
                icon.classList.remove('ri-arrow-up-s-line');
                icon.classList.add('ri-arrow-down-s-line');
            } else {
                // slide down
                subList.style.maxHeight = subList.scrollHeight + 'px';
                icon.classList.remove('ri-arrow-down-s-line');
                icon.classList.add('ri-arrow-up-s-line');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('ul > li > ul').forEach(ul => {
                ul.style.maxHeight = '0px';
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const timer = document.getElementById("hot-deal-timer");
            if (!timer) return;

            const endDate = new Date(timer.dataset.endDate).getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance <= 0) {
                    document.getElementById("hours").textContent = "00";
                    document.getElementById("minutes").textContent = "00";
                    document.getElementById("seconds").textContent = "00";
                    clearInterval(timerInterval);
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
            }

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const lenis = new Lenis({
                duration: 1.2,
                smooth: true
            });

            const searchBox = document.getElementById('searchBox');
            if (searchBox) {
                searchBox.addEventListener('wheel', (e) => {
                    e.stopPropagation();
                });
                searchBox.addEventListener('touchmove', (e) => {
                    e.stopPropagation();
                });
            }

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (sessionStorage.getItem('shippingCharge')) {
                return;
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                iziToast.warning({
                    title: 'Not Supported',
                    message: "Your browser doesn't support Geolocation.",
                    position: 'topRight'
                });
            }

            function successCallback(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                checkIfInsideDhaka(latitude, longitude);
            }

            function errorCallback(error) {
                iziToast.warning({
                    title: 'Location Needed',
                    message: 'Please enable your location to continue.',
                    position: 'topRight'
                });
            }

            function checkIfInsideDhaka(lat, lon) {
                const dhakaBounds = {
                    minLat: 23.60,
                    maxLat: 23.90,
                    minLon: 90.30,
                    maxLon: 90.50
                };
                const inDhakaCharge = @json($inDhakaCharge);
                const outDhakaCharge = @json($outDhakaCharge);

                let charge = 0;
                let area = '';

                if (lat >= dhakaBounds.minLat && lat <= dhakaBounds.maxLat &&
                    lon >= dhakaBounds.minLon && lon <= dhakaBounds.maxLon) {

                    iziToast.success({
                        title: 'Inside Dhaka',
                        message: 'Welcome! You are within Dhaka city.',
                        position: 'topRight'
                    });
                    charge = inDhakaCharge;
                    area = 'inside_dhaka';

                } else {

                    iziToast.info({
                        title: 'Outside Dhaka',
                        message: 'You are outside Dhaka area.',
                        position: 'topRight'
                    });
                    charge = outDhakaCharge;
                    area = 'outside_dhaka';
                }

                sessionStorage.setItem('shippingCharge', charge);
                sessionStorage.setItem('shippingArea', area);
                sessionStorage.setItem('locationMessageShown', 'true');

                fetch("{{ route('set.shipping.charge') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        charge: charge,
                        area: area
                    })
                });
            }
        });
    </script>

</body>

</html>
