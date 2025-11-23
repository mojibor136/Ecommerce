<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SystemSettingController extends Controller
{
    /**
     * Shipping Charge Page
     */
    public function shippingIndex()
    {
        try {
            $setting = Setting::first();
            $shipping = $setting->shipping_charge ?? ['in_dhaka' => 0, 'out_dhaka' => 0];

            return view('backend.setting.shipping.index', compact('shipping'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    /**
     * Shipping Store / Update
     */
    public function shippingStore(Request $request)
    {
        try {
            $request->validate([
                'in_dhaka' => 'required|numeric|min:0',
                'out_dhaka' => 'required|numeric|min:0',
            ]);

            $setting = Setting::first() ?? new Setting;

            $setting->shipping_charge = [
                'in_dhaka' => $request->in_dhaka,
                'out_dhaka' => $request->out_dhaka,
            ];

            $setting->save();

            return redirect()->back()->with('success', 'Shipping charge updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update shipping charge: '.$e->getMessage());
        }
    }

    /**
     * General Setting Page
     */
    public function setting()
    {
        try {
            $setting = Setting::first();

            return view('backend.setting.setting', compact('setting'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load settings: '.$e->getMessage());
        }
    }

    /**
     * Store / Update General Settings
     */
    public function settingStore(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_tag' => 'nullable|string',
                'meta_desc' => 'nullable|string',
                'footer' => 'nullable|string',
                'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico|max:2048',
                'favicon' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico|max:2048',
            ]);

            $setting = Setting::first() ?? new Setting;

            $setting->name = $request->name;
            $setting->headline = $request->headline;
            $setting->open_time = $request->open_time;
            $setting->address = $request->address;
            $setting->facebook = $request->facebook;
            $setting->whatsapp = $request->whatsapp;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->brand = $request->brand;
            $setting->meta_title = $request->meta_title;
            $setting->meta_tag = json_encode(explode(',', $request->meta_tag));
            $setting->meta_desc = $request->meta_desc;
            $setting->footer = $request->footer;
            $setting->hot_deals = $request->hot_deals;

            if ($request->hasFile('icon')) {
                if ($setting->icon && File::exists(public_path($setting->icon))) {
                    File::delete(public_path($setting->icon));
                }

                $file = $request->file('icon');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $fileName);
                $setting->icon = 'uploads/settings/'.$fileName;
            }

            if ($request->hasFile('favicon')) {
                if ($setting->favicon && File::exists(public_path($setting->favicon))) {
                    File::delete(public_path($setting->favicon));
                }

                $file = $request->file('favicon');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $fileName);
                $setting->favicon = 'uploads/settings/'.$fileName;
            }

            $setting->save();

            return redirect()->back()->with('success', 'Settings saved successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }
}
