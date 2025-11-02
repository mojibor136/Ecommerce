<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $query = Attribute::withCount('values')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $attributes = $query->paginate(50)->withQueryString();

        return view('backend.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('backend.attributes.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:attributes,name',
                'slug' => 'nullable|string|unique:attributes,slug',
                'status' => 'nullable|boolean',
            ]);

            $slug = $validated['slug'] ?? \Str::slug($validated['name']);
            if (Attribute::where('slug', $slug)->exists()) {
                $slug .= '-'.time();
            }

            Attribute::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'status' => $validated['status'] ?? 1,
            ]);

            return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('backend.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        try {
            $attribute = Attribute::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|unique:attributes,name,'.$id,
                'slug' => 'nullable|string|unique:attributes,slug,'.$id,
                'status' => 'nullable|boolean',
            ]);

            $slug = $validated['slug'] ?? \Str::slug($validated['name']);
            if (Attribute::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug .= '-'.time();
            }

            $attribute->update([
                'name' => $validated['name'],
                'slug' => $slug,
                'status' => $validated['status'] ?? 1,
            ]);

            return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();

            return redirect()->back()->with('success', 'Attribute deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
