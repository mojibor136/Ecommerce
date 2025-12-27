<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AdminMail;
use App\Mail\OrderMail;
use App\Models\GmailSmtp;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\Shipping;
use App\Models\Textlocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^01\d{9}$/'],
            'city' => 'required|string',
            'address' => 'required|string',
            'charge' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $smtp = GmailSmtp::where('status', 1)->first();
        $setting = Setting::first();

        if ($smtp) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $smtp->host,
                'mail.mailers.smtp.port' => $smtp->port,
                'mail.mailers.smtp.username' => $smtp->email,
                'mail.mailers.smtp.password' => $smtp->password,
                'mail.mailers.smtp.encryption' => strtolower($smtp->encryption),
                'mail.from.address' => $smtp->email,
                'mail.from.name' => $setting->name,
            ]);
        }

        $sms = Textlocal::first();

        try {

            $order = Order::create([
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'shipping_charge' => $request->charge,
                'total' => '0',
                'discount' => '0',
                'tracking_id' => '0',
                'courier_method' => 'Any',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
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

            $total += $request->charge;

            $total -= $request->discount;

            if ($payment) {
                $payment->amount = $total;
                $payment->save();
            }

            $order->total = $total;
            $order->save();

            $incomplete = Order::find($request->incomplete);

            if ($sms && $request->phone) {
                try {
                    $api_key = $sms->api_key;

                    $number = $request->phone;

                    if (! str_starts_with($number, '+88')) {
                        $number = '+88'.ltrim($number, '0');
                    }
                    $message = "Dear {$request->name}, your order #{$order->invoice_id} has been placed successfully. Total: ৳{$order->total}";

                    $url = $sms->url."?api_key={$api_key}&number={$number}&message=".urlencode($message);

                    $response = file_get_contents($url);
                    $data = json_decode($response, true);

                    if ($data['status'] != 'success') {
                        Log::warning('SMS failed: '.$data['message']);
                    }
                } catch (\Exception $e) {
                    Log::error('SMS sending failed: '.$e->getMessage());
                }
            }
            if ($incomplete) {
                $incomplete->delete();
            }

            $this->reduceStock($order->id);

            try {
                Mail::to($request->email)->send(new OrderMail($order));
                Mail::to($smtp->email)->send(new AdminMail($order));
            } catch (\Exception $e) {
                Log::error('Order Mail Failed: '.$e->getMessage());
            }

            DB::commit();
            if ($request->payment_method == 'cod') {
                return redirect()->route('order.success', [
                    'invoice_id' => $order->invoice_id,
                    'amount' => $order->total,
                    'order' => $order,
                    'payment' => $payment,
                    'method' => 'Cash on Delivery',
                ])->with('success', 'Your order has been placed successfully!');
            } elseif ($request->payment_method == 'nagad') {
                return view('frontend.payment.nagad', [
                    'order' => $order->id,
                    'amount' => $order->total,
                ]);
            } elseif ($request->payment_method == 'bkash') {
                return view('frontend.payment.bkash', [
                    'order' => $order->id,
                    'amount' => $order->total,
                ]);
            } else {
                return redirect()->back()->with('error', 'Invalid payment method.');
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
