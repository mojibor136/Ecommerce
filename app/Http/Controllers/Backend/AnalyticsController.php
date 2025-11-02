<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AnalyticsPixel()
    {
        $pixel = AnalyticsTracking::where('type', 'pixel')->first();

        return view('backend.analytics.pixel', compact('pixel'));
    }

    public function AnalyticsGTM()
    {
        $gtm = AnalyticsTracking::where('type', 'gtm')->first();

        return view('backend.analytics.gtml', compact('gtm'));
    }

    public function AnalyticsGTMStore(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
        ]);

        $status = $request->has('status') ? 1 : 0;

        $gtm = AnalyticsTracking::updateOrCreate(
            ['type' => 'gtm'],
            ['key' => $request->key, 'status' => $status]
        );

        Log::info('GTM Updated:', $gtm->toArray());

        return redirect()->back()->with('success', 'GTM setup updated successfully!');
    }

    /**
     * Store or update Pixel setup.
     */
    public function AnalyticsPixelStore(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
        ]);

        $status = $request->has('status') ? 1 : 0;

        $pixel = AnalyticsTracking::updateOrCreate(
            ['type' => 'pixel'],
            ['key' => $request->key, 'status' => $status]
        );

        Log::info('Pixel Updated:', $pixel->toArray());

        return redirect()->back()->with('success', 'Pixel setup updated successfully!');
    }
}
