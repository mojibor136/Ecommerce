@extends('backend.layouts.app')
@section('title', 'Add New Campaign')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">
        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Campaign</h2>
                <a href="{{ route('admin.landing.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-sm font-medium hover:file:bg-[{{ $theme->theme_hover }}] transition">
                    All Campaign
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Campaign /
                    Create
                </p>
                <a href="{{ route('admin.landing.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-base font-medium hover:file:bg-[{{ $theme->theme_hover }}] transition">
                    All Campaign
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.landing.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf

                <!-- Product & Variant -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Select Product</label>
                    <select name="product_id" id="product_id"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"> {{ \Illuminate\Support\Str::limit($product->name, 100) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Campaign Title -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Campaign Title</label>
                    <input type="text" name="campaign_title" placeholder="Campaign Title"
                        value="{{ old('campaign_title') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Campaign Description -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Campaign Description</label>
                    <textarea id="campaign_description" name="campaign_description" placeholder="Campaign Description"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">{{ old('campaign_description') }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Video URL</label>
                    <input type="text" name="video_url" placeholder="Video URL" value="{{ old('video_url') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Banner Images & Review Images -->
                <div class="col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Banner Images</label>
                    <input type="file" name="banner_image[]" multiple
                        class="w-full rounded-md border px-3 sm:px-4 py-2 text-sm sm:text-base border-gray-300">
                </div>

                <div class="col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Review Images</label>
                    <input type="file" name="review_image[]" multiple
                        class="w-full rounded-md border px-3 sm:px-4 py-2 text-sm sm:text-base border-gray-300">
                </div>

                <!-- Description Title & Action -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Description Title</label>
                    <input type="text" name="description_title" placeholder="Description Title"
                        value="{{ old('description_title') }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Description</label>
                    <textarea id="description" name="description" placeholder="Description"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">{{ old('description') }}</textarea>
                </div>

                <!-- Why Buy From Us -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Why Buy From Us</label>
                    <textarea id="why_buy_from_us" name="why_buy_from_us" placeholder="Why Buy From Us"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">{{ old('why_buy_from_us') }}</textarea>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] disabled:opacity-60 disabled:cursor-not-allowed py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Create Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/lang/summernote-en-US.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Write something...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#campaign_description').summernote({
                placeholder: 'Write something...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#why_buy_from_us').summernote({
                placeholder: 'Write something...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
