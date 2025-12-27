@extends('backend.layouts.app')
@section('title', 'Add New Product')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/fsx8l20fj4nn5mesnxt5ddhbf0yrj7q6kz5ph1i042r9p7ub/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <style>
        .ts-control {
            border: 1px solid #d0d0d0;
            padding: 11px 12px;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
            box-sizing: border-box;
            box-shadow: none;
            border-radius: 6px;
            display: flex;
            flex-wrap: wrap;
        }
    </style>

    <div class="w-full h-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Add Products</h2>
                <a href="{{ route('admin.products.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Products
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a>
                    / Product /
                    Create
                </p>
                <a href="{{ route('admin.products.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Products
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST"
                enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Product Name -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Product Name</label>
                    <input type="text" name="name" placeholder="Product Name" id="productName"
                        value="{{ old('name') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Product Description -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Product Description</label>
                    <textarea id="productDescription" name="description"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm sm:text-base">{{ old('description') }}</textarea>
                </div>


                <!-- SKU -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">SKU</label>
                    <input type="text" name="sku" placeholder="SKU" value="{{ old('sku') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Brand -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Brand Name</label>
                    <input type="text" name="brand" placeholder="Brand Name" value="{{ old('brand') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Stock -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Stock</label>
                    <input type="number" name="stock" placeholder="Stock" value="{{ old('stock') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Category -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Select Category</label>
                    <select name="category_id" id="category" required
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategory -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Select Subcategory</label>
                    <select name="subcategory_id" id="subcategory"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="">-- Select Subcategory --</option>
                        @if (old('subcategory_id') && old('category_id'))
                            @php
                                $subcats = \App\Models\Subcategory::where('category_id', old('category_id'))->get();
                            @endphp
                            @foreach ($subcats as $sc)
                                <option value="{{ $sc->id }}"
                                    {{ old('subcategory_id') == $sc->id ? 'selected' : '' }}>
                                    {{ $sc->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Buy Price -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Buy Price</label>
                    <input type="number" name="buy_price" placeholder="Enter Buy Price" value="{{ old('buy_price') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Old Price -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Old Price</label>
                    <input type="number" name="old_price" placeholder="Enter Old Price" value="{{ old('old_price') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- New Price -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">New Price</label>
                    <input type="number" name="new_price" placeholder="Enter New Price" value="{{ old('new_price') }}"
                        class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>

                <!-- Image -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Product Image</label>
                    <input type="file" name="image[]" accept="image/*" multiple
                        class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
           file:bg-[{{ $theme->theme_bg }}] file:text-[{{ $theme->theme_text }}] file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
           hover:file:bg-[{{ $theme->theme_hover }}] transition-all duration-200">
                </div>

                <!-- Status -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Product Type -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Product Type</label>
                    <select name="type"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="0" {{ old('type') == 0 ? 'selected' : '' }}>Normal</option>
                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Variable</option>
                    </select>
                </div>

                <!-- Hot Deals -->
                <div class="col-span-2 md:col-span-2">
                    <label class="block text-md text-gray-700 mb-1 font-medium"><i
                            class="ri-fire-fill text-orange-500"></i> Hot Deals</label>
                    <select name="hot_deal"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5
        text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200 border-gray-300">
                        <option value="1" {{ old('hot_deal', '1') == '1' ? 'selected' : '' }}>On</option>
                        <option value="0" {{ old('hot_deal') == '0' ? 'selected' : '' }}>Off</option>
                    </select>
                </div>

                <!-- Variable Products Section -->
                <div class="col-span-2" id="variableProductsSection" style="display: none;">
                    <label class="block text-md text-gray-700 mb-1 font-medium">Product Variants</label>
                    <div id="variableProductsContainer" class="flex flex-col gap-3"></div>
                    <button type="button" id="addVariantBtn"
                        class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        + Add Variant
                    </button>
                </div>

                <!-- Submit -->
                <div class="col-span-2 mt-4">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 text-base transition-all duration-200">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productType = document.querySelector('select[name="type"]');
            const variableSection = document.getElementById('variableProductsSection');
            const container = document.getElementById('variableProductsContainer');
            const addBtn = document.getElementById('addVariantBtn');
            let variantIndex = 0;

            function createVariantRow(index = null, oldData = null) {
                variantIndex = index !== null ? index : variantIndex + 1;
                const row = document.createElement('div');
                row.classList.add('bg-gray-50', 'p-5', 'rounded-lg', 'shadow-sm', 'border', 'border-gray-200',
                    'space-y-4', 'variant-row');

                const attrId = `attribute_${variantIndex}`;
                const valId = `attributeValue_${variantIndex}`;

                row.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">Attributes</label>
                    <select id="${attrId}" name="variants[${variantIndex}][attribute_ids][]" multiple class="w-full">
                        @foreach ($attributes as $attr)
                            <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">Attribute Values</label>
                    <select id="${valId}" name="variants[${variantIndex}][attribute_value_ids][]" multiple class="w-full"></select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">Buy Price</label>
                    <input type="number" name="variants[${variantIndex}][buy_price]" placeholder="Buy Price" value="${oldData?.buy_price ?? ''}" class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">Old Price</label>
                    <input type="number" name="variants[${variantIndex}][old_price]" placeholder="Old Price" value="${oldData?.old_price ?? ''}" class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">New Price</label>
                    <input type="number" name="variants[${variantIndex}][new_price]" placeholder="New Price" value="${oldData?.new_price ?? ''}" class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1 font-medium">Stock</label>
                    <input type="number" name="variants[${variantIndex}][stock]" placeholder="Stock" value="${oldData?.stock ?? ''}" class="w-full rounded-md bg-white text-gray-900 border border-gray-300 px-3 py-2
    text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] transition-all duration-200">
                </div>
             <div>
                <label class="block text-sm text-gray-700 mb-1 font-medium">Variant Image</label>
                <input type="file" name="variants[${variantIndex}][image]" accept="image/*" class="w-full rounded-md border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[{{ $theme->theme_bg }}]
           file:bg-indigo-600 file:text-white file:border-0 file:rounded-l file:px-3 file:py-2 file:cursor-pointer
           hover:file:bg-indigo-700 transition-all duration-200">
            </div>
            <div class="w-full">
                <label class="block text-sm text-gray-700 mb-1 font-medium">Variant Close</label>
                <button type="button" class="removeVariantBtn bg-red-500 text-white px-4 py-2 w-full rounded-md hover:bg-red-600 transition">✕ Remove Variant</button>
            </div>
            </div>
        `;

                container.appendChild(row);

                row.querySelector('.removeVariantBtn').addEventListener('click', () => row.remove());

                const attrSelect = new TomSelect(`#${attrId}`, {
                    plugins: ['remove_button'],
                    placeholder: "Select Attributes",
                    create: false,
                    dropdownParent: 'body',
                    onInitialize: function() {
                        const tsWrapper = document.querySelector(`#${attrId}_ts-control`);
                        if (tsWrapper) {
                            tsWrapper.style.width = '100%';
                            tsWrapper.style.padding = '8px';
                        }
                    }
                });

                const valSelect = new TomSelect(`#${valId}`, {
                    plugins: ['remove_button'],
                    placeholder: "Select Attribute Values",
                    create: false,
                    dropdownParent: 'body',
                    optgroupField: 'group',
                    labelField: 'value',
                    valueField: 'id',
                    onInitialize: function() {
                        const tsWrapper = document.querySelector(`#${valId}_ts-control`);
                        if (tsWrapper) {
                            tsWrapper.style.width = '100%';
                            tsWrapper.style.padding = '8px';
                        }
                    }
                });

                if (oldData?.attribute_ids) oldData.attribute_ids.forEach(v => attrSelect.addItem(v));

                attrSelect.on('change', function(values) {
                    if (!values.length) return valSelect.clearOptions();

                    fetch(`/admin/get-attribute-values?ids=${values.join(',')}`)
                        .then(res => res.json())
                        .then(data => {
                            valSelect.clearOptions();
                            Object.keys(data).forEach(group => {
                                data[group].forEach(item => {
                                    valSelect.addOption({
                                        id: item.id,
                                        value: item.value,
                                        group: group
                                    });
                                });
                            });
                            valSelect.refreshOptions(false);
                            if (oldData?.attribute_value_ids) oldData.attribute_value_ids.forEach(v =>
                                valSelect.addItem(v));
                        })
                        .catch(err => console.error(err));
                });

                if (oldData?.attribute_value_ids) oldData.attribute_value_ids.forEach(v => valSelect.addItem(v));
            }

            productType.addEventListener('change', () => {
                if (productType.value === "1") {
                    variableSection.style.display = 'block';
                    if (container.children.length === 0) createVariantRow();
                } else {
                    variableSection.style.display = 'none';
                    container.innerHTML = '';
                }
            });

            addBtn.addEventListener('click', () => createVariantRow());

            @if (old('variants'))
                const oldVariants = @json(old('variants'));
                variableSection.style.display = 'block';
                Object.values(oldVariants).forEach(v => createVariantRow(null, v));
            @endif
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const category = document.getElementById('category');
            const subcategory = document.getElementById('subcategory');
            category.addEventListener('change', () => {
                fetch(`/admin/get-subcategories/${category.value}`)
                    .then(res => res.json())
                    .then(data => {
                        subcategory.innerHTML = '<option value="">-- Select Subcategory --</option>';
                        data.forEach(sc => subcategory.innerHTML +=
                            `<option value="${sc.id}">${sc.name}</option>`);
                    });
            });
        });
    </script>

    <script>
        tinymce.init({
            selector: '#productDescription',
            height: 300,
            menubar: false,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.setContent(`{!! old('description') !!}`);
                });
            }
        });
    </script>
@endsection
