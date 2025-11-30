<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $landing = LandingPage::paginate(10);

        return view('backend.landing.index', compact('landing'));
    }

    public function create()
    {
        return view('backend.landing.create');
    }

    public function store(Request $request)
    {
        // Logic to store landing page data
    }

    public function show($id)
    {
        return view('backend.landing.show', compact('id'));
    }

    public function edit($id)
    {
        return view('backend.landing.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update landing page data
    }

    public function destroy($id)
    {
        // Logic to delete landing page data
    }
}
