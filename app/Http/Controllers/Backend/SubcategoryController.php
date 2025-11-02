<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category')
            ->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $subcategories = $query->latest()->paginate(50);
        $categories = Category::all();

        return view('backend.subcategory.index', compact('subcategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('backend.subcategory.create', compact('categories'));
    }

    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        $categories = Category::all();

        return view('backend.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255|unique:subcategories,name',
                'slug' => 'nullable|string|max:255|unique:subcategories,slug',
            ]);

            $slug = $validated['slug'] ?? Str::slug($validated['name']);

            if (Subcategory::where('slug', $slug)->exists()) {
                $slug .= '-'.time();
            }

            $subcategory = Subcategory::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
            ]);

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'Subcategory created successfully.');

        } catch (ValidationException $e) {
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
            $subcategory = Subcategory::findOrFail($id);

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255|unique:subcategories,name,'.$subcategory->id,
                'slug' => 'nullable|string|max:255|unique:subcategories,slug,'.$subcategory->id,
            ]);

            $slug = $validated['slug'] ?? Str::slug($validated['name']);

            if (Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->exists()) {
                $slug .= '-'.time();
            }

            $subcategory->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
            ]);

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'Subcategory updated successfully.');

        } catch (ValidationException $e) {
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
            $subcategory = Subcategory::findOrFail($id);

            if ($subcategory->products()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete this subcategory because it has products.');
            }

            $subcategory->delete();

            return redirect()->back()->with('success', 'Subcategory deleted successfully.');

        } catch (\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Subcategory not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }
}
