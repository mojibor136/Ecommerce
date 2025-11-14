<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    @php
        $favicon = $setting->favicon;
    @endphp
    @if ($favicon && file_exists(public_path($favicon)))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', 'Poppins', sans-serif;
        }

        body {
            font-family: 'Roboto', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Print Button -->
    <div class="no-print text-center fixed right-8 bottom-8">
        <button onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Print Invoice</button>
    </div>

    <!-- Invoice -->
    <div class="max-w-3xl mx-auto bg-white p-6 my-4">

        <!-- Header -->
        <div class="flex flex-row justify-between mb-6">
            <div class="md:w-1/2">
                <img src="https://www.jafrafashion.com/public/uploads/settings/1752999238-untitled_design__1_-removebg-preview.webp"
                    alt="Logo" class="w-40 mb-4">
                <p class="text-sm"><strong>Payment:</strong> CASH ON DELIVERY</p>
                <p class="text-sm"><strong>From:</strong> {{ $setting->name }}</p>
                <p class="text-sm">{{ $setting->phone }}</p>
                <p class="text-sm">{{ $setting->email }}</p>
                <p class="text-sm">{{ $setting->address }}</p>
            </div>
            <div class="md:w-1/2 mt-6 md:mt-0">
                <!-- Invoice Box -->
                <div class="inline-block text-white font-bold w-full text-right"
                    style="background-color: #4DBC60; transform: skew(34deg); padding: 10px;">
                    <span class="pr-4" style="display: inline-block; transform: skew(-34deg);">
                        Invoice #42897
                    </span>
                </div>
                <div class="mt-4 text-right text-sm">
                    <p><strong>Date:</strong> 07/10/25</p>
                    <p><strong>To:</strong> Md Mojibor Rahaman</p>
                    <p>প্রণয়রাজ শুভ</p>
                    <p>01781939988</p>
                    <p>সিবলী ফার্মেসী, বাহিরসিগন্যাল, চান্দগাঁও, চট্টগ্রাম</p>
                </div>
            </div>
        </div>

        <!-- Product Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Product</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Qty</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Unit Price</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Example product rows -->
                    <tr>
                        <td class="px-4 py-2 font-madium text-gray-800">
                            <div class="flex items-center gap-2">
                                <img src="" alt="" class="h-8 w-8 rounded-full">
                                <div class="flex flex-col">
                                    <span>Product 1 Name</span>
                                    <span>defult</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-gray-800">2</td>
                        <td class="px-4 py-2 text-gray-800">&#2547;10,000</td>
                        <td class="px-4 py-2 font-bold text-gray-800">&#2547;20,000</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-madium text-gray-800">
                            <div class="flex items-center gap-2">
                                <img src="" alt="" class="h-8 w-8 rounded-full">
                                <div class="flex flex-col">
                                    <span>Product 1 Name</span>
                                    <span>defult</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-gray-800">1</td>
                        <td class="px-4 py-2 text-gray-800">&#2547;15,000</td>
                        <td class="px-4 py-2 font-bold text-gray-800">&#2547;15,000</td>
                    </tr>
                    <!-- Subtotal / Shipping / Discount -->
                    <tr class="bg-gray-50 font-bold">
                        <td class="px-4 py-2" colspan="3">Subtotal</td>
                        <td class="px-4 py-2">&#2547;35,000</td>
                    </tr>
                    <tr class="font-bold">
                        <td class="px-4 py-2" colspan="3">Shipping(+)</td>
                        <td class="px-4 py-2">&#2547;150.00</td>
                    </tr>
                    <tr class="font-bold">
                        <td class="px-4 py-2" colspan="3">Discount(-)</td>
                        <td class="px-4 py-2">&#2547;6,240.00</td>
                    </tr>
                    <tr class="bg-[#4DBC60] text-white text-lg font-medium">
                        <td class="px-4 py-2" colspan="3">Grand Total</td>
                        <td class="px-4 py-2">&#2547;28,910.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
