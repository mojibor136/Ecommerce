<!DOCTYPE html>
<html>

<head>
    <title>Order Cancelled</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #d9534f; color: #ffffff; text-align: center; padding: 20px;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: normal;">Order Cancelled</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px; color: #333333; font-weight: normal;">

                            <p style="font-size: 16px; margin: 0 0 10px;">
                                Hello {{ $order->shipping->name }},
                            </p>

                            <p style="font-size: 16px; margin: 0 0 10px;">
                                Your order has been <strong style="font-weight: normal;">cancelled</strong>.
                            </p>

                            <p style="font-size: 16px; margin: 10px 0;">
                                Invoice ID: {{ $order->invoice_id }}
                            </p>

                            <h3 style="font-size: 18px; color: #d9534f; margin: 20px 0 10px; font-weight: normal;">
                                Cancelled Order Summary:
                            </h3>

                            @foreach ($order->items as $item)
                                <div
                                    style="padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 10px; font-weight: normal;">

                                    <p style="margin: 0 0 5px; font-size: 15px; font-weight: normal;">
                                        {{ $item->product_name }}
                                    </p>

                                    @php
                                        $attributes = json_decode($item->attributes, true);
                                    @endphp

                                    @if ($attributes && is_array($attributes))
                                        <p style="margin: 0 0 5px; font-size: 14px; color: #555; font-weight: normal;">
                                            @foreach ($attributes as $key => $value)
                                                <span style="margin-right:5px;">{{ $key }}:
                                                    {{ $value }}</span>
                                            @endforeach
                                        </p>
                                    @endif

                                    <p style="margin: 0; font-size: 14px; font-weight: normal;">
                                        Qty: {{ $item->quantity }} | Subtotal: ৳{{ $item->quantity * $item->price }}
                                    </p>

                                </div>
                            @endforeach

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #ffffff; border-top:1px solid #eee; text-align: center; padding: 15px; font-size: 14px; color: #666; font-weight: normal;">
                            &copy; {{ date('Y') }} {{ $setting->name }}. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
