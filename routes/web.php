<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AnalyticsController;
use App\Http\Controllers\Backend\ApiController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\AttributeValueController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CourierController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentGatewayController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\SystemSettingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Middleware\ClearBuyNow;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', ClearBuyNow::class])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/deals', 'deals')->name('deals');
        Route::get('/help-center', 'help')->name('help');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/privacy-policy', 'policy')->name('policy');
        Route::get('/terms-and-conditions', 'terms')->name('terms');
        Route::get('/your/shop', 'shop')->name('shop');
        Route::get('/product/{slug}', 'product')->name('product.details');
        Route::get('/order/success', 'success')->name('order.success');
        Route::get('/order/tracking', 'tracking')->name('order.tracking');
        Route::get('/category/{slug}', 'categoryProduct')->name('category.product');
        Route::get('/subcategory/{slug}', 'subcategoryProduct')->name('subcategory.product');
    });

    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/checkout/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('checkout.buy-now');
    Route::get('/shipping/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
});

// Admin Routes
// =======================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'web'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/account', 'account')->name('account');
        Route::post('/account/store', 'accountStore')->name('account.store');
    });

    Route::controller(SystemSettingController::class)->group(function () {
        Route::get('/shipping/charge', 'shippingIndex')->name('shipping.index');
        Route::post('/shipping/charge/store', 'shippingStore')->name('shipping.store');
        Route::get('/setting', 'setting')->name('setting');
        Route::post('/setting/store', 'settingStore')->name('setting.store');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/inventory', 'inventory')->name('products.inventory');
        Route::get('/order/products', 'OrderByProduct')->name('order.products');
        Route::post('/products/update-orders', 'updateOrders')->name('products.updateOrders');
        Route::post('/products/{id}/update-stock/{variantId?}', 'updateStock')->name('products.updateStock');
        Route::delete('/products/variant/{id}/destroy', 'destroyVariant')->name('products.variant.destroy');
    });

    Route::controller(AnalyticsController::class)->group(function () {
        Route::get('/analytics/gtm', 'AnalyticsGTM')->name('analytics.gtm');
        Route::post('/analytics/gtm', 'AnalyticsGTMStore')->name('analytics.gtm.store');
        Route::get('/analytics/pixel', 'AnalyticsPixel')->name('analytics.pixel');
        Route::post('/analytics/pixel', 'AnalyticsPixelStore')->name('analytics.pixel.store');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('attribute_values', AttributeValueController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('social_media', MediaController::class);
    Route::resource('payment_gateways', PaymentGatewayController::class);
    Route::resource('sms_email_api', ApiController::class);
    Route::resource('courier', CourierController::class);

    Route::get('/get-subcategories/{category_id}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
    Route::get('/get-attribute-values', [ProductController::class, 'getAttributeValuesMultiple'])->name('get.attribute.values.multiple');
});

Route::post('/set-shipping-charge', function (\Illuminate\Http\Request $request) {
    session([
        'shippingCharge' => $request->charge,
        'shippingArea' => $request->area,
    ]);

    return response()->json(['status' => 'success']);
})->name('set.shipping.charge');

require __DIR__.'/auth.php';
