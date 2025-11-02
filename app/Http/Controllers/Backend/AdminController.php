<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }

    public function account()
    {
        $admin = auth()->user();

        return view('backend.setting.account.index', compact('admin'));
    }

    public function accountStore(Request $request)
    {
        $admin = auth()->user();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$admin->id,
                'password' => 'nullable|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->filled('password')) {
                $admin->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                if ($admin->image && File::exists(public_path($admin->image))) {
                    File::delete(public_path($admin->image));
                }

                $imageName = time().'_'.$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads/admin'), $imageName);
                $admin->image = 'uploads/admin/'.$imageName;
            }

            $admin->save();

            return redirect()->back()->with('success', 'Account updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update account: '.$e->getMessage());
        }
    }
}
