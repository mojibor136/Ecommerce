<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function mainIndex()
    {
        $theme = Theme::first();

        return view('backend.themes.main', compact('theme'));
    }

    public function mainUpdate(Request $request)
    {
        $request->validate([
            'theme_bg' => 'required|string',
            'theme_hover' => 'required|string',
            'theme_text' => 'required|string',
        ]);

        try {
            Theme::updateOrCreate(
                ['id' => 1],
                [
                    'theme_bg' => $request->theme_bg,
                    'theme_hover' => $request->theme_hover,
                    'theme_text' => $request->theme_text,
                ]
            );

            return back()->with('success', 'Theme updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! '.$e->getMessage());
        }
    }

    public function navbarIndex()
    {
        $theme = Theme::first();

        return view('backend.themes.navbar', compact('theme'));
    }

    public function navbarUpdate(Request $request)
    {
        $request->validate([
            'nav_bg' => 'required|string',
            'nav_text' => 'required|string',
        ]);

        try {
            Theme::updateOrCreate(
                ['id' => 1],
                [
                    'nav_bg' => $request->nav_bg,
                    'nav_text' => $request->nav_text,
                ]
            );

            return back()->with('success', 'Navbar theme updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! '.$e->getMessage());
        }
    }
}
