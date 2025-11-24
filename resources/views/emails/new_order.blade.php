<!DOCTYPE html>
<html>

<head>
    <title>New Order Received</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#F85501; color:white; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:24px;">New Order Received</h1>
                        </td>
                    </tr>

                    <!-- Customer & Order Info -->
                    <tr>
                        <td style="padding:20px; color:#333;">

                            <p style="font-size:16px; margin:0 0 10px;">
                                A new order has been placed.
                            </p>

                            <p style="font-size:16px; margin:10px 0;">
                                <strong>Invoice ID:</strong> {{ $order->invoice_id }}
                            </p>

                            <p style="font-size:16px; margin:10px 0;">
                                <strong>Delivery Charge::</strong> ৳{{ $order->shipping_charge }}
                            </p>

                            <p style="font-size:16px; margin:10px 0;">
                                <strong>Total:</strong> ৳{{ $order->total }}
                            </p>

                            <h3 style="font-size:18px; margin:20px 0 10px; color:#1a8cff;">Customer Info</h3>

                            <p style="font-size:15px; margin:5px 0;">
                                <strong>Name:</strong> {{ $order->shipping->name }}
                            </p>
                            <p style="font-size:15px; margin:5px 0;">
                                <strong>Email:</strong> {{ $order->shipping->email }}
                            </p>
                            <p style="font-size:15px; margin:5px 0;">
                                <strong>Phone:</strong> {{ $order->shipping->phone }}
                            </p>
                            <p style="font-size:15px; margin:5px 0;">
                                <strong>Address:</strong> {{ $order->shipping->address }}, {{ $order->shipping->city }}
                            </p>

                            <!-- Products -->
                            <h3 style="font-size:18px; margin:20px 0 10px; color:#1a8cff;">Products</h3>

                            @foreach ($order->items as $item)
                                <div
                                    style="border:1px solid #ddd; padding:12px; border-radius:8px; margin-bottom:10px;">

                                    <p style="margin:0 0 5px; font-size:15px; font-weight:bold;">
                                        {{ $item->product_name }}
                                    </p>

                                    <p style="margin:0; font-size:14px; color:#555;">
                                        Qty: {{ $item->quantity }}
                                        <br>
                                        Price: ৳{{ $item->price }}
                                        <br>
                                        <strong>Subtotal: ৳{{ $item->quantity * $item->price }}</strong>
                                    </p>

                                    @php
                                        $attributes = json_decode($item->attributes, true);
                                    @endphp

                                    @if ($attributes && is_array($attributes))
                                        <p style="margin:8px 0 0; font-size:13px; color:#333;">
                                            @foreach ($attributes as $key => $value)
                                                <span><strong>{{ $key }}:</strong> {{ $value }}</span>
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            @endforeach

                            <p style="font-size:18px; margin-top:20px; font-weight:bold; text-align:right;">
                                Total: ৳{{ $order->total }}
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #ffffff; border-top:1px solid #eee; text-align:center; padding:15px; color:#666; font-size:14px;">
                            New order notification — Admin Panel
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
