<?php

namespace App\Providers;

use App\Models\AnalyticsTracking;
use App\Models\Category;
use App\Models\Courier;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Theme;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $socials = SocialMedia::where('status', 1)->get();

        $topCategories = Category::withCount(['products as total_sold' => function ($query) {
            $query->whereHas('orderItems.order', function ($q) {
                $q->where('order_status', 'delivered');
            });
        }])->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $theme = Theme::first();

        $pixelTracking = AnalyticsTracking::where('type', 'pixel')->first();
        $gtmTracking = AnalyticsTracking::where('type', 'gtm')->first();

        $redxStatus = Courier::where('type', 'redx')->value('status');
        $steadfastStatus = Courier::where('type', 'steadfast')->value('status');

        // 🔥 Payment Gateway Status
        $bkashStatus = PaymentGateway::where('type', 'bkash')->value('status');
        $nagadStatus = PaymentGateway::where('type', 'nagad')->value('status');

        // All categories with subcategories
        $categories = Category::with(['subcategories' => function ($query) {
            $query->where('status', 1)->orderBy('name', 'asc');
        }])
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        // Get first or specific setting record
        $setting = Setting::first();

        // Separate shipping charges
        $inDhakaCharge = $setting->shipping_charge['in_dhaka'] ?? null;
        $outDhakaCharge = $setting->shipping_charge['out_dhaka'] ?? null;

        $minPrice = Product::min('new_price');
        $maxPrice = Product::max('new_price');

        $allOrdersCount = Order::count();
        $pendingCount = Order::where('order_status', 'pending')->count();
        $confirmedCount = Order::where('order_status', 'confirmed')->count();
        $readyCount = Order::where('order_status', 'Ready to Ship')->count();
        $shippedCount = Order::where('order_status', 'shipped')->count();
        $deliveredCount = Order::where('order_status', 'delivered')->count();
        $cancelledCount = Order::where('order_status', 'cancelled')->count();
        $refundedCount = Order::where('order_status', 'refunded')->count();

        // Share with all views
        View::share([
            'socials' => $socials,
            'topCategories' => $topCategories,
            'allcategories' => $categories,
            'setting' => $setting,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'inDhakaCharge' => $inDhakaCharge,
            'outDhakaCharge' => $outDhakaCharge,
            'allOrdersCount' => $allOrdersCount,
            'pendingCount' => $pendingCount,
            'confirmedCount' => $confirmedCount,
            'readyCount' => $readyCount,
            'shippedCount' => $shippedCount,
            'deliveredCount' => $deliveredCount,
            'cancelledCount' => $cancelledCount,
            'refundedCount' => $refundedCount,
            'redxStatus' => $redxStatus,
            'steadfastStatus' => $steadfastStatus,
            'bkashStatus' => $bkashStatus,
            'nagadStatus' => $nagadStatus,
            'pixelTracking' => $pixelTracking,
            'gtmTracking' => $gtmTracking,
            'theme' => $theme,
        ]);
    }
}
