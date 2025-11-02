<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    /**
     * Display the payment gateway page.
     */
    public function index()
    {
        $bkash = PaymentGateway::where('type', 'bkash')->first();
        $nagad = PaymentGateway::where('type', 'nagad')->first();

        return view('backend.payment.index', compact('bkash', 'nagad'));
    }

    /**
     * Store or Update payment gateway.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'type' => 'required|string',
            'number' => 'nullable|string',
            'app_key' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'base_url' => 'nullable|string',
            'option' => 'nullable|string',
        ]);

        try {
            $gateway = PaymentGateway::updateOrCreate(
                ['type' => $validated['type']],
                [
                    'number' => $validated['number'] ?? null,
                    'app_key' => $validated['app_key'] ?? null,
                    'app_secret' => $validated['app_secret'] ?? null,
                    'username' => $validated['username'] ?? null,
                    'password' => $validated['password'] ?? null,
                    'base_url' => $validated['base_url'] ?? null,
                    'option' => $validated['option'] ?? 'manual',
                    'status' => $request->has('status') ? 1 : 0,
                ]
            );

            return back()->with('success', ucfirst($gateway->type).' Gateway saved successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('PaymentGateway store error: '.$e->getMessage());

            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
