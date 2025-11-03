@extends('frontend.layouts.master')
@section('title', 'Help Center')
@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Help Center</h2>
            <p class="text-gray-600 text-center mb-6">
                Welcome to our Help Center! Find answers to your common questions and learn how to get support.
            </p>

            <!-- Search Bar -->
            <div class="relative mb-8 max-w-md mx-auto">
                <input type="text" placeholder="Search for help..."
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="ri-search-line absolute left-3 top-2.5 text-gray-500"></i>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-4">
                @php
                    $faqs = [
                        [
                            'How can I track my order?',
                            'You can track your order by visiting the “Order Tracking” page and entering your order ID and email.',
                        ],
                        [
                            'How can I contact support?',
                            'You can contact us using the contact form on the “Contact Us” page or email us at ' .
                            $setting->email,
                        ],
                        [
                            'How do I return a product?',
                            'You can request a return within 7 days of delivery by visiting your order details page.',
                        ],
                        [
                            'Do you offer customer support on weekends?',
                            'Yes! Our customer support is available 7 days a week from 9 AM to 9 PM.',
                        ],
                        [
                            'Can I cancel my order after payment?',
                            'Orders can be cancelled within 12 hours of placing the order. After that, it will be processed for shipping.',
                        ],
                        [
                            'How long does delivery take?',
                            'Delivery usually takes 2–5 business days depending on your location.',
                        ],
                        [
                            'What payment methods do you accept?',
                            'We accept Visa, MasterCard, Mobile Banking, and Cash on Delivery.',
                        ],
                        [
                            'Is my personal information secure?',
                            'Yes, we use SSL encryption to ensure your personal data is safe and secure.',
                        ],
                        [
                            'Can I change my delivery address?',
                            'Yes, you can change your address before the order is shipped. Contact our support team immediately.',
                        ],
                        [
                            'Do you ship internationally?',
                            'Currently, we only ship within Bangladesh. International shipping will be available soon.',
                        ],
                        [
                            'How do I apply a discount code?',
                            'At checkout, enter your promo code in the “Discount Code” box and click apply.',
                        ],
                        [
                            'What should I do if I received a damaged product?',
                            'If you receive a damaged product, please contact us within 48 hours with photos for replacement or refund.',
                        ],
                        [
                            'Do you offer gift wrapping?',
                            'Yes! You can select gift wrapping during checkout for a small extra fee.',
                        ],
                        [
                            'Can I change the items in my order?',
                            'Once the order is confirmed, item changes are not possible. You can cancel and place a new order instead.',
                        ],
                        [
                            'What if my order is delayed?',
                            'If your order is delayed, please check your email for updates or contact support with your order ID.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div class="border rounded-lg">
                        <button
                            class="w-full text-left px-4 py-3 font-medium text-gray-800 flex justify-between items-center focus:outline-none"
                            onclick="toggleFaq({{ $index + 1 }})">
                            {{ $faq[0] }}
                            <i class="ri-arrow-down-s-line text-lg" id="icon-{{ $index + 1 }}"></i>
                        </button>
                        <div class="hidden px-4 pb-3 text-gray-600" id="faq-{{ $index + 1 }}">
                            {!! $faq[1] !!}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Contact CTA -->
            <div class="text-center mt-10">
                <p class="text-gray-600 mb-4">Still need help? Our support team is here for you.</p>
                <a href="{{ route('contact') }}"
                    class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Contact Support
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(id) {
            const content = document.getElementById(`faq-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            content.classList.toggle("hidden");
            icon.classList.toggle("ri-arrow-down-s-line");
            icon.classList.toggle("ri-arrow-up-s-line");
        }
    </script>
@endsection
