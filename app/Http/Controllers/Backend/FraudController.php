<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class FraudController extends Controller
{
    public function index(Request $request)
    {
        // Validate
        $request->validate([
            'ids' => 'required',
        ]);

        try {

            // RAW IDS
            $rawIds = $request->ids;
            $decodedIds = [];

            // If ids is array (multiple)
            if (is_array($rawIds)) {
                foreach ($rawIds as $value) {
                    $json = json_decode($value, true);

                    if (is_array($json)) {
                        $decodedIds = array_merge($decodedIds, $json);
                    } else {
                        $decodedIds[] = $value;
                    }
                }
            } else {
                // Single ID
                $json = json_decode($rawIds, true);

                if (is_array($json)) {
                    $decodedIds = $json;
                } else {
                    $decodedIds = [$rawIds];
                }
            }

            // Remove duplicates
            $decodedIds = array_unique($decodedIds);

            // Allow ONLY 1 order
            if (count($decodedIds) > 1) {
                return back()->with('error', 'Fraud Checker only supports single parcel creation. Please select one order at a time.');
            }

            // Extract the only ID
            $orderId = $decodedIds[0];

            if ($orderId <= 0) {
                return back()->with('error', 'Invalid order selected for Fraud Checker.');
            }

            // Find Order
            $order = Order::with('shipping')->find($orderId);

            if (! $order) {
                return back()->with('error', 'Order not found.');
            }

            // Phone number
            $phone = $order->shipping->phone;

            // API KEY
            $apiKey = Setting::first()->fraud_api;

            // cURL
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://bdcourier.com/api/courier-check',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query(['phone' => $phone]),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $apiKey",
                    'Content-Type: application/x-www-form-urlencoded',
                ],
            ]);

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                return back()->with('error', "cURL Error: $error");
            }

            // Decode API response
            $decodedResponse = json_decode($response, true);
            $decodedResponse['phone'] = $phone;

            // Return Success
            return back()->with('response', $decodedResponse);

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fraud_api' => 'nullable|string',
            ]);

            $setting = Setting::first();
            $setting->fraud_api = $validated['fraud_api'] ?? null;
            $setting->save();

            return redirect()->back()->with('success', 'Fraud API updated successfully!');
        } catch (\Exception $e) {
            Log::error('Fraud API Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
