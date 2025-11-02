<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = SocialMedia::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('link', 'LIKE', "%{$search}%");
                });
            }

            $socials = $query->latest()->paginate(10);
            $socials->appends($request->all());

            return view('backend.setting.social.index', compact('socials'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('backend.setting.social.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'link' => 'required|url|max:500',
                'status' => 'required|boolean',
            ]);

            SocialMedia::create($request->only('name', 'link', 'status'));

            return redirect()->route('admin.social_media.index')
                ->with('success', 'Social Media added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to add Social Media: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $social = SocialMedia::findOrFail($id);

            return view('backend.setting.social.edit', compact('social'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.social_media.index')->with('error', 'Social Media not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'link' => 'required|url|max:500',
                'status' => 'required|boolean',
            ]);

            $social = SocialMedia::findOrFail($id);
            $social->update($request->only('name', 'link', 'status'));

            return redirect()->route('admin.social_media.index')
                ->with('success', 'Social Media updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.social_media.index')->with('error', 'Social Media not found.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update Social Media: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $social = SocialMedia::findOrFail($id);
            $social->delete();

            return redirect()->route('admin.social_media.index')
                ->with('success', 'Social Media deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.social_media.index')->with('error', 'Social Media not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Social Media: '.$e->getMessage());
        }
    }
}
