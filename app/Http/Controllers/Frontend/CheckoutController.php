<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('frontend.checkout');
    }

    public function buyNow(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);

        $variantsArray = $request->input('variant', []);

        $variants = array_filter($variantsArray, function ($value) {
            return ! is_null($value) && $value !== '';
        });

        $buyNowData = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->new_price,
            'image' => $request->input('image'),
            'variants' => $variants,
        ];

        session()->put('buy_now', $buyNowData);

        return redirect()->route('checkout.index');
    }
}
