<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $setting->name }}</title>
    @php
        $favicon = $setting->favicon;
        $logo = $setting->icon;
    @endphp
    @if ($favicon && file_exists(public_path($favicon)))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
    @endif <!-- fot awesome -->
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/all.css') }}" />
    <!-- core css -->
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backEnd/assets/css/toastr.min.css') }}" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/owl.theme.default.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/owl.carousel.min.css') }}" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontEnd/campaign/css/responsive.css') }}" />
    @if (!empty($pixelTracking))
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixelTracking }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $pixelTracking }}&ev=PageView&noscript=1" />
        </noscript>
    @endif

    <meta name="app-url" content="{{ route('campaign', $campaign->campaign_slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $campaign->short_description }}" />
    <meta name="keywords" content="{{ $campaign->campaign_slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $campaign->name }}" />
    <meta name="twitter:title" content="{{ $campaign->name }}" />
    <meta name="twitter:description" content="{{ $campaign->short_description }}" />
    <meta name="twitter:creator" content="" />
    <meta property="og:url" content="{{ route('campaign', $campaign->campaign_slug) }}" />
    <meta name="twitter:image" content="{{ asset($campaign->banner) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $campaign->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('campaign', $campaign->campaign_slug) }}" />
    <meta property="og:image" content="{{ asset($campaign->banner) }}" />
    <meta property="og:description" content="{{ $campaign->short_description }}" />
    <meta property="og:site_name" content="{{ $campaign->name }}" />
</head>

