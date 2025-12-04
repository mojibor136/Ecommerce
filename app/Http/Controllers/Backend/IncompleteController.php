<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncompleteController extends Controller
{
    public function createIncomplete(Request $request)
    {
        try {
            $order = Order::create([
                'order_status' => 'incomplete',
                'payment_status' => 'incomplete',
                'shipping_charge' => $request->charge ?? 0,
                'total' => 0,
                'discount' => $request->discount ?? 0,
                'tracking_id' => '0',
                'courier_method' => 'Any',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $shipping = Shipping::create([
                'order_id' => $order->id,
                'name' => $request->name,
                'email' => $request->email ?: 'N/A',
                'phone' => $request->phone,
                'city' => $request->city ?: 'N/A',
                'address' => $request->address,
            ]);

            $products = [];

            if ($request->has('products')) {
                foreach ($request->products as $item) {
                    if (empty($item)) {
                        continue;
                    }

                    if (is_array($item)) {
                        $products[] = $item;
                    }
                }
            } elseif ($request->has('product')) {
                if (! empty($request->product)) {
                    $products[] = $request->product;
                }
            }

            $total = 0;
            foreach ($products as $product) {
                $product_id = $product['id'] ?? null;
                $variant_id = $product['variant_id'] ?? null;
                $name = $product['name'] ?? '';
                $price = isset($product['price']) ? (float) $product['price'] : 0;
                $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 1;
                $image = $product['image'] ?? null;
                $attributes = ! empty($product['attributes']) ? json_decode($product['attributes'], true) : [];

                if (! $product_id) {
                    continue;
                }

                $subtotal = $price * $quantity;

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'variant_id' => $variant_id ? $variant_id : 0,
                    'product_name' => $name,
                    'price' => $price,
                    'product_image' => $image,
                    'attributes' => json_encode($attributes),
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $total += $request->charge ?? 0;
            $total -= $request->discount ?? 0;

            $order->total = $total;
            $order->save();

            return response()->json(['status' => 'success', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            Log::error('Incomplete Order Error: '.$e->getMessage(), [
                'request' => $request->all(),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }
}
