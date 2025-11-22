<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

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

    public function trackCheck(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
        ]);

        $id = $request->order_id;

        $order = Order::with('shipping')
            ->where('tracking_id', $id)
            ->orWhere('invoice_id', $id)
            ->first();

        if (! $order) {
            return back()->with('error', 'No order found with this ID!');
        }

        return back()->with('order', $order);
    }

    public function shop(Request $request)
    {
        $allcategories = Category::all();

        $query = Product::with('images');

        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->filled('min_price')) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('new_price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $rating = (float) $request->rating;

            $query->whereHas('activeReviews', function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            })
                ->withAvg('activeReviews', 'rating')
                ->having('active_reviews_avg_rating', '>=', $rating);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('new_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('new_price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('activeReviews', 'rating')
                        ->orderByDesc('active_reviews_avg_rating');
                    break;
                default:
                    $query->orderBy('orders', 'asc');
            }
        } else {
            $query->orderBy('orders', 'asc');
        }

        $products = $query->get();

        $minPrice = Product::min('new_price');
        $maxPrice = Product::max('new_price');

        return view('frontend.shop', compact(
            'products',
            'allcategories',
            'minPrice',
            'maxPrice'
        ));
    }

    public function deals(Request $request)
    {
        $allcategories = Category::all();

        $query = Product::with('images')->where('hot_deal', 1);

        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->filled('min_price')) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('new_price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $rating = (float) $request->rating;

            $query->whereHas('activeReviews', function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            })
                ->withAvg('activeReviews', 'rating')
                ->having('active_reviews_avg_rating', '>=', $rating);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('new_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('new_price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('activeReviews', 'rating')
                        ->orderByDesc('active_reviews_avg_rating');
                    break;
                default:
                    $query->orderBy('orders', 'asc');
            }
        } else {
            $query->orderBy('orders', 'asc');
        }

        $products = $query->get();

        $minPrice = Product::min('new_price');
        $maxPrice = Product::max('new_price');

        return view('frontend.deals', compact(
            'products',
            'allcategories',
            'minPrice',
            'maxPrice'
        ));
    }

    public function categoryProduct(Request $request, $slug)
    {
        $product_category = Category::where('slug', $slug)->firstOrFail();
        $allcategories = Category::all();

        $query = Product::with('images');

        $categoryIds = [$product_category->id];
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $categoryIds = $request->categories;
        }
        $query->whereIn('category_id', $categoryIds);

        if ($request->filled('min_price')) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('new_price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $rating = (float) $request->rating;
            $query->whereHas('activeReviews', function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('new_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('new_price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('activeReviews', 'rating')
                        ->orderByDesc('active_reviews_avg_rating');
                    break;
                default:
                    $query->orderBy('orders', 'asc');
            }
        } else {
            $query->orderBy('orders', 'asc');
        }

        $orderedProducts = (clone $query)->where('orders', '>', 0)->orderBy('orders', 'asc')->get();

        $randomProducts = (clone $query)->where('orders', 0)->inRandomOrder()->get();

        $products = $orderedProducts->merge($randomProducts);

        $minPrice = Product::whereIn('category_id', [$product_category->id])->min('new_price');
        $maxPrice = Product::whereIn('category_id', [$product_category->id])->max('new_price');

        return view('frontend.category-product', compact(
            'product_category',
            'products',
            'allcategories',
            'minPrice',
            'maxPrice'
        ));
    }

    public function subcategoryProduct(Request $request, $slug)
    {
        $product_subcategory = Subcategory::where('slug', $slug)->firstOrFail();
        $allcategories = Category::all();

        $query = Product::with('images');

        $categoryId = $product_subcategory->category_id;
        $categoryIds = [$categoryId];
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $categoryIds = $request->categories;
        }
        $query->whereIn('category_id', $categoryIds);

        if ($request->filled('min_price')) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('new_price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $rating = (float) $request->rating;
            $query->whereHas('activeReviews', function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('new_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('new_price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('activeReviews', 'rating')
                        ->orderByDesc('active_reviews_avg_rating');
                    break;
                default:
                    $query->orderBy('orders', 'asc');
            }
        } else {
            $query->orderBy('orders', 'asc');
        }

        $orderedProducts = (clone $query)->where('orders', '>', 0)->orderBy('orders', 'asc')->get();
        $randomProducts = (clone $query)->where('orders', 0)->inRandomOrder()->get();

        $products = $orderedProducts->merge($randomProducts);

        $minPrice = Product::whereIn('category_id', $categoryIds)->min('new_price');
        $maxPrice = Product::whereIn('category_id', $categoryIds)->max('new_price');

        return view('frontend.subcategory-product', compact(
            'product_subcategory',
            'products',
            'allcategories',
            'minPrice',
            'maxPrice'
        ));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function policy()
    {
        return view('frontend.privacy-policy');
    }

    public function terms()
    {
        return view('frontend.terms-and-conditions');
    }

    public function help()
    {
        return view('frontend.help-center');
    }

    public function search(Request $request)
    {
        $query = $request->query('query', '');

        $products = Product::with('images')
            ->where('name', 'LIKE', "%{$query}%")
            ->take(10)
            ->get();

        $data = $products->map(function ($product) {

            $image = $product->images->where('is_main', 1)->first();

            if (! $image) {
                $image = $product->images->first();
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->new_price,
                'image' => $image ? $image->image : 'placeholder.jpg',
            ];
        });

        return response()->json($data);
    }
}
