<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class HomeController extends Controller
{
    public function index()
    {
        $orderedProducts = Product::where('orders', '>', 0)
            ->where('hot_deal', 0)
            ->orderBy('orders', 'asc')
            ->get();

        $randomProducts = Product::where('orders', 0)
            ->where('hot_deal', 0)
            ->inRandomOrder()
            ->get();

        $products = $orderedProducts->merge($randomProducts);

        $products = $products->take(15);

        $categories = Category::with(['products' => function ($query) {
            $query->where('hot_deal', 0)
                ->orderByRaw('CASE WHEN orders > 0 THEN orders ELSE NULL END ASC')
                ->inRandomOrder()
                ->limit(10);
        }])->has('products', '>=', 5)->get();

        $hotDeals = Product::where('hot_deal', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        $mainBanner = Banner::where('name', 'main')->get();

        $offerBanner = Banner::where('name', 'offer')->get();

        return view('frontend.welcome', compact('products', 'categories', 'hotDeals', 'offerBanner', 'mainBanner'));
    }

    public function product($slug)
    {
        $product = Product::with([
            'images',
            'variants.images',
            'activeReviews',
        ])->where('slug', $slug)->firstOrFail();

        $variants = $product->variants->map(function ($variant) {
            $attributes = $variant->attributes;

            if (is_string($attributes)) {
                $attributes = json_decode($attributes, true) ?? [];
            }

            return [
                'id' => $variant->id,
                'buy_price' => $variant->buy_price,
                'old_price' => $variant->old_price,
                'new_price' => $variant->new_price,
                'stock' => $variant->stock,
                'attributes' => $attributes,
                'images' => $variant->images->pluck('image')->toArray(),
            ];
        });

        $allImages = $product->images->pluck('image')->toArray();
        foreach ($variants as $variant) {
            foreach ($variant['images'] as $img) {
                if (! in_array($img, $allImages)) {
                    $allImages[] = $img;
                }
            }
        }

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.product-details', [
            'product' => $product,
            'variants' => $variants,
            'reviews' => $product->activeReviews,
            'averageRating' => $product->averageRating(),
            'reviewsCount' => $product->reviewsCount(),
            'products' => $relatedProducts,
            'allImages' => $allImages,
        ]);
    }

    public function success()
    {
        return view('frontend.success');
    }

    public function tracking()
    {
        return view('frontend.tracking');
    }

    public function shop()
    {
        $orderedProducts = Product::where('orders', '>', 0)
            ->orderBy('orders', 'asc')
            ->get();

        $randomProducts = Product::where('orders', 0)
            ->inRandomOrder()
            ->get();

        $products = $orderedProducts->merge($randomProducts);

        return view('frontend.shop', compact('products'));
    }

    public function categoryProduct($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $orderedProducts = Product::where('category_id', $category->id)
            ->where('orders', '>', 0)
            ->orderBy('orders', 'asc')
            ->get();

        $randomProducts = Product::where('category_id', $category->id)
            ->where('orders', 0)
            ->inRandomOrder()
            ->get();

        $products = $orderedProducts->merge($randomProducts);

        return view('frontend.category-product', compact('category', 'products'));
    }

    public function subcategoryProduct($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();

        $orderedProducts = Product::where('subcategory_id', $subcategory->id)
            ->where('orders', '>', 0)
            ->orderBy('orders', 'asc')
            ->get();

        $randomProducts = Product::where('subcategory_id', $subcategory->id)
            ->where('orders', 0)
            ->inRandomOrder()
            ->get();

        $products = $orderedProducts->merge($randomProducts);

        return view('frontend.subcategory-product', compact('subcategory', 'products'));
    }
}
