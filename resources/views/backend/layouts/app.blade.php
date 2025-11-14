<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script type="module" src="https://cdn.jsdelivr.net/npm/your-app/dist/app.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/your-app/dist/app.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    @php
        $favicon = $setting->favicon;
    @endphp
    @if ($favicon && file_exists(public_path($favicon)))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
    @endif
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url('Roboto/Roboto-Regular.woff2') format('woff2');
            font-weight: 600;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        .scrollhidden::-webkit-scrollbar {
            display: none;
        }

        .scrollhidden {
            scrollbar-width: none;
        }

        .scrollhidden {
            -ms-overflow-style: none;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.open {
            max-height: 200px;
        }

        .active {
            background-color: #3b3f5c;
            color: #ffffff;
        }

        .scroll-bar::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-bar::-webkit-scrollbar-track {
            background: #2a2f45;
        }

        .scroll-bar::-webkit-scrollbar-thumb {
            background-color: #444c65;
            border-radius: 3px;
        }

        .scroll-bar {
            scrollbar-width: thin;
        }
    </style>
</head>

@include('massage.index')

<body class="bg-white text-gray-200">
    <div class="flex flex-col relative">
        <!-- Header -->
        <div class="header w-full bg-[#2a2f45] z-10 flex items-center fixed top-0 left-0 right-0 print:hidden">
            <div class="md:h-[70px] h-[60px] w-full py-3 md:px-6 px-3 relative flex items-center">
                <div class="flex justify-between w-full items-center">
                    <div class="logo flex flex-row gap-16 hidden md:block">
                        <div class="flex flex-row gap-2 items-center">
                            <img src="https://bttibd.it.com/bteibd/public/upload/side_logo_1760010888.png"
                                alt="Logo" class="w-44 h-auto" />
                        </div>
                    </div>
                    <i id="menuBtn" class="ri-menu-line md:hidden block text-white text-xl font-medium"></i>
                    <div class="flex flex-row items-center gap-5">
                        <div class="relative">
                            <div
                                class="absolute -right-1 -top-0 w-4 h-4 rounded-full bg-red-500 flex items-center justify-center">
                                <span class="text-white text-[10px] leading-none">2</span>
                            </div>
                            <i
                                class="ri-notification-2-line cursor-pointer text-white/80 hover:text-white text-[21px]"></i>
                        </div>
                        <i class="ri-moon-line text-white/80 cursor-pointer hover:text-white text-[21px]"></i>
                        <div id="profile_menu_btn" class="flex items-center flex-row gap-2 cursor-pointer">
                            <img src="{{ asset('/' . auth()->guard('web')->user()->image) }}"
                                alt="{{ auth()->guard('web')->user()->name }}" class="w-10 h-10 rounded-full">
                            <span class="text-white/80 text-[15px]">{{ auth()->guard('web')->user()->name }}</span>
                            <i class="ri-arrow-down-s-line text-white/80"></i>
                        </div>
                        <i class="ri-settings-2-line cursor-pointer text-white/80 hover:text-white text-[21px]"></i>
                    </div>
                </div>
                <div id="profile_menu"
                    class="absolute top-full mt-0 right-0 w-60 bg-[#2a2f45] hidden rounded-b-lg overflow-hidden shadow-lg border border-gray-700">
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 transition duration-300 hover:bg-[#3b3f5c] group">
                        <i class="ri-user-line text-lg text-gray-400 group-hover:text-white"></i>
                        <span class="text-gray-300 group-hover:text-white">Profile</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 px-4 py-2 hover:bg-[#3b3f5c] group w-full text-left">
                            <i class="ri-logout-box-r-line text-lg text-gray-400 group-hover:text-white"></i>
                            <span class="text-gray-300 group-hover:text-white">Logout</span>
                        </button>
                    </form>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-[#3b3f5c] group">
                        <i class="ri-settings-3-line text-lg text-gray-400 group-hover:text-white"></i>
                        <span class="text-gray-300 group-hover:text-white">Site Setting</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="flex pt-[70px] print:p-0">
            <div id="sidebar"
                class="scroll-bar border-t border-gray-700 md:w-[230px] lg:w-[260px] z-50 md:block bg-[#2a2f45] fixed md:top-[70px] top-[60px] bottom-0 overflow-y-auto transition-all duration-500 ease-in-out transform -translate-x-full md:translate-x-0">
                <div class="pb-6 px-1.5 pt-1.5">
                    <ul>
                        <!-- Dashboard -->
                        <li class="group">
                            <a href="{{ route('admin.dashboard') }}"
                                class="mb-1 flex items-center pl-4 py-2.5 rounded
            {{ request()->routeIs('admin.dashboard') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                <i class="ri-dashboard-line mr-2 text-cyan-400"></i>
                                <span class="text-[15px]">Main Dashboard</span>
                            </a>
                        </li>

                        <!-- Order Center -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="orders">
                                <i class="ri-shopping-cart-2-line mr-2 text-indigo-400"></i>
                                <span class="text-[15px]">Order Center</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.orders.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.orders.index') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-list-check mr-2 text-gray-400"></i>All Orders
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('admin.orders.create') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.orders.create') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-add-box-line mr-2 text-green-400"></i>Create Order
                                    </a>
                                </li> --}}
                            </ul>
                        </li>

                        <!-- Product Catalog -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="products">
                                <i class="ri-store-2-line mr-2 text-yellow-400"></i>
                                <span class="text-[15px]">Product Catalog</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.products.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.products.index') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-box-3-line mr-2 text-gray-400"></i>All Products
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.products.create') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.products.create') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-add-box-line mr-2 text-green-400"></i>Add Product
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.products.inventory') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.products.inventory') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-bar-chart-2-line mr-2 text-orange-400"></i>Inventory Tracking
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.order.products') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                {{ request()->routeIs('admin.order.products') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-shopping-bag-3-line mr-2 text-blue-400"></i>Order by Products
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Review & Feedback -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="reviews">
                                <i class="ri-star-smile-line mr-2 text-yellow-400"></i>
                                <span class="text-[15px]">Review & Feedback</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>

                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.reviews.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                {{ request()->routeIs('admin.reviews.index') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-chat-3-line mr-2 text-gray-400"></i>All Reviews
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.reviews.create') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                {{ request()->routeIs('admin.reviews.create') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-add-box-line mr-2 text-green-400"></i>Add Review
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Category Hub -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="categories">
                                <i class="ri-apps-line mr-2 text-purple-400"></i>
                                <span class="text-[15px]">Category Hub</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.categories.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-folder-2-line mr-2 text-gray-400"></i>Main Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.subcategories.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.subcategories.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-shapes-line mr-2 text-green-400"></i>Sub Categories
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Product Attributes -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="product-attributes">
                                <i class="ri-slideshow-3-line mr-2 text-blue-400"></i>
                                <span class="text-[15px]">Product Attributes</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>

                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.attributes.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.attributes*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-stack-line mr-2 text-blue-400"></i>Attribute Groups
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.attribute_values.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded 
                    {{ request()->routeIs('admin.attribute_values*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-price-tag-3-line mr-2 text-teal-400"></i>Attribute Options
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Marketing Suite -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="marketing">
                                <i class="ri-megaphone-line mr-2 text-orange-400"></i>
                                <span class="text-[15px]">Marketing Suite</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.coupons.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.coupons.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-coupon-2-line mr-2 text-gray-400"></i>Coupons & Discounts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.banners.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.banners.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-advertisement-line mr-2 text-pink-400"></i>Banner & Ads
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- API Integrations -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="integrations">
                                <i class="ri-plug-line mr-2 text-pink-400"></i>
                                <span class="text-[15px]">API Integrations</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.payment_gateways.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.payment_gateways.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-bank-card-2-line mr-2 text-green-400"></i>Payment Gateways
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.sms_email_api.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.sms_email_api.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-mail-send-line mr-2 text-yellow-400"></i>SMS & Email API
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.courier.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.courier.*') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-truck-line mr-2 text-orange-400"></i>Courier Services
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- Analytics -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white 
        hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="analytics">
                                <i class="ri-pie-chart-2-line mr-2 text-emerald-400"></i>
                                <span class="text-[15px]">Analytics & Tracking</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.analytics.gtm') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.analytics.gtm') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-google-line mr-2 text-green-400"></i>Google Analytics / GTM
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.analytics.pixel') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.analytics.pixel') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-facebook-circle-line mr-2 text-blue-400"></i>Meta Pixel Tracking
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- System Settings -->
                        <li class="group">
                            <a href="#"
                                class="mb-1 flex items-center pl-4 py-2.5 text-gray-300 hover:text-white 
        hover:bg-[#3b3f5c] rounded submenu-toggle"
                                data-menu-key="settings">
                                <i class="ri-settings-4-line mr-2 text-teal-400"></i>
                                <span class="text-[15px]">System Settings</span>
                                <i class="ri-arrow-down-s-line ml-auto mr-4"></i>
                            </a>
                            <ul class="submenu pl-2 bg-[#2a2f45]">
                                <li>
                                    <a href="{{ route('admin.social_media.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.social_media.index') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-global-line mr-2 text-green-400"></i>Social Linked
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.setting') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.setting') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-tools-line mr-2 text-gray-400"></i>General Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.account') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.account') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-user-settings-line mr-2 text-blue-400"></i>Admin Accounts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.shipping.index') }}"
                                        class="flex items-center py-2 pl-6 text-[15px] rounded
                    {{ request()->routeIs('admin.shipping.index') ? 'bg-[#3b3f5c] text-white' : 'text-gray-300 hover:text-white hover:bg-[#3b3f5c]' }}">
                                        <i class="ri-truck-line mr-2 text-orange-400"></i>Shipping & Logistics
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div
            class="scrollhidden bg-gray-50 flex-1 md:ml-[230px] lg:ml-[260px] md:px-4 px-2 md:pt-4 overflow-y-auto print:p-0 print:m-0">
            @yield('content')
        </div>
    </div>

    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const lenis = new Lenis({
                duration: 1.2,
                smooth: true
            });

            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.addEventListener('wheel', (e) => {
                    e.stopPropagation();
                }, {
                    passive: false
                });

                sidebar.addEventListener('touchmove', (e) => {
                    e.stopPropagation();
                }, {
                    passive: false
                });
            }

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        });
    </script>

    <script>
        document.getElementById("menuBtn").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
        });

        profile_menu_btn.onclick = () => profile_menu.classList.toggle('hidden');

        document.addEventListener('DOMContentLoaded', function() {
            const submenuToggles = document.querySelectorAll('.submenu-toggle');
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    const submenuKey = this.dataset.menuKey;
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                        submenu.style.maxHeight = '0';
                        this.classList.remove('bg-blue-500', 'text-white');
                        localStorage.removeItem('openMenu');
                    } else {
                        document.querySelectorAll('.submenu').forEach(sm => {
                            sm.classList.remove('open');
                            sm.style.maxHeight = '0';
                        });
                        document.querySelectorAll('.submenu-toggle').forEach(st => {
                            st.classList.remove('bg-blue-500', 'text-white');
                        });
                        submenu.classList.add('open');
                        submenu.style.maxHeight = submenu.scrollHeight + 'px';
                        this.classList.add('bg-blue-500', 'text-white');
                        localStorage.setItem('openMenu', submenuKey);
                    }
                });
            });

            const openMenuKey = localStorage.getItem('openMenu');
            if (openMenuKey) {
                const openToggle = document.querySelector(`[data-menu-key="${openMenuKey}"]`);
                if (openToggle) {
                    const submenu = openToggle.nextElementSibling;
                    submenu.classList.add('open');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    openToggle.classList.add('bg-blue-500', 'text-white');
                }
            }
        });
    </script>
</body>

</html>
