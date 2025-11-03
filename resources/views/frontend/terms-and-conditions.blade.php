@extends('frontend.layouts.master')
@section('title', 'Terms & Conditions')
@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10 border border-gray-100">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 text-center">
                Terms & Conditions
            </h1>

            <p class="text-gray-600 mb-4">
                Welcome to <strong>{{ $setting->name }}</strong>. These Terms and Conditions outline the rules and
                regulations for the use of our website and services.
                By accessing or using our site, you agree to comply with these terms. Please read them carefully before
                proceeding.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">1. Acceptance of Terms</h2>
            <p class="text-gray-600 mb-4">
                By visiting our website, creating an account, or making a purchase, you acknowledge that you have read,
                understood, and agree to be bound by these Terms & Conditions.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">2. Use of Our Website</h2>
            <ul class="list-disc list-inside text-gray-600 mb-4 space-y-1">
                <li>You agree to use our website for lawful purposes only.</li>
                <li>You must not attempt to gain unauthorized access to any part of the site or its servers.</li>
                <li>We reserve the right to terminate or restrict access to users who violate these terms.</li>
            </ul>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">3. Product Information</h2>
            <p class="text-gray-600 mb-4">
                We make every effort to display accurate product details, prices, and availability. However, we do not
                guarantee that all information is error-free, and we reserve the right to correct any mistakes or update
                product details at any time without prior notice.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">4. Orders and Payments</h2>
            <p class="text-gray-600 mb-4">
                All orders are subject to acceptance and availability. Payment must be made in full before your order is
                processed. We use secure payment gateways to protect your personal and financial information.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">5. Shipping & Delivery</h2>
            <p class="text-gray-600 mb-4">
                Shipping times may vary depending on your location. We are not responsible for delays caused by external
                courier services or unforeseen circumstances.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">6. Returns & Refunds</h2>
            <p class="text-gray-600 mb-4">
                Please review our Return & Refund Policy before making a purchase. We only accept returns under specific
                conditions and within the time frame mentioned in the policy.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">7. Limitation of Liability</h2>
            <p class="text-gray-600 mb-4">
                {{ $setting->name }} shall not be held responsible for any indirect, incidental, or consequential
                damages arising from the use of our services or products.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">8. Intellectual Property</h2>
            <p class="text-gray-600 mb-4">
                All content, images, logos, and designs displayed on this website are the property of
                {{ $setting->name }}. Unauthorized use or reproduction is strictly prohibited.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">9. Changes to Terms</h2>
            <p class="text-gray-600 mb-4">
                We may update these Terms & Conditions from time to time. Any changes will be reflected on this page, and
                continued use of the website implies your acceptance of the updated terms.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">10. Contact Information</h2>
            <p class="text-gray-600">
                For any questions regarding these Terms & Conditions, please contact us at: <br>
                <span class="font-medium text-gray-800 block mt-2">
                    📧 Email: {{ $setting->email }}
                </span>
                <span class="font-medium text-gray-800 block mt-1">📞 Phone: {{ $setting->phone }}</span>
            </p>

            <p class="text-center text-gray-500 text-sm mt-8 border-t pt-4">
                © {{ date('Y') }} {{ $setting->name }}. All rights reserved.
            </p>
        </div>
    </div>
@endsection
