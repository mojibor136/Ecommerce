<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $quantity = $request->input('quantity', 1);
        $variant_id = $request->input('cartVariantId', 0);

        $variants = array_filter($request->input('variant', []), function ($value) {
            return ! is_null($value) && $value !== '';
        });

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->new_price,
                'image' => $request->image,
                'variants' => $variants,
                'variant_id' => $variant_id,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('frontend.cart', compact('cart'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = max(1, intval($request->quantity));
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'item_total' => $cart[$id]['price'] * $cart[$id]['quantity'],
                'subtotal' => $subtotal,
                'total' => $subtotal + session('shippingCharge', 150),
            ]);
        }

        return response()->json(['success' => false]);
    }
}
