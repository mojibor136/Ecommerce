<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Exception;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index(Request $request)
    {
        try {
            $attributes = Attribute::select('id', 'name')->orderBy('name')->get();

            $query = AttributeValue::with('attribute')->latest();

            if ($request->has('attribute_id') && $request->attribute_id != '') {
                $query->where('attribute_id', $request->attribute_id);
            }

            $values = $query->paginate(50);

            return view('backend.attribute_values.index', compact('values', 'attributes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function create()
    {
        try {
            $attributes = Attribute::all();

            return view('backend.attribute_values.create', compact('attributes'));
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'attribute_id' => 'required|exists:attributes,id',
                'value' => 'required|string|max:255|unique:attribute_values,value,NULL,id,attribute_id,'.$request->attribute_id,
                'color_code' => 'nullable|string|max:7',
                'status' => 'nullable|boolean',
            ]);

            AttributeValue::create([
                'attribute_id' => $validated['attribute_id'],
                'value' => $validated['value'],
                'color_code' => $validated['color_code'] ?? null,
                'status' => $validated['status'] ?? 1,
            ]);

            return redirect()->route('admin.attribute_values.index')
                ->with('success', 'Attribute value created successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create attribute value: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $value = AttributeValue::findOrFail($id);
            $attributes = Attribute::all();

            return view('backend.attribute_values.edit', compact('value', 'attributes'));
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $value = AttributeValue::findOrFail($id);

            $validated = $request->validate([
                'attribute_id' => 'required|exists:attributes,id',
                'value' => 'required|string|max:255|unique:attribute_values,value,'.$id.',id,attribute_id,'.$request->attribute_id,
                'color_code' => 'nullable|string|max:7',
                'status' => 'nullable|boolean',
            ]);

            $value->update([
                'attribute_id' => $validated['attribute_id'],
                'value' => $validated['value'],
                'color_code' => $validated['color_code'] ?? null,
                'status' => $validated['status'] ?? 1,
            ]);

            return redirect()->route('admin.attribute_values.index')
                ->with('success', 'Attribute value updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update attribute value: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $value = AttributeValue::findOrFail($id);
            $value->delete();

            return back()->with('success', 'Attribute value deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete attribute value: '.$e->getMessage());
        }
    }
}
