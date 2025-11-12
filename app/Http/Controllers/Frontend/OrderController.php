<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'shipping_charge' => $request->charge,
                'total' => '0',
                'discount' => '0',
            ]);

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
                dd($request->all());
            } elseif ($request->has('products')) {
                $products = $request->products;
                dd($request->all());
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
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'product_image' => $product['image'],
                    'attributes' => json_encode($attributes),
                    'quantity' => $product['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            if (
                isset($request->payment_method) &&
                in_array($request->payment_method, ['bkash', 'nagad'])
            ) {
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

            return back()->with('error', 'Order creation failed. Please try again.');
        }
    }
}
