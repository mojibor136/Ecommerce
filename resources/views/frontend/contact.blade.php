@extends('frontend.layouts.master')
@section('title', 'Contact Us')
@section('content')
    <div class="bg-gray-50 md:py-10 py-4 px-4">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Contact Us</h2>

            <!-- Contact Form -->
            <form id="contactForm" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] focus:border-[{{ $theme->theme_bg }}]">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] focus:border-[{{ $theme->theme_bg }}]">
                </div>

                <div>
                    <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter your subject"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] focus:border-[{{ $theme->theme_bg }}]">
                </div>

                <div>
                    <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                    <textarea id="message" name="message" rows="4" placeholder="Write your message here"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[{{ $theme->theme_bg }}] focus:border-[{{ $theme->theme_bg }}]"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-[{{ $theme->theme_bg }}] hover:bg-[{{ $theme->theme_hover }}] text-[{{ $theme->theme_text }}] font-semibold py-2.5 rounded-md transition duration-200">
                    Send Message
                </button>
            </form>

            <!-- Contact Info -->
            <div id="contactInfo" class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Our Contact Information</h3>
                <p class="mb-2"><i
                        class="ri-map-pin-line text-[{{ $theme->theme_bg }}] mr-2"></i>{{ $setting->address }}
                </p>
                <p class="mb-2"><i class="ri-phone-line text-[{{ $theme->theme_bg }}] mr-2"></i>+{{ $setting->phone }}
                </p>
                <p class="mb-2"><i class="ri-mail-line text-[{{ $theme->theme_bg }}] mr-2"></i>{{ $setting->email }}</p>
                <p class="mb-2"><i class="ri-time-line text-[{{ $theme->theme_bg }}] mr-2"></i>Open:
                    {{ $setting->open_time }}</p>
            </div>
        </div>
    </div>

    <script>
        const contactForm = document.getElementById('contactForm');

        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            if (!name || !email || !subject || !message) {
                alert('Please fill in all fields before sending.');
                return;
            }

            // Example: Just showing alert (later you can connect with backend)
            alert('✅ Thank you, ' + name + '! Your message has been sent successfully.');

            // Clear form
            contactForm.reset();
        });
    </script>
@endsection
