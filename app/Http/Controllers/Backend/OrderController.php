<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Courier;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

    public function create(Request $request)
    {
        $allcategories = Category::all();

        $query = Product::with('images');

        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->filled('min_price')) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('new_price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $rating = (float) $request->rating;

            $query->whereHas('activeReviews', function ($q) use ($rating) {
                $q->where('rating', '>=', $rating);
            })
                ->withAvg('activeReviews', 'rating')
                ->having('active_reviews_avg_rating', '>=', $rating);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('new_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('new_price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('activeReviews', 'rating')
                        ->orderByDesc('active_reviews_avg_rating');
                    break;
                default:
                    $query->orderBy('orders', 'asc');
            }
        } else {
            $query->orderBy('orders', 'asc');
        }

        $products = $query->get();

        $minPrice = Product::min('new_price');
        $maxPrice = Product::max('new_price');

        return view('frontend.shop', compact(
            'products',
            'allcategories',
            'minPrice',
            'maxPrice'
        ));
    }

    public function edit($id)
    {

        $order = Order::with(['shipping', 'items'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be edited.');
        }

        return view('backend.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('shipping')->findOrFail($id);

        $order->shipping->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Shipping updated successfully!');
    }

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

    public function invoice(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        try {

            $rawIds = $request->ids;
            $decodedIds = [];

            if (is_array($rawIds)) {
                foreach ($rawIds as $value) {
                    $json = json_decode($value, true);

                    if (is_array($json)) {
                        $decodedIds = array_merge($decodedIds, $json);
                    } else {
                        $decodedIds[] = $value;
                    }
                }
            } else {
                $json = json_decode($rawIds, true);
                if (is_array($json)) {
                    $decodedIds = $json;
                } else {
                    $decodedIds = [$rawIds];
                }
            }

            $decodedIds = array_unique($decodedIds);

            $orders = Order::with(['shipping', 'items'])->whereIn('id', $decodedIds)->get();

            return view('backend.order.invoice', compact('orders'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function steadFast(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        try {

            $rawIds = $request->ids;
            $decodedIds = [];

            if (is_array($rawIds)) {
                foreach ($rawIds as $value) {
                    $json = json_decode($value, true);
                    if (is_array($json)) {
                        $decodedIds = array_merge($decodedIds, $json);
                    } else {
                        $decodedIds[] = $value;
                    }
                }
            } else {
                $json = json_decode($rawIds, true);
                if (is_array($json)) {
                    $decodedIds = $json;
                } else {
                    $decodedIds = [$rawIds];
                }
            }

            $decodedIds = array_unique($decodedIds);

            $steadfast = Courier::where('type', 'steadfast')->first();

            $orders = Order::with(['shipping', 'items', 'payment'])
                ->whereIn('id', $decodedIds)
                ->get();

            $api_key = $steadfast->api_key;
            $secret_key = $steadfast->secret_key;
            $base_url = $steadfast->url;

            /* -----------------------------------
             * SINGLE ORDER
             * ----------------------------------- */
            if (count($orders) == 1) {

                $order = $orders->first();

                $order_data = [
                    'invoice' => $order->id.'-'.time(),
                    'recipient_name' => $order->shipping->name,
                    'recipient_phone' => $order->shipping->phone,
                    'recipient_address' => $order->shipping->address,
                    'cod_amount' => $order->total,
                    'note' => $order->note ?? '',
                    'item_description' => $order->items->map(fn ($item) => $item->product->name)->implode(', '),
                ];

                $response = Http::withHeaders([
                    'Api-Key' => $api_key,
                    'Secret-Key' => $secret_key,
                    'Content-Type' => 'application/json',
                ])->post($base_url.'/create_order', $order_data);

                $res = $response->json();

                if (isset($res['status']) && $res['status'] == 200) {
                    $order->order_status = 'shipped';
                    $order->courier_method = 'Steadfast';
                    $order->tracking_id = $res['consignment']['tracking_code'];
                    $order->save();
                } else {
                    return back()
                        ->with('error', $res['message'] ?? 'Unknown error for order '.$order->id);
                }

                /* -----------------------------------
                 * BULK ORDER
                 * ----------------------------------- */
            } else {

                $data = [];

                foreach ($orders as $order) {
                    $data[] = [
                        'invoice' => $order->id.'-'.time(),
                        'recipient_name' => $order->shipping->name,
                        'recipient_phone' => $order->shipping->phone,
                        'recipient_address' => $order->shipping->address,
                        'cod_amount' => $order->total,
                        'note' => $order->note ?? '',
                        'item_description' => $order->items->map(fn ($item) => $item->product->name)->implode(', '),
                    ];
                }

                $response = Http::withHeaders([
                    'Api-Key' => $api_key,
                    'Secret-Key' => $secret_key,
                    'Content-Type' => 'application/json',
                ])->post($base_url.'/create_order/bulk-order', [
                    'data' => json_encode($data),
                ]);

                $res = $response->json();

                if (isset($res['status']) && $res['status'] == 200 && isset($res['data'])) {

                    foreach ($res['data'] as $index => $consignment) {

                        $tracking = $consignment['tracking_code'];
                        $status = $consignment['status'];

                        if ($status === 'success' && $tracking) {
                            $orders[$index]->order_status = 'shipped';
                            $orders[$index]->courier_method = 'Steadfast';
                            $orders[$index]->tracking_id = $tracking;
                            $orders[$index]->save();
                        }
                    }

                } else {
                    return back()->with('error', $res['message'] ?? 'Unknown error for bulk orders');
                }
            }

            return back()->with('success', 'Orders sent successfully to SteadFast!');

        } catch (\Exception $e) {

            Log::error('SteadFast Exception', [
                'exception' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Exception: '.$e->getMessage());
        }
    }

    public function redx(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        try {
            $rawIds = $request->ids;
            $decodedIds = [];

            if (is_array($rawIds)) {
                foreach ($rawIds as $value) {
                    $json = json_decode($value, true);
                    if (is_array($json)) {
                        $decodedIds = array_merge($decodedIds, $json);
                    } else {
                        $decodedIds[] = $value;
                    }
                }
            } else {
                $json = json_decode($rawIds, true);
                if (is_array($json)) {
                    $decodedIds = $json;
                } else {
                    $decodedIds = [$rawIds];
                }
            }

            $decodedIds = array_unique($decodedIds);

            if (count($decodedIds) > 1) {
                return back()->with('error', 'RedX only supports single parcel creation. Please select one order at a time.');
            }

            $orderId = $decodedIds[0];
            if ($orderId <= 0) {
                return back()->with('error', 'Invalid order selected for RedX parcel.');
            }

            $order = Order::with(['shipping', 'items', 'payment'])->find($orderId);

            if (! $order) {
                return back()->with('error', 'Order not found.');
            }

            $redxToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxIiwiaWF0IjoxNzM1NTMxNjU2LCJpc3MiOiJ0OTlnbEVnZTBUTm5MYTNvalh6MG9VaGxtNEVoamNFMyIsInNob3BfaWQiOjEsInVzZXJfaWQiOjZ9.zpKfyHK6zPBVaTrYevnCqnUA-e2jFKQJ7lK-z4aOx2g';
            $baseUrl = 'https://sandbox.redx.com.bd/v1.0.0-beta';
            $parcelData = [
                'customer_name' => $order->shipping->name,
                'customer_phone' => $order->shipping->phone,
                'delivery_area' => $order->shipping->area ?? 'Unknown',
                'delivery_area_id' => $order->shipping->area_id ?? 1,
                'customer_address' => $order->shipping->address,
                'merchant_invoice_id' => $order->id.'-'.time(),
                'cash_collection_amount' => $order->total,
                'parcel_weight' => $order->weight ?? 500,
                'instruction' => $order->note ?? '',
                'value' => $order->total,
                'parcel_details_json' => $order->items->map(fn ($item) => [
                    'name' => $item->product->name,
                    'category' => $item->product->category->name ?? 'General',
                    'value' => $item->price,
                ]),
            ];

            $response = Http::withHeaders([
                'API-ACCESS-TOKEN' => "Bearer {$redxToken}",
                'Content-Type' => 'application/json',
            ])->post($baseUrl.'/parcel', $parcelData);

            $res = $response->json();

            if (isset($res['tracking_id'])) {
                $order->tracking_id = $res['tracking_id'];
                $order->order_status = 'shipped';
                $order->courier_method = 'RedX';
                $order->save();

                return back()->with('success', 'RedX parcel created successfully. Tracking ID: '.$res['tracking_id']);
            } else {
                return back()->with('error', $res['message'] ?? 'Failed to create RedX parcel.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Exception: '.$e->getMessage());
        }
    }
}
