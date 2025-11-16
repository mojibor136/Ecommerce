<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        DB::beginTransaction();

        try {

            Log::info('Creating Order...');

            $order = Order::create([
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'shipping_charge' => $request->charge,
                'total' => '0',
                'discount' => '0',
                'tracking_id' => '0',
                'courier_method' => 'Any',
            ]);

            Log::info('Order Created', ['order_id' => $order->id]);

            Shipping::create([
                'order_id' => $order->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'address' => $request->address,
            ]);

            $products = [];

            if ($request->has('product')) {
                $products[] = $request->product;
            } elseif ($request->has('products')) {
                $products = $request->products;
            }

            $total = +$request->charge - $request->discount;
            $payment = null;

            foreach ($products as $product) {
                $subtotal = $product['price'] * $product['quantity'];
                $total += $subtotal;

                $attributes = [];
                if (! empty($product['attributes'])) {
                    $attributes = json_decode($product['attributes'], true);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'variant_id' => $product['variant_id'],
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'product_image' => $product['image'],
                    'attributes' => json_encode($attributes),
                    'quantity' => $product['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            if (isset($request->payment_method) && in_array($request->payment_method, ['bkash', 'nagad'])) {
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'transaction_id' => $request->transaction_id,
                    'sender_number' => $request->sender_number,
                    'amount' => 0,
                    'status' => 'paid',
                    'method' => $request->payment_method,
                ]);
            }

            $total += $request->charge;
            $total -= $request->discount;

            if ($payment) {
                $payment->amount = $total;
                $payment->save();
            }

            $order->total = $total;
            $order->save();

            $this->reduceStock($order->id);

            DB::commit();

            if ($request->payment_method == 'cod') {
                return redirect()->route('order.success', [
                    'invoice_id' => $order->invoice_id,
                    'amount' => $order->total,
                    'method' => 'Cash on Delivery',
                ])->with('success', 'Order created successfully!');
            } else {
                return $order;
            }

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Order Creation Failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Order creation failed: '.$e->getMessage());
        }
    }

    protected function reduceStock($orderId)
    {
        $orderItems = OrderItem::where('order_id', $orderId)->get();

        foreach ($orderItems as $item) {
            if ($item->variant_id > 0) {
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    if ($item->quantity > $variant->stock) {
                        throw new \Exception("Insufficient stock for variant: {$variant->id}");
                    }
                    $variant->stock -= $item->quantity;
                    $variant->save();
                } else {
                    throw new \Exception("Variant not found: {$item->variant_id}");
                }
            } else {
                $product = Product::find($item->product_id);
                if ($product) {
                    if ($item->quantity > $product->stock) {
                        throw new \Exception("Insufficient stock for product: {$product->id}");
                    }
                    $product->stock -= $item->quantity;
                    $product->save();
                } else {
                    throw new \Exception("Product not found: {$item->product_id}");
                }
            }
        }
    }
}
