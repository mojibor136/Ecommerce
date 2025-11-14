<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $orders = Order::with(['items', 'shipping'])->where('order_status', 'Ready to Ship')->latest()->get();

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

    public function create()
    {
        $products = Product::with([
            'images' => fn ($q) => $q->where('is_main', 1),
            'variants.images',
            'category',
            'subcategory',
        ])->get();

        return view('backend.order.create', compact('products'));
    }

    // public function store(Request $request)
    // {
    //     dd($request->all());
    // }

    // public function edit($id)
    // {
    //     return view('backend.order.edit');
    // }

    // public function update(Request $request, $id)
    // {
    //     dd($request->all());
    // }

    public function status(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|string|in:pending,confirmed,Ready to Ship,shipped,delivered,cancelled,refunded',
        ]);

        try {
            $ids = $request->ids;
            $decodedIds = [];

            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $decoded = json_decode($id, true);
                    if (is_array($decoded)) {
                        $decodedIds = array_merge($decodedIds, $decoded);
                    } else {
                        $decodedIds[] = $id;
                    }
                }
            } else {
                $decodedIds[] = $ids;
            }

            Order::whereIn('id', $decodedIds)
                ->update(['order_status' => $request->status]);

            return redirect()->back()->with('success', 'Selected orders status updated to '.ucfirst($request->status).' successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! '.$e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        try {
            $ids = $request->ids;
            if (is_array($ids)) {
                $decodedIds = [];
                foreach ($ids as $id) {
                    $decoded = json_decode($id, true);
                    if (is_array($decoded)) {
                        $decodedIds = array_merge($decodedIds, $decoded);
                    } else {
                        $decodedIds[] = $id;
                    }
                }
            } else {
                $decodedIds = [$ids];
            }

            Order::whereIn('id', $decodedIds)->delete();

            return redirect()->back()->with('success', 'Selected orders deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'shipping'])->findOrFail($id);

        $subtotal = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shipping = $order->shipping_charge;

        $discount = $order->discount;

        $total = $subtotal + $shipping - $discount;

        return view('backend.order.show', compact('order', 'subtotal', 'total', 'shipping', 'discount'));
    }

    public function steadFast(Request $request)
    {
        dd($request->all());
    }

    public function pathao(Request $request)
    {
        dd($request->all());
    }
}
