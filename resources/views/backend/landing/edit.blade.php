@extends('backend.layouts.app')
@section('title', 'Edit Campaign')
@section('content')
    <div class="w-full flex flex-col gap-4 mb-20">

        <!-- Header -->
        <div class="flex flex-col bg-white shadow rounded md:p-6 p-4 md:gap-1 gap-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Campaign</h2>
                <a href="{{ route('admin.landing.index') }}"
                    class="block md:hidden bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-sm font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Campaign
                </a>
            </div>
            <div class="flex justify-between items-center text-gray-600 text-sm">
                <p>
                    <a href="{{ route('admin.dashboard') }}" class="text-[{{ $theme->theme_bg }}] hover:underline">Home</a> /
                    Campaign /
                    Edit
                </p>
                <a href="{{ route('admin.landing.index') }}"
                    class="hidden md:inline-flex items-center bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] px-4 py-2 rounded text-base font-medium hover:bg-[{{ $theme->theme_hover }}] transition">
                    All Campaign
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="w-full bg-white rounded shadow px-6 py-6">
            <form action="{{ route('admin.landing.update', $landing->id) }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                @method('PUT')

                <!-- Product Dropdown -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Select Product</label>
                    <select name="product_id"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ $landing->product_id == $product->id ? 'selected' : '' }}>
                                {{ \Illuminate\Support\Str::limit($product->name, 100) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Campaign Title -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Campaign Title</label>
                    <input type="text" name="campaign_title"
                        value="{{ old('campaign_title', $landing->campaign_title) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Campaign Description -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Campaign Description</label>
                    <textarea id="campaign_description" name="campaign_description"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                    {{ old('campaign_description', $landing->campaign_description) }}
                </textarea>
                </div>

                <!-- Video URL -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Video URL</label>
                    <input type="text" name="video_url" value="{{ old('video_url', $landing->video_url) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Banner Images -->
                <div class="col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Banner Images</label>
                    @if ($landing->banner_image)
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach (json_decode($landing->banner_image) as $banner)
                                <img src="{{ asset($banner) }}" alt="Banner" class="w-20 h-20 object-cover rounded">
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="banner_image[]" multiple
                        class="w-full rounded-md border px-3 sm:px-4 py-2 text-sm sm:text-base border-gray-300">
                </div>

                <!-- Review Images -->
                <div class="col-span-1">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Review Images</label>
                    @if ($landing->review_image)
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach (json_decode($landing->review_image) as $review)
                                <img src="{{ asset($review) }}" alt="Review" class="w-20 h-20 object-cover rounded">
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="review_image[]" multiple
                        class="w-full rounded-md border px-3 sm:px-4 py-2 text-sm sm:text-base border-gray-300">
                </div>

                <!-- Description Title -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Description Title</label>
                    <input type="text" name="description_title"
                        value="{{ old('description_title', $landing->description_title) }}"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Description</label>
                    <textarea id="description" name="description"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                    {{ old('description', $landing->description) }}
                </textarea>
                </div>

                <!-- Why Buy From Us -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Why Buy From Us</label>
                    <textarea id="why_buy_from_us" name="why_buy_from_us"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                    {{ old('why_buy_from_us', $landing->why_buy_from_us) }}
                </textarea>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="block text-md text-gray-700 mb-1 sm:mb-2 font-medium">Status</label>
                    <select name="status"
                        class="w-full rounded-md bg-white text-gray-900 border px-3 sm:px-4 py-2.5 text-sm sm:text-base outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] border-gray-300">
                        <option value="1" {{ $landing->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $landing->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-span-2 mt-2">
                    <button type="submit"
                        class="w-full rounded-md bg-[{{ $theme->theme_bg }}] text-[{{ $theme->theme_text }}] hover:bg-[{{ $theme->theme_hover }}] py-2.5 text-sm sm:text-base transition-all duration-200 transform">
                        Update Campaign
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

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 200
            });
            $('#campaign_description').summernote({
                height: 200
            });
            $('#why_buy_from_us').summernote({
                height: 200
            });
        });
    </script>
@endpush
