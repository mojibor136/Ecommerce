<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'shipping'])->latest()->get();

        return view('backend.order.index', compact('orders'));
    }

    public function pending()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'pending')->latest()->get();

        return view('backend.order.pending', compact('orders'));
    }

    public function confirmed()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'confirmed')->latest()->get();

        return view('backend.order.confirmed', compact('orders'));
    }

    public function ready()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'ready')->latest()->get();

        return view('backend.order.ready', compact('orders'));
    }

    public function shipped()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'shipped')->latest()->get();

        return view('backend.order.shipped', compact('orders'));
    }

    public function delivered()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'delivered')->latest()->get();

        return view('backend.order.delivered', compact('orders'));
    }

    public function cancelled()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'cancelled')->latest()->get();

        return view('backend.order.cancelled', compact('orders'));
    }

    public function refunded()
    {
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'refunded')->latest()->get();

        return view('backend.order.refunded', compact('orders'));
    }
}
