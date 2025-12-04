<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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

@if (!empty($gtmTracking))
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ $gtmTracking }}');
    </script>
@endif

@php
    $favicon = $setting->favicon;
    $logo = $setting->icon;
@endphp
@if ($favicon && file_exists(public_path($favicon)))
    <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
@endif

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-5 px-4">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-xl w-full text-center">
            <!-- Success Icon -->
            <div class="text-green-500 text-6xl mb-6">
                <i class="ri-check-line"></i>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Thank You!</h1>

            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Your order has been successfully placed. We have sent you an email confirmation with your order details.
            </p>

            <!-- Order Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
                <p class="text-gray-700 mb-2"><span class="font-medium">Order ID:</span> #{{ request('invoice') }}
                </p>
                <p class="text-gray-700 mb-2"><span class="font-medium">Total Amount:</span>
                    ৳{{ number_format(request('amount'), 2) }}</p>
                <p class="text-gray-700"><span class="font-medium">Payment Method:</span> {{ $method }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}"
                    class="w-full bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] font-semibold py-3 rounded-lg transition">
                    <i class="ri-home-5-line mr-1"></i> Back to Home
                </a>
                <a href="email"
                    class="w-full border border-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_bg }}]/50 font-semibold py-3 rounded-lg transition">
                    <i class="ri-file-list-line mr-1"></i> View My Orders
                </a>
            </div>
        </div>
    </div>

    @if (!empty($order))
        <script>
            (function() {

                var ids = [
                    @foreach ($order->items as $item)
                        '{{ $item->product_id }}',
                    @endforeach
                ];

                var totalItems = {{ $order->items->sum('quantity') }};
                var value = {{ $order->total }};

                // --- GTM ---
                if (window.dataLayer) {
                    dataLayer.push({
                        event: 'Purchase',
                        transaction_id: '{{ $order->invoice_id }}',
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product',
                        num_items: totalItems
                    });
                }

                // --- Pixel ---
                if (typeof fbq === 'function') {
                    fbq('track', 'Purchase', {
                        value: value,
                        currency: 'BDT',
                        content_ids: ids,
                        content_type: 'product',
                        num_items: totalItems
                    });
                }

            })();
        </script>
    @endif
</body>

</html>
