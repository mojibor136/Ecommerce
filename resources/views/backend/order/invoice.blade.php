<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice-box {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        @media print {
            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always !important;
            }
        }
    </style>
</head>

@php
    $logo = $setting->icon;
@endphp

<body class="bg-gray-100 text-gray-800">

    <div class="no-print text-center fixed right-8 bottom-8">
        <button onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Print Invoice</button>
    </div>

    @php
        $count = 0;
    @endphp

    @foreach ($orders as $order)
        @php $count++; @endphp

        <div class="max-w-3xl mx-auto bg-white p-6 my-6 invoice-box">

            <div class="flex flex-row justify-between mb-6">
                <div class="w-1/2">
                    <img src="{{ asset($logo) }}" alt="Logo" class="w-32 mb-4">

                    <p class="text-sm"><strong>Payment:</strong>
                        {{ $order->payment->payment_method ?? 'Cash on Delivery' }}</p>
                    <p class="text-sm"><strong>From:</strong> {{ $setting->name }}</p>
                    <p class="text-sm">{{ $setting->phone }}</p>
                    <p class="text-sm">{{ $setting->email }}</p>
                    <p class="text-sm">{{ $setting->address }}</p>
                </div>

                <div class="w-1/2 text-right">
                    <div class="inline-block text-white font-bold w-full text-right"
                        style="background-color: #4DBC60; transform: skew(32deg); padding: 10px;">
                        <span style="display: inline-block; transform: skew(-32deg);">
                            Invoice #{{ $order->id }}
                        </span>
                    </div>

                    <div class="mt-4 text-sm">
                        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                        <p><strong>Name:</strong> {{ $order->shipping->name }}</p>
                        <p>{{ $order->shipping->phone }}</p>
                        <p>{{ $order->shipping->address }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Product</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Qty</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Price</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 whitespace-nowrap">Total Amt.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-800">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $item->product_image }}" class="h-12 w-12 rounded-full">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm text-gray-700 line-clamp-1 mb-0.5">{{ $item->product->name }}</span>
                                            <span class="text-sm text-gray-700">
                                                @php
                                                    $json = str_replace('\"', '"', $item->attributes);
                                                    $attributes = json_decode($json, true);
                                                @endphp

                                                @if ($attributes && is_array($attributes))
                                                    @foreach ($attributes as $key => $value)
                                                        <span class="mr-2"><strong
                                                                class="font-normal">{{ $key }}:</strong>
                                                            {{ $value }}</span>
                                                    @endforeach
                                                @else
                                                    Default
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2">{{ $item->quantity }}</td>
                                <td class="px-4 py-2">৳{{ $item->price }}</td>
                                <td class="px-4 py-2 font-medium">
                                    ৳{{ number_format($item->price * $item->quantity, 0) }}.00
                                </td>
                            </tr>
                        @endforeach

                        <tr class="bg-gray-50 font-medium">
                            <td class="px-4 py-2" colspan="3">Subtotal</td>
                            <td class="px-4 py-2">৳{{ $order->total }},00</td>
                        </tr>
                        <tr class="font-medium">
                            <td class="px-4 py-2" colspan="3">Shipping(+)</td>
                            <td class="px-4 py-2">৳{{ $order->shipping_charge }},00</td>
                        </tr>
                        @if ($order->discount > 0)
                            <tr class="font-medium">
                                <td class="px-4 py-2" colspan="3">Discount(-)</td>
                                <td class="px-4 py-2">৳{{ $order->discount }},00</td>
                            </tr>
                        @endif

                        <tr class="bg-[#4DBC60] text-white text-lg font-medium">
                            <td class="px-4 py-2" colspan="3">Grand Total</td>
                            <td class="px-4 py-2">৳{{ $order->total }},00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if ($count % 2 == 0)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
