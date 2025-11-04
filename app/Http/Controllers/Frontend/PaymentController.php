<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        session([
            'checkoutData' => $request->all(),
        ]);

        $paymentMethod = $request->payment;

        if ($paymentMethod == 'cod') {
            return $this->createOrder($request, 'cod');
        } else {
            return view('frontend.payment', [
                'paymentMethod' => $paymentMethod,
                'amount' => session('cart_total') ?? 1000,
            ]);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $checkoutData = session('checkoutData');

        if (! $checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Session expired!');
        }

        $this->createOrder(new Request($checkoutData), 'success');

        session()->forget(['checkoutData', 'cart', 'buy_now']);

        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }

    public function paymentFail()
    {
        return redirect()->route('checkout.index')->with('error', 'Payment failed! Please try again.');
    }

    private function createOrder(Request $request, $paymentStatus)
    {
        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'payment_method' => $request->payment,
            'payment_status' => $paymentStatus,
            'total_amount' => session('cart_total') ?? 0,
        ]);

        // Product details save করতে পারো order_items table এ
        // foreach (session('cart') as $item) { ... }

        return $order;
    }
}
