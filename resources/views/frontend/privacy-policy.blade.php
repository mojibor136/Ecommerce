@extends('frontend.layouts.master')
@section('title', 'Privacy Policy')
@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10 border border-gray-100">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 text-center">
                Privacy Policy
            </h1>

            <p class="text-gray-600 mb-4">
                At <strong>{{ $setting->name }}</strong>, your privacy is our top priority. This Privacy Policy
                outlines how we collect, use, and protect your information when you visit our website or make a purchase.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">1. Information We Collect</h2>
            <p class="text-gray-600 mb-4">
                We collect personal information such as your name, email address, phone number, shipping address, and
                payment
                details when you place an order or register an account on our website.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">2. How We Use Your Information</h2>
            <ul class="list-disc list-inside text-gray-600 mb-4 space-y-1">
                <li>To process and deliver your orders efficiently.</li>
                <li>To provide customer support and respond to your inquiries.</li>
                <li>To send updates about your orders, offers, or important notices.</li>
                <li>To improve our services and user experience.</li>
            </ul>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">3. Data Protection</h2>
            <p class="text-gray-600 mb-4">
                We implement strict security measures to safeguard your personal information against unauthorized access,
                alteration, or disclosure. Your payment information is encrypted using industry-standard SSL technology.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">4. Cookies</h2>
            <p class="text-gray-600 mb-4">
                Our website uses cookies to enhance your browsing experience. You can disable cookies from your browser
                settings, but this may affect certain functionalities.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">5. Third-Party Services</h2>
            <p class="text-gray-600 mb-4">
                We may share limited information with trusted third-party providers for order fulfillment, payment
                processing,
                or analytics. These partners are obligated to maintain the confidentiality of your data.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">6. Your Rights</h2>
            <p class="text-gray-600 mb-4">
                You have the right to access, modify, or delete your personal information. If you wish to exercise these
                rights, please contact us via our support page or email.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">7. Changes to This Policy</h2>
            <p class="text-gray-600 mb-4">
                We may update this Privacy Policy from time to time. Any significant changes will be communicated through
                our
                website or email.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">8. Contact Us</h2>
            <p class="text-gray-600">
                If you have any questions about this Privacy Policy or our practices, please contact us at: <br>
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
