<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bkash Payment</title>
    @php
        $favicon = $setting->favicon;
    @endphp
    @if ($favicon && file_exists(public_path($favicon)))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-[#FFF6F5] min-h-screen flex flex-col items-center justify-start md:py-4 py-2">

    <form action="{{ route('payment.success') }}" method="POST" class="md:max-w-xl w-full mx-auto md:px-4 px-2">
        @csrf
        <div class="bg-white md:px-6 px-3 py-6 rounded shadow-lg border-t-4 border-[#E2136E]">
            <input type="hidden" value="bkash" name="payment_method">
            <input type="hidden" value="{{ $order }}" name="order_id">
            <!-- Header Icons -->
            <div class="flex items-center justify-between w-full px-3 py-2 mb-4 border border-gray-200 rounded">
                <i class="ri-home-4-line text-lg text-gray-600 cursor-pointer hover:text-[#E2136E] transition"></i>
                <i
                    class="ri-arrow-left-circle-line text-lg text-gray-600 cursor-pointer hover:text-[#E2136E] transition"></i>
            </div>

            <!-- Merchant Info -->
            <div
                class="bg-white w-full text-center px-3 py-3 mb-8 border border-gray-200 rounded flex justify-between items-center shadow-sm">
                <div class="flex gap-2 items-center">
                    <img src="{{ asset($setting->favicon) }}" alt="Profile"
                        class="md:w-14 md:h-14 h-12 w-12 rounded-full border-2 border-[#222] object-cover">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-gray-800 text-base font-semibold block text-start">{{ $setting->name }}</span>
                        <span class="text-gray-700 text-sm">Invoice ID : FASDFF22</span>
                    </div>
                </div>
                <img src="https://www.logo.wine/a/logo/BKash/BKash-bKash-Logo.wine.svg" alt="Bkash Logo"
                    class="md:h-16 h-14">
            </div>

            <!-- Payment Instruction -->
            <div class="bg-[#E2136E] md:px-6 md:py-6 p-3 rounded-md text-white">
                <div class="p-4 rounded border border-white/20 bg-white/10 backdrop-blur-md shadow">

                    <!-- Sender Number -->
                    <div class="w-full max-w-md flex flex-col justify-start items-start gap-1 mb-4">
                        <label for="sender_number" class="block w-full text-sm font-semibold mb-1 text-left text-white">
                            যে নম্বর থেকে পেমেন্ট করেছেন তা লিখুন
                        </label>
                        <input type="tel" id="sender_number" name="sender_number" placeholder="যেমনঃ 01XXXXXXXXX"
                            pattern="[0-9]{11}" maxlength="11" minlength="11"
                            title="ঠিক ১১ সংখ্যার নগদ নাম্বার দিন (যেমনঃ 01XXXXXXXXX)" required
                            class="w-full text-gray-800 text-md rounded border border-white/30 bg-white/20 backdrop-blur-sm 
px-4 py-2 shadow-sm focus:outline-none focus:ring-0 focus:border-[#222] focus:ring-[#222] focus:ring-offset-1 focus:ring-offset-transparent placeholder-gray-300 transition" />
                    </div>

                    <!-- Transaction ID -->
                    <div class="w-full max-w-md flex flex-col justify-start items-start gap-1 mb-1">
                        <label for="transaction_id"
                            class="block w-full text-sm font-semibold mb-1 text-left text-white">
                            আপনার Bkash Transaction ID লিখুন
                        </label>
                        <input type="text" id="transaction_id" name="transaction_id"
                            placeholder="ঠিক ১০ অক্ষরের Transaction ID দিন" maxlength="10" minlength="10"
                            title="ঠিক ১০ অক্ষরের Transaction ID দিন" required
                            class="w-full text-gray-800 text-md rounded border border-white/30 bg-white/20 backdrop-blur-sm 
px-4 py-2 shadow-sm focus:outline-none focus:ring-0 focus:border-[#222] focus:ring-[#222] focus:ring-offset-1 focus:ring-offset-transparent placeholder-gray-300 transition" />
                    </div>
                </div>

                <!-- Instructions -->
                <div class="w-full mb-6">
                    <ol class="list-decimal list-outside pl-5 text-white text-sm text-left space-y-1">
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            *247# ডায়াল করুন অথবা আপনার <span class="font-semibold text-[#222]">Bkash App</span> ওপেন
                            করুন।
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            <span class="font-semibold text-[#222]">"Send Money"</span> অপশনটি সিলেক্ট করুন।
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            প্রাপক নম্বর দিন:
                            <span id="copyNumber"
                                class="font-medium text-[#222] select-all cursor-pointer">017XXXXXXXX</span>
                            <button type="button" onclick="copyToClipboard()"
                                class="ml-2 text-[#222] hover:text-white transition" aria-label="Copy number"
                                title="Copy number">
                                <i class="ri-file-copy-line text-lg"></i>
                            </button>
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            পরিমাণ লিখুন: <span class="font-medium text-[#222]">{{ $amount }}.00</span> টাকা।
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            রেফারেন্সে লিখুন: <span class="font-medium text-[#222]">Invoice ID বা আপনার নাম</span>।
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            পিন দিয়ে ট্রানজেকশন সম্পন্ন করুন।
                        </li>
                        <li class="border-b border-[#222]/40 p-3 leading-relaxed">
                            সফল ট্রানজেকশন শেষে পাওয়া Transaction ID টি উপরের ঘরে লিখে <span
                                class="font-semibold text-[#222]">"VERIFY"</span> বাটনে ক্লিক করুন।
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Verify Button -->
            <button
                class="w-full bg-[#E2136E] hover:bg-[#E2138E] text-white font-semibold py-3 rounded-md mt-5 transition">
                VERIFY
            </button>

        </div>
    </form>

    <!-- Copy Popup -->
    <div id="copyPopup"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
        bg-black bg-opacity-80 text-white text-sm px-4 py-2 rounded shadow-lg hidden z-50">
        নম্বর কপি হয়েছে!
    </div>

    <script>
        function copyToClipboard() {
            const number = document.getElementById('copyNumber').innerText;
            navigator.clipboard.writeText(number).then(() => {
                showCopyPopup('Bkash নম্বর কপি হয়েছে: ' + number);
            }).catch(() => {
                showCopyPopup('কপি করা সম্ভব হয়নি!');
            });
        }

        function showCopyPopup(message) {
            const popup = document.getElementById('copyPopup');
            popup.innerText = message;
            popup.classList.remove('hidden');
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 2000);
        }
    </script>

</body>

</html>
