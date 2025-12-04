<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        session([
            'checkoutData' => $request->all(),
        ]);

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $blocked = BlockedIp::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->first();

        $fiveMinutesAgo = now()->subMinutes(5);
        $tenMinutesAgo = now()->subMinutes(10);
        $oneHourAgo = now()->subHour();
        $todayStart = now()->startOfDay();

        $ordersLast5Min = Order::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->where('created_at', '>=', $fiveMinutesAgo)
            ->count();

        $ordersLast10Min = Order::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->where('created_at', '>=', $tenMinutesAgo)
            ->count();

        $ordersLastHour = Order::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->where('created_at', '>=', $oneHourAgo)
            ->count();

        $ordersToday = Order::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->where('created_at', '>=', $todayStart)
            ->count();

        if ($ordersLast5Min >= 2 || $ordersLast10Min >= 5 || $ordersLastHour >= 5 || $ordersToday >= 10) {

            $reason = '';
            if ($ordersLast5Min >= 2) {
                $reason .= 'More than 2 orders in last 5 minutes. ';
            }
            if ($ordersLast10Min >= 5) {
                $reason .= 'More than 5 orders in last 10 minutes. ';
            }
            if ($ordersLastHour >= 5) {
                $reason .= 'More than 5 orders in last 1 hour. ';
            }
            if ($ordersToday >= 10) {
                $reason .= 'More than 10 orders today. ';
            }

            BlockedIp::updateOrCreate(
                ['ip_address' => $ip, 'user_agent' => $userAgent],
                [
                    'reason' => $reason,
                ]
            );

            return abort(403, 'Your IP is temporarily blocked due to suspicious activity.');
        }

        $paymentMethod = $request->payment_method;

        $orderController = new OrderController;

        return $orderController->createOrder($request, $paymentMethod);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'required|string',
            'sender_number' => 'required|string',
            'transaction_id' => 'required|string',
        ]);

        $orderId = $request->order_id;

        $order = Order::findOrFail($orderId);

        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'amount' => $order->total,
            'sender_number' => $request->sender_number,
            'transaction_id' => $request->transaction_id,
            'status' => 'success',
        ]);

        return redirect()->route('order.success', [
            'invoice_id' => $order->invoice_id,
            'amount' => $order->total,
            'order' => $order,
            'payment' => $payment,
            'method' => $request->payment_method == 'cod' ? 'Cash on Delivery' : $request->payment_method,
        ])->with('success', 'Your order has been placed successfully!');
    }

    public function paymentFail()
    {
        return redirect()->route('checkout.index')->with('error', 'Payment failed! Please try again.');
    }
}
