<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Product;
use File;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $landing = LandingPage::latest()->paginate(10);

        return view('backend.landing.index', compact('landing'));
    }

    public function create()
    {
        $products = Product::all();

        return view('backend.landing.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'campaign_title' => 'required|string|max:255',
            'banner_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'review_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner_image')) {
            $bannerImages = [];
            foreach ($request->file('banner_image') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/landing/banners'), $filename);
                $bannerImages[] = 'uploads/landing/banners/'.$filename;
            }
            $data['banner_image'] = json_encode($bannerImages);
        }

        if ($request->hasFile('review_image')) {
            $reviewImages = [];
            foreach ($request->file('review_image') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/landing/reviews'), $filename);
                $reviewImages[] = 'uploads/landing/reviews/'.$filename;
            }
            $data['review_image'] = json_encode($reviewImages);
        }

        LandingPage::create($data);

        return redirect()->route('admin.landing.index')->with('success', 'Campaign created successfully.');
    }

    public function edit(LandingPage $landing)
    {
        $products = Product::all();

        return view('backend.landing.edit', compact('landing', 'products'));
    }

    public function update(Request $request, LandingPage $landing)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'campaign_title' => 'required|string|max:255',
            'banner_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'review_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner_image')) {
            if ($landing->banner_image) {
                foreach (json_decode($landing->banner_image) as $oldBanner) {
                    if (File::exists(public_path($oldBanner))) {
                        File::delete(public_path($oldBanner));
                    }
                }
            }
            $bannerImages = [];
            foreach ($request->file('banner_image') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/landing/banners'), $filename);
                $bannerImages[] = 'uploads/landing/banners/'.$filename;
            }
            $data['banner_image'] = json_encode($bannerImages);
        }

        if ($request->hasFile('review_image')) {
            if ($landing->review_image) {
                foreach (json_decode($landing->review_image) as $oldReview) {
                    if (File::exists(public_path($oldReview))) {
                        File::delete(public_path($oldReview));
                    }
                }
            }
            $reviewImages = [];
            foreach ($request->file('review_image') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/landing/reviews'), $filename);
                $reviewImages[] = 'uploads/landing/reviews/'.$filename;
            }
            $data['review_image'] = json_encode($reviewImages);
        }

        $landing->update($data);

        return redirect()->route('admin.landing.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(LandingPage $landing)
    {
        if ($landing->banner_image) {
            foreach (json_decode($landing->banner_image) as $banner) {
                if (File::exists(public_path($banner))) {
                    File::delete(public_path($banner));
                }
            }
        }

        if ($landing->review_image) {
            foreach (json_decode($landing->review_image) as $review) {
                if (File::exists(public_path($review))) {
                    File::delete(public_path($review));
                }
            }
        }

        $landing->delete();

        return redirect()->route('admin.landing.index')->with('success', 'Campaign deleted successfully.');
    }
}
