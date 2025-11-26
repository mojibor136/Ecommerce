<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use Illuminate\Http\Request;

class IpBlockController extends Controller
{
    public function index(Request $request)
    {
        $query = BlockedIp::query();

        if ($search = $request->input('search')) {
            $query->where('ip_address', 'like', "%{$search}%")
                ->orWhere('user_agent', 'like', "%{$search}%");
        }

        $blockedIps = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.ip_block.index', compact('blockedIps'));
    }

    public function destroy($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);
        $blockedIp->delete();

        return redirect()->route('admin.ip_block.index')
            ->with('success', 'Blocked IP removed successfully.');
    }
}
