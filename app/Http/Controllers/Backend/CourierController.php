<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    /**
     * Show all courier API forms with saved data.
     */
    public function index()
    {
        $redx = Courier::where('type', 'redx')->first();
        $steadfast = Courier::where('type', 'steadfast')->first();

        return view('backend.courier.index', compact('redx', 'steadfast'));
    }

    /**
     * Store or update courier API settings.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string',
                'api_key' => 'nullable|string',
                'secret_key' => 'nullable|string',
                'url' => 'nullable|url',
                'token' => 'nullable|string',
                'status' => 'nullable',
            ]);

            $status = $request->has('status') ? 1 : 0;

            $courier = Courier::updateOrCreate(
                ['type' => $validated['type']],
                [
                    'api_key' => $validated['api_key'] ?? null,
                    'secret_key' => $validated['secret_key'] ?? null,
                    'url' => $validated['url'] ?? null,
                    'token' => $validated['token'] ?? null,
                    'status' => $status,
                ]
            );

            Log::info('Courier Gateway Updated: ', $courier->toArray());

            return redirect()->back()->with('success', ucfirst($validated['type']).' gateway updated successfully!');
        } catch (\Exception $e) {
            Log::error('Courier Gateway Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
