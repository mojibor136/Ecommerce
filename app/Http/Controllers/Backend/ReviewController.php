<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        try {
            $reviews = ProductReview::with('product')->latest()->paginate(50);

            return view('backend.reviews.index', compact('reviews'));
        } catch (\Throwable $e) {
            Log::error('Review Index Error: '.$e->getMessage());

            return back()->with('error', 'Something went wrong while loading reviews.');
        }
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        try {
            $products = Product::where('status', 1)->get();

            return view('backend.reviews.create', compact('products'));
        } catch (\Throwable $e) {
            Log::error('Review Create Error: '.$e->getMessage());

            return back()->with('error', 'Unable to load product list.');
        }
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            ProductReview::create([
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Review Store Error: '.$e->getMessage());

            return back()->withInput()->with('error', 'Failed to create review.');
        }
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit($id)
    {
        try {
            $review = ProductReview::findOrFail($id);
            $products = Product::where('status', 1)->get();

            return view('backend.reviews.edit', compact('review', 'products'));
        } catch (\Throwable $e) {
            Log::error('Review Edit Error: '.$e->getMessage());

            return back()->with('error', 'Review not found or could not be loaded.');
        }
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            $review = ProductReview::findOrFail($id);
            $review->update([
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Review Update Error: '.$e->getMessage());

            return back()->withInput()->with('error', 'Failed to update review.');
        }
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy($id)
    {
        try {
            $review = ProductReview::findOrFail($id);
            $review->delete();

            return back()->with('success', 'Review deleted successfully!');
        } catch (\Throwable $e) {
            Log::error('Review Delete Error: '.$e->getMessage());

            return back()->with('error', 'Failed to delete review.');
        }
    }
}
