<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AdminMail;
use App\Mail\OrderMail;
use App\Models\GmailSmtp;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        session([
            'checkoutData' => $request->all(),
        ]);

        $paymentMethod = $request->payment_method;

        $amount = session('cart_total') ?? 1000;

        if ($paymentMethod == 'cod') {
            $orderController = new OrderController;

            return $orderController->createOrder($request, 'cod');
        } elseif ($paymentMethod == 'nagad') {
            return view('frontend.payment.nagad', [
                'paymentMethod' => $paymentMethod,
                'amount' => $amount,
            ]);
        } elseif ($paymentMethod == 'bkash') {
            return view('frontend.payment.bkash', [
                'paymentMethod' => $paymentMethod,
                'amount' => $amount,
            ]);
        } else {
            abort(404, 'Payment method not supported');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $checkoutData = session('checkoutData');

        if (! $checkoutData) {
            return redirect()->route('checkout.index')->with('error', 'Session expired!');
        }

        $checkoutData['payment_method'] = $request->input('payment_method', 'unknown');
        $checkoutData['transaction_id'] = $request->input('transaction_id', 'unknown');
        $checkoutData['sender_number'] = $request->input('sender_number', 'unknown');

        $orderController = new OrderController;

        $order = $orderController->createOrder(new Request($checkoutData));

        session()->forget(['checkoutData', 'cart', 'buy_now']);

        $order->load('items');

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

        try {
            Mail::to($order->shipping->email)->send(new OrderMail($order));
            Mail::to($smtp->email)->send(new AdminMail($order));
        } catch (\Exception $e) {
            \Log::error('Payment Success Mail Failed: '.$e->getMessage());
        }

        return redirect()->route('order.success', [
            'invoice_id' => $order->invoice_id,
            'amount' => $order->total,
            'order' => $order,
            'method' => ($checkoutData['payment_method'] == 'cod') ? 'Cash on Delivery' : $checkoutData['payment_method'],
        ])->with('success', 'Your order has been placed successfully!');
    }

    public function paymentFail()
    {
        return redirect()->route('checkout.index')->with('error', 'Payment failed! Please try again.');
    }
}
