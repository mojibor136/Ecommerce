<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request)
    {
        try {
            $query = Coupon::with('category')->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('code', 'like', "%{$search}%");
            }

            $coupons = $query->paginate(10)->appends($request->all());

            return view('backend.coupon.index', compact('coupons'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load coupons: '.$e->getMessage());
        }
    }

    /**
     * Show create coupon form.
     */
    public function create()
    {
        try {
            $categories = Category::all();

            return view('backend.coupon.create', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load create page: '.$e->getMessage());
        }
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|max:50|unique:coupons,code',
                'type' => 'required|in:percent,fixed',
                'value' => 'required|numeric|min:0',
                'min_purchase' => 'nullable|numeric|min:0',
                'category' => 'nullable|exists:categories,id',
                'expiry_date' => 'nullable|date',
                'status' => 'required|boolean',
            ]);

            Coupon::create([
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'value' => $request->value,
                'min_purchase' => $request->min_purchase,
                'category_id' => $request->category,
                'expiry_date' => $request->expiry_date,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create coupon: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing a coupon.
     */
    public function edit($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $categories = Category::all();

            return view('backend.coupon.edit', compact('coupon', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load edit form: '.$e->getMessage());
        }
    }

    /**
     * Update an existing coupon.
     */
    public function update(Request $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $request->validate([
                'code' => 'required|string|max:50|unique:coupons,code,'.$coupon->id,
                'type' => 'required|in:percent,fixed',
                'value' => 'required|numeric|min:0',
                'min_purchase' => 'nullable|numeric|min:0',
                'category' => 'nullable|exists:categories,id',
                'expiry_date' => 'nullable|date',
                'status' => 'required|boolean',
            ]);

            $coupon->update([
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'value' => $request->value,
                'min_purchase' => $request->min_purchase,
                'category_id' => $request->category,
                'expiry_date' => $request->expiry_date,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update coupon: '.$e->getMessage());
        }
    }

    /**
     * Delete a coupon.
     */
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete coupon: '.$e->getMessage());
        }
    }
}
