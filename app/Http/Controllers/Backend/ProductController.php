<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use App\Models\VariantImage;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'images' => fn ($q) => $q->where('is_main', 1),
            'variants',
            'category',
            'subcategory',
        ])->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('sku', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        $products = $query->paginate(100)->withQueryString();

        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('backend.products.index', compact('products', 'categories', 'subcategories'));
    }

    public function create()
    {
        try {
            $categories = Category::where('status', 1)->get();
            $attributes = Attribute::where('status', 1)->get();

            return view('backend.products.create', compact('categories', 'attributes'));
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'buy_price' => 'required|numeric|min:0',
            'old_price' => 'required|numeric|min:0',
            'new_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:0,1',
            'type' => 'required|in:0,1',
            'hot_deal' => 'required|in:0,1',
        ];

        if ($request->type == 1) {
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.attribute_ids'] = 'required|array|min:1';
            $rules['variants.*.attribute_ids.*'] = 'exists:attributes,id';
            $rules['variants.*.attribute_value_ids'] = 'required|array|min:1';
            $rules['variants.*.attribute_value_ids.*'] = 'exists:attribute_values,id';
            $rules['variants.*.buy_price'] = 'required|numeric|min:0';
            $rules['variants.*.old_price'] = 'required|numeric|min:0';
            $rules['variants.*.new_price'] = 'required|numeric|min:0';
            $rules['variants.*.stock'] = 'required|numeric|min:0';
            $rules['variants.*.image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        $validated = $request->validate($rules);

        try {
            \DB::beginTransaction();

            $product = Product::create([
                'name' => $validated['name'],
                'desc' => $validated['description'],
                'sku' => $validated['sku'],
                'stock' => $validated['stock'],
                'buy_price' => $validated['buy_price'],
                'old_price' => $validated['old_price'],
                'new_price' => $validated['new_price'],
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'],
                'status' => $validated['status'],
                'hot_deal' => $validated['hot_deal'],
                'brand' => $validated['brand'] ?? ($setting->brand ?? null),
                'type' => $validated['type'],
            ]);

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = uniqid().'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/products'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                    'is_main' => 1,
                ]);
            }

            if ($validated['type'] == 1 && isset($validated['variants'])) {
                foreach ($validated['variants'] as $index => $variantData) {
                    $attrMapping = [];
                    foreach ($variantData['attribute_ids'] as $i => $attrId) {
                        $attribute = Attribute::find($attrId);
                        $valueIds = [$variantData['attribute_value_ids'][$i]];
                        $values = AttributeValue::whereIn('id', $valueIds)->pluck('value')->toArray();

                        $attrMapping[] = [
                            'attribute_id' => $attrId,
                            'attribute_name' => $attribute->name,
                            'value_ids' => $valueIds,
                            'values' => $values,
                        ];
                    }

                    $variantImageName = null;
                    if (isset($variantData['image']) && $request->hasFile("variants.$index.image")) {
                        $imageFile = $request->file("variants.$index.image");
                        $variantImageName = uniqid().'_variant.'.$imageFile->getClientOriginalExtension();
                        $imageFile->move(public_path('uploads/products/variants'), $variantImageName);
                    }

                    $product_variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'buy_price' => $variantData['buy_price'],
                        'old_price' => $variantData['old_price'],
                        'new_price' => $variantData['new_price'],
                        'stock' => $variantData['stock'],
                        'attributes' => $attrMapping,
                    ]);

                    VariantImage::create([
                        'product_variant_id' => $product_variant->id,
                        'image' => $variantImageName,
                        'is_main' => '0',
                    ]);
                }
            }

            \DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            \DB::rollBack();

            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function getSubcategories($category_id)
    {
        $data = SubCategory::where('category_id', $category_id)
            ->where('status', 1)
            ->select('id', 'name')
            ->get();

        return response()->json($data);
    }

    public function getAttributeValuesMultiple(Request $request)
    {
        $ids = explode(',', $request->ids ?? '');
        $values = AttributeValue::with('attribute:id,name')
            ->whereIn('attribute_id', $ids)
            ->where('status', 1)
            ->get(['id', 'attribute_id', 'value']);

        $grouped = $values->groupBy('attribute.name')->map(function ($group) {
            return $group->map(function ($v) {
                return ['id' => $v->id, 'value' => $v->value];
            });
        });

        return response()->json($grouped);
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variants.images'])->findOrFail($id);
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();

        $variants = $product->variants->map(function ($variant) {
            $attributes = $variant->attributes;

            if (! is_array($attributes)) {
                $attributes = json_decode($attributes, true) ?? [];
            }

            return [
                'id' => $variant->id,
                'buy_price' => $variant->buy_price,
                'old_price' => $variant->old_price,
                'new_price' => $variant->new_price,
                'stock' => $variant->stock,
                'attributes' => $attributes,
            ];
        });

        return view('backend.products.edit', compact('product', 'categories', 'attributes', 'variants'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,'.$id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'buy_price' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'new_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
            'type' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'variants' => 'nullable|array',
        ]);

        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'desc' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'buy_price' => $request->buy_price,
            'old_price' => $request->old_price,
            'new_price' => $request->new_price,
            'stock' => $request->stock,
            'status' => $request->status,
            'hot_deal' => $request->hot_deal,
            'type' => $request->type,
            'brand' => $request->brand ?? ($setting->brand ?? null),
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);

            $oldImage = $product->images()->where('is_main', 1)->first();
            if ($oldImage) {
                $oldPath = public_path('uploads/products/'.$oldImage->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $oldImage->delete();
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $filename,
                'is_main' => 1,
            ]);
        }

        if ($request->type == 1 && $request->has('variants')) {

            $existingIds = $product->variants()->pluck('id')->toArray();
            $incomingIds = [];

            foreach ($request->variants as $index => $variantData) {

                $attrMapping = [];

                if (! empty($variantData['attribute_ids']) && ! empty($variantData['attribute_value_ids'])) {
                    foreach ($variantData['attribute_ids'] as $i => $attrId) {
                        if (! isset($variantData['attribute_value_ids'][$i]) || empty($variantData['attribute_value_ids'][$i])) {
                            continue;
                        }

                        $attribute = Attribute::find($attrId);
                        if (! $attribute) {
                            continue;
                        }

                        $valueIds = is_array($variantData['attribute_value_ids'][$i])
                            ? $variantData['attribute_value_ids'][$i]
                            : [$variantData['attribute_value_ids'][$i]];

                        if (empty($valueIds)) {
                            continue;
                        }

                        $values = AttributeValue::whereIn('id', $valueIds)->pluck('value')->toArray();

                        $attrMapping[] = [
                            'attribute_id' => $attrId,
                            'attribute_name' => $attribute->name,
                            'value_ids' => $valueIds,
                            'values' => $values,
                        ];
                    }
                }

                if (empty($attrMapping)) {
                    $variantData['attribute_value_ids'] = [];
                }

                if (isset($variantData['id'])) {
                    $variant = $product->variants()->find($variantData['id']);
                    if ($variant) {
                        $incomingIds[] = $variant->id;

                        $variant->update([
                            'buy_price' => $variantData['buy_price'] ?? 0,
                            'old_price' => $variantData['old_price'] ?? 0,
                            'new_price' => $variantData['new_price'] ?? 0,
                            'stock' => $variantData['stock'] ?? 0,
                            'attributes' => $attrMapping,
                        ]);

                        if (isset($variantData['image']) && is_file($variantData['image'])) {
                            $file = $variantData['image'];
                            $filename = time().'_'.$file->getClientOriginalName();
                            $file->move(public_path('uploads/products/variants'), $filename);

                            foreach ($variant->images as $img) {
                                $oldPath = public_path('uploads/products/variants/'.$img->image);
                                if (file_exists($oldPath)) {
                                    unlink($oldPath);
                                }
                                $img->delete();
                            }

                            VariantImage::create([
                                'product_variant_id' => $variant->id,
                                'image' => $filename,
                                'is_main' => 0,
                            ]);
                        }
                    }
                } else {
                    $newVariant = $product->variants()->create([
                        'buy_price' => $variantData['buy_price'] ?? 0,
                        'old_price' => $variantData['old_price'] ?? 0,
                        'new_price' => $variantData['new_price'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'attributes' => $attrMapping,
                    ]);

                    if (isset($variantData['image']) && is_file($variantData['image'])) {
                        $file = $variantData['image'];
                        $filename = time().'_'.$file->getClientOriginalName();
                        $file->move(public_path('uploads/products/variants'), $filename);

                        VariantImage::create([
                            'product_variant_id' => $newVariant->id,
                            'image' => $filename,
                            'is_main' => 0,
                        ]);
                    }

                    $incomingIds[] = $newVariant->id;
                }
            }

            $toDelete = array_diff($existingIds, $incomingIds);
            if (! empty($toDelete)) {
                $variantsToDelete = $product->variants()->whereIn('id', $toDelete)->get();
                foreach ($variantsToDelete as $variant) {
                    foreach ($variant->images as $img) {
                        $oldPath = public_path('uploads/products/variants/'.$img->image);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                        $img->delete();
                    }
                    $variant->delete();
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function inventory(Request $request)
    {
        $query = Product::with([
            'images' => fn ($q) => $q->where('is_main', 1),
            'variants.images',
            'category',
            'subcategory',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        $products = $query->latest()->paginate(10);

        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('backend.products.inventory', compact('products', 'categories', 'subcategories'));
    }

    public function updateStock(Request $request, $id, $variantId = null)
    {
        $request->validate([
            'stock_add' => 'required|integer|min:1',
        ]);

        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $variant->increment('stock', $request->stock_add);
        } else {
            $product = Product::findOrFail($id);
            $product->increment('stock', $request->stock_add);
        }

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->images) {
            foreach ($product->images as $image) {
                $imagePath = public_path('uploads/products/'.$image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        }

        if ($product->variants) {
            foreach ($product->variants as $variant) {
                if ($variant->images) {
                    foreach ($variant->images as $vImage) {
                        $vImagePath = public_path('uploads/products/variants/'.$vImage->image);
                        if (file_exists($vImagePath)) {
                            unlink($vImagePath);
                        }
                        $vImage->delete();
                    }
                }
                $variant->delete();
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product and its variants deleted successfully!');
    }

    public function destroyVariant($id)
    {
        $variant = ProductVariant::findOrFail($id);

        if ($variant->images) {
            foreach ($variant->images as $vImage) {
                $vImagePath = public_path('uploads/products/variants/'.$vImage->image);
                if (file_exists($vImagePath)) {
                    unlink($vImagePath);
                }
                $vImage->delete();
            }
        }

        $variant->delete();

        return redirect()->back()->with('success', 'Variant deleted successfully!');
    }

    public function OrderByProduct(Request $request)
    {
        $query = Product::with([
            'images' => fn ($q) => $q->where('is_main', 1),
            'variants.images',
            'category',
            'subcategory',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        $products = $query->latest()->paginate(10);

        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('backend.products.order_products', compact('products', 'categories', 'subcategories'));
    }

    public function updateOrders(Request $request)
    {
        $productId = $request->input('product_id');
        $categoryId = $request->input('category_id');
        $orders = $request->input('orders');

        if (isset($orders[$productId])) {
            $newOrder = $orders[$productId];

            $product = Product::where('id', $productId)
                ->where('category_id', $categoryId)
                ->first();

            if ($product) {
                $conflictingProduct = Product::where('category_id', $categoryId)
                    ->where('orders', $newOrder)
                    ->where('id', '!=', $productId)
                    ->first();

                if ($conflictingProduct) {
                    $oldOrder = $product->orders;
                    $conflictingProduct->orders = $oldOrder;
                    $conflictingProduct->save();
                }

                $product->orders = $newOrder;
                $product->save();
            }
        }

        return back()->with('success', 'Product order updated successfully!');
    }
}
