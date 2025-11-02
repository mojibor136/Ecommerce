<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['subcategories', 'products']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        // যদি status filter দরকার হয়
        // if ($request->filled('status')) {
        //     $query->where('status', $request->status);
        // }

        $categories = $query->latest()->paginate(100);

        return view('backend.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('backend.category.edit', compact('category'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:categories,name',
                'slug' => 'required|string|unique:categories,slug',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            ]);

            $slug = $validated['slug'] ?? Str::slug($validated['name']);

            $count = Category::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-'.time();
            }

            // Slug Generate
            $slug = $validated['slug'] ?? Str::slug($validated['name']);
            if (Category::where('slug', $slug)->exists()) {
                $slug .= '-'.time();
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('uploads/categories');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $image->move($destinationPath, $filename);

                $imagePath = 'uploads/categories/'.$filename;
            }

            $category = Category::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: '.$e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|unique:categories,name,'.$id,
                'slug' => 'nullable|string|unique:categories,slug,'.$id,
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $slug = $validated['slug'] ?? Str::slug($validated['name']);
            $count = Category::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug .= '-'.time();
            }

            $imagePath = $category->image;

            if ($request->hasFile('image')) {
                if (! empty($category->image) && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $image = $request->file('image');
                $filename = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/categories');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $image->move($destinationPath, $filename);
                $imagePath = 'uploads/categories/'.$filename;
            }

            $category->update([
                'name' => $validated['name'],
                'slug' => $slug,
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: '.$e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->subcategories()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete this category because it has subcategories.');
            }

            if ($category->products()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete this category because it has products.');
            }

            if (! empty($category->image) && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $category->delete();

            return redirect()->back()->with('success', 'Category deleted successfully.');

        } catch (\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Category not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }
}
