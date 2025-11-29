<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

        $ordersCount = [];
        foreach ($statuses as $status) {
            $ordersCount[$status] = Order::where('order_status', $status)->count();
        }

        $ordersCount['all order'] = Order::count();

        $productCount = Product::count();
        $categoryCount = Category::count();
        $subcategoryCount = Subcategory::count();

        $dailySales = Order::whereDate('created_at', now())
            ->where('order_status', 'delivered')
            ->sum('total');

        $monthlySales = Order::whereMonth('created_at', now()->month)
            ->where('order_status', 'delivered')
            ->sum('total');

        $recentOrders = Order::latest()->take(10)->get();

        $topProducts = Product::withCount(['orderItems as sold_count' => function ($query) {
            $query->select(\DB::raw('SUM(quantity)'));
        }])->orderBy('sold_count', 'desc')->take(10)->get();

        return view('backend.dashboard', compact(
            'ordersCount',
            'productCount',
            'categoryCount',
            'subcategoryCount',
            'dailySales',
            'monthlySales',
            'recentOrders',
            'topProducts'
        ));
    }

    public function account()
    {
        $admin = auth()->user();

        return view('backend.setting.account.index', compact('admin'));
    }

    public function accountStore(Request $request)
    {
        $admin = auth()->user();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$admin->id,
                'password' => 'nullable|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->filled('password')) {
                $admin->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                if ($admin->image && File::exists(public_path($admin->image))) {
                    File::delete(public_path($admin->image));
                }

                $imageName = time().'_'.$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads/admin'), $imageName);
                $admin->image = 'uploads/admin/'.$imageName;
            }

            $admin->save();

            return redirect()->back()->with('success', 'Account updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update account: '.$e->getMessage());
        }
    }
}