<body>
    <section class="banner-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <div class="campaign_banner">
                        <div class="banner_title">
                            <h2>{{ $campaign->name }}</h2>
                        </div>
                        <div class="banner-image-wrapper">
                            <div class="banner-slider owl-carousel">
                                @foreach (json_decode($campaign->banner_image) as $banner)
                                    <div class="banner-image">
                                        <img src="{{ asset($banner) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end -->

    <!-- short-desctiption section start -->
    <section class="short-des">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="short-des-title">
                        {!! $campaign->campaign_description !!}
                    </div>
                    <div class="ord_btn">
                        <a href="#order_form" class="order_place"> অর্ডার করুন
                            <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- short-desctiption section end -->

    <!-- desctiption section start -->
    <section class="description-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="description-inner">
                        <div class="description-title">
                            <h2>{{ $campaign->description_title }}</h2>
                        </div>
                        <div class="main-description">
                            {!! $campaign->description !!}
                        </div>
                    </div>
                    <div class="ord_btn mt-5">
                        <a href="#order_form" class="order_place"> অর্ডার করুন
                            <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- desctiption section end -->

    <!-- desctiption section start -->
    <section class="whychoose-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="whychoose-inner">
                        <div class="whychoose-title">
                            <h2>আমাদের প্রোডাক্ট কোনো কিনবেন?</h2>
                        </div>
                        <div class="main-whychoose">
                            {!! $campaign->why_buy_from_us !!}
                        </div>
                    </div>
                    <div class="ord_btn my-5">
                        <a href="#order_form" class="order_place"> অর্ডার করুন
                            <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- desctiption section end -->

    <!-- review section start -->
    @php
        $reviews = json_decode($campaign->review_image, true);
    @endphp

    @if ($reviews && count($reviews) > 0)
        <section class="review-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rev_inn">
                            <div class="rev_title">
                                <h2>আমাদের কাস্টমারের রিভিউ?</h2>
                            </div>
                            <div class="review_slider owl-carousel">
                                @foreach ($reviews as $banner)
                                    <div class="review_item">
                                        <img src="{{ asset($banner) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- review section end -->

    <!-- offer price form end -->
    <section class="price-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="offer_price">
                        <div class="offer_title">
                            <h2>অফারটি সীমিত সময়ের জন্য, তাই অফার শেষ হওয়ার আগেই অর্ডার করুন</h2>
                        </div>
                        <div class="product-price">
                            <h2>
                                @if ($product->old_price)
                                    <p class="old_price"> আগের দাম : <del> {{ $product->old_price }}</del> /=</p>
                                @endif
                                <p>বর্তমান দাম {{ $product->new_price }}/=</p>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="form_sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form_inn">
                        <form action="{{ route('order.create') }}" method="POST" class="col-sm-12">
                            <div class="row order_by">
                                <div class="col-sm-5">
                                    <div class="checkout-shipping" id="order_form">
                                        <div data-parsley-validate="">
                                            @csrf
                                            <input type="hidden" name="product[id]" value="{{ $product->id }}">
                                            <input type="hidden" name="product[name]" value="{{ $product->name }}">
                                            <input type="hidden" name="product[price]"
                                                value="{{ $product->new_price }}">
                                            <input type="hidden" name="product[image]"
                                                value="{{ asset('uploads/products/' . $product->images->first()->image) }}">
                                            <input type="hidden" name="variant_id" id="variant_id" value=""
                                                class="variant_id">
                                            <input type="hidden" name="incomplete" id="orderId" value=""
                                                class="incomplete-flag">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="potro_font">👇 অর্ডারটি কনফার্ম করতে আপনার ইনফরমেশন দিন
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group mb-3">
                                                                <label for="name">আপনার নাম লিখুন * </label>
                                                                <input type="text" id="name"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    name="name" value="{{ old('name') }}"
                                                                    required>
                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <!-- col-end -->
                                                        <div class="col-sm-12">
                                                            <div class="form-group mb-3">
                                                                <label for="phone">আপনার মোবাইল লিখুন *</label>
                                                                <input type="number" minlength="11" id="number"
                                                                    maxlength="11" pattern="0[0-9]+"
                                                                    title="please enter number only and 0 must first character"
                                                                    title="Please enter an 11-digit number."
                                                                    id="phone"
                                                                    class="form-control @error('phone') is-invalid @enderror"
                                                                    name="phone" value="{{ old('phone') }}"
                                                                    required>
                                                                @error('phone')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <!-- col-end -->
                                                        <div class="col-sm-12">
                                                            <div class="form-group mb-3">
                                                                <label for="address">আপনার ঠিকানা লিখুন *</label>
                                                                <input type="address" id="address"
                                                                    class="form-control @error('address') is-invalid @enderror"
                                                                    name="address" value="{{ old('address') }}"
                                                                    required>
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group mb-3">
                                                                <label for="area">আপনার এরিয়া সিলেক্ট করুন
                                                                    *</label>
                                                                <select class="form-control" name="area"
                                                                    id="area" required>
                                                                    <option value="{{ $inDhakaCharge }}">Inside Dhaka
                                                                        {{ $inDhakaCharge }}
                                                                    </option>
                                                                    <option value="{{ $outDhakaCharge }}">Outside
                                                                        Dhaka {{ $outDhakaCharge }}</option>
                                                                </select>
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <button style="width: -webkit-fill-available;"
                                                                    class="order_place confirm_order"
                                                                    type="submit">অর্ডার কন্ফার্ম করুন </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card end -->
                                        </div>
                                    </div>
                                </div>
                                <!-- col end -->
                                <div class="col-sm-7 cust-order-1">
                                    <div class="cart_details">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="potro_font">পণ্যের বিবরণ </h5>
                                            </div>
                                            <div class="card-body cartlist  table-responsive">
                                                <table
                                                    class="cart_table table table-bordered table-striped text-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 60%;">প্রোডাক্ট</th>
                                                            <th style="width: 20%;">পরিমাণ</th>
                                                            <th style="width: 20%;">মূল্য</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td class="text-left" style="align-content: center;">
                                                                <a style="font-size: 14px;" href="#"><img
                                                                        style="border-radius: 5px; margin-right: 5px;"
                                                                        src="{{ asset('uploads/products/' . $product->images->first()->image) }}"
                                                                        height="50" width="50">
                                                                    {{ Str::limit($product->name, 20) }}</a>
                                                            </td>
                                                            <td width="15%" class="cart_qty"
                                                                style="align-content: center;">
                                                                <div class="qty-cart vcart-qty">
                                                                    <div class="quantity">
                                                                        <button class="minus cart_decrement"
                                                                            data-id="{{ $product->id }}">-</button>
                                                                        <input type="text" value="1"
                                                                            name="product[quantity]" readonly />
                                                                        <button class="plus  cart_increment"
                                                                            data-id="{{ $product->id }}">+</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="align-content: center;">
                                                                ৳{{ $product->new_price }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2" class="text-end px-4">মোট</th>
                                                            <td>
                                                                <span id="net_total"><span class="alinur">৳
                                                                    </span><strong>{{ $product->new_price }}</strong></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2" class="text-end px-4">ডেলিভারি চার্জ
                                                            </th>
                                                            <td>
                                                                <span id="cart_shipping_cost"><span class="alinur">৳
                                                                    </span><strong>{{ $inDhakaCharge }}</strong></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2" class="text-end px-4">সর্বমোট</th>
                                                            <td>
                                                                <span id="grand_total"><span
                                                                        class="alinur">৳</span><strong>{{ $product->new_price + $inDhakaCharge }}</strong></span>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- col end -->
                        </form>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>

    <script src="{{ asset('frontEnd/campaign/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('frontEnd/campaign/js/all.js') }}"></script>
    <script src="{{ asset('frontEnd/campaign/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontEnd/campaign/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontEnd/campaign/js/select2.min.js') }}"></script>
    <script src="{{ asset('frontEnd/campaign/js/script.js') }}"></script>
    <script src="{{ asset('backEnd/assets/js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}

    <script>
        const productsFromBackend = [@json($product)];

        document.addEventListener("DOMContentLoaded", function() {
            const formFields = document.querySelectorAll(
                "input[name='name'], input[name='phone'], textarea[name='address'], select[name='area']"
            );

            let ajaxTimeout;

            function getProductData() {
                const productInputs = document.querySelectorAll("input[name^='product']");
                let productObj = {};

                productInputs.forEach(input => {
                    const match = input.name.match(/product\[(.+)\]/);
                    if (match) {
                        productObj[match[1]] = input.value;
                    }
                });

                return [productObj];
            }

            function sendAjax() {
                const data = {
                    _token: '{{ csrf_token() }}',
                    name: document.querySelector("input[name='name']").value.trim(),
                    phone: document.querySelector("input[name='phone']").value.trim(),
                    address: document.querySelector("input[name='address']").value.trim(),
                    charge: document.querySelector("select[name='area']").value,
                    products: getProductData()
                };

                fetch('/order/incomplete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': data._token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success' && result.order_id) {
                            const orderId = document.getElementById('orderId');
                            if (orderId) orderId.value = result.order_id;
                        }
                    })
                    .catch(error => {
                        console.error('AJAX Error:', error);
                    });
            }

            function checkFields() {
                let allFilled = true;

                formFields.forEach(field => {
                    if (!field.value.trim()) {
                        allFilled = false;
                    }
                });

                if (allFilled) {
                    if (ajaxTimeout) clearTimeout(ajaxTimeout);
                    ajaxTimeout = setTimeout(sendAjax, 2000);
                } else {
                    if (ajaxTimeout) clearTimeout(ajaxTimeout);
                }
            }

            formFields.forEach(field => {
                field.addEventListener("input", checkFields);
                field.addEventListener("change", checkFields);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function updateGrandTotal() {
                let quantity = parseInt($('.quantity input').val()) || 1;
                let productPrice = parseFloat({{ $product->new_price }});
                let shipping = parseFloat($('#cart_shipping_cost strong').text());
                let total = (productPrice * quantity) + shipping;

                $('#net_total strong').text(productPrice * quantity);
                $('#grand_total strong').text(total);
            }

            // initial load
            updateGrandTotal();

            // increment button
            $('.cart_increment').click(function() {
                let input = $(this).siblings('input');
                let val = parseInt(input.val());
                input.val(val + 1);
                updateGrandTotal();
            });

            // decrement button
            $('.cart_decrement').click(function() {
                let input = $(this).siblings('input');
                let val = parseInt(input.val());
                if (val > 1) {
                    input.val(val - 1);
                    updateGrandTotal();
                }
            });

            // shipping change
            $('#area').change(function() {
                let selectedShipping = parseFloat($(this).val());
                $('#cart_shipping_cost strong').text(selectedShipping);
                updateGrandTotal();
            });
        });
    </script>

    <!-- bootstrap js -->
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                margin: 15,
                loop: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                items: 1,
            });
            $('.owl-nav').remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".main_slider").owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                autoplay: true,
                nav: false,
                autoplayHoverPause: false,
                margin: 0,
                mouseDrag: true,
                smartSpeed: 1000,
                autoplayTimeout: 4000

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        $('.review_slider').owlCarousel({
            dots: false,
            arrow: false,
            autoplay: true,
            loop: true,
            margin: 10,
            smartSpeed: 1000,
            mouseDrag: true,
            touchDrag: true,
            items: 6,
            responsiveClass: true,
            responsive: {
                300: {
                    items: 1,
                },
                480: {
                    items: 2,
                },
                768: {
                    items: 5,
                },
                1170: {
                    items: 5,
                },
            }
        });
    </script>
</body>

</html>
