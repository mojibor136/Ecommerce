<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Banner::latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            $banners = $query->paginate(10)->appends($request->all());

            return view('backend.setting.banner.index', compact('banners'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load banners: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.setting.banner.create');
    }

    /**
     * Store or update banner in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'id'    => 'nullable|integer'
            ]);

            // If ID exists, update instead of create
            $banner = Banner::find($request->id) ?? new Banner();
            $banner->name = $request->name;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete existing image if any
                if ($banner->image && File::exists(public_path($banner->image))) {
                    File::delete(public_path($banner->image));
                }

                $image = $request->file('image');
                $fileName = 'banner_'.time().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/banner/';
                $image->move(public_path($path), $fileName);
                $banner->image = $path.$fileName;
            }

            $banner->save();

            $message = $request->id ? 'Banner updated successfully!' : 'Banner created successfully!';
            return redirect()->route('admin.banners.index')->with('success', $message);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to save banner: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }

            $banner->delete();

            return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete banner: '.$e->getMessage());
        }
    }
}
