<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color: #584acd; color: #ffffff; text-align: center; padding: 20px;">
                            <h1 style="margin: 0; font-size: 24px;">Order Confirmation</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; color: #333333;">
                            <p style="font-size: 16px; margin: 0 0 10px;">Hello
                                <strong>{{ $order->shipping->name }}</strong>,
                            </p>
                            <p style="font-size: 16px; margin: 0 0 10px;">Thank you for your order! Here are the
                                details:</p>

                            <p style="font-size: 16px; margin: 10px 0;"><strong>Invoice ID:</strong>
                                {{ $order->invoice_id }}</p>
                            <p style="font-size: 16px; margin: 10px 0;"><strong>Delivery Charge:</strong>
                                {{ $order->shipping_charge }}</p>
                            <p style="font-size: 16px; margin: 10px 0;"><strong>Total:</strong> ৳{{ $order->total }}</p>

                            <h3 style="font-size: 18px; color: #584acd; margin: 20px 0 10px;">Products:</h3>

                            @foreach ($order->items as $item)
                                <div
                                    style="padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 10px;">
                                    <p style="margin: 0 0 5px; font-size: 15px; font-weight: bold;">
                                        {{ $item->product_name }}
                                    </p>
                                    @php
                                        $attributes = json_decode($item->attributes, true);
                                    @endphp
                                    @if ($attributes && is_array($attributes))
                                        <p style="margin: 0 0 5px; font-size: 14px; color: #555;">
                                            @foreach ($attributes as $key => $value)
                                                <span style="margin-right:5px;"><strong>{{ $key }}:</strong>
                                                    {{ $value }}</span>
                                            @endforeach
                                        </p>
                                    @endif
                                    <p style="margin: 0; font-size: 14px;">
                                        Qty: {{ $item->quantity }} | Subtotal: ৳{{ $item->quantity * $item->price }}
                                    </p>
                                </div>
                            @endforeach

                            <p style="font-size: 16px; margin-top: 20px; font-weight: bold; text-align: right;">
                                Total: ৳{{ $order->total }}
                            </p>

                            <h3 style="font-size: 18px; color: #584acd; margin: 20px 0 10px;">Shipping Address:</h3>
                            <p style="font-size: 16px; margin: 0;">{{ $order->shipping->address }},
                                {{ $order->shipping->city }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 14px; color: #666666;">
                            &copy; {{ date('Y') }} {{ $setting->name }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
