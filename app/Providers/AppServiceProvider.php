<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
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

        // Share with all views
        View::share([
            'allcategories' => $categories,
            'setting' => $setting,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'inDhakaCharge' => $inDhakaCharge,
            'outDhakaCharge' => $outDhakaCharge,
        ]);
    }
}
