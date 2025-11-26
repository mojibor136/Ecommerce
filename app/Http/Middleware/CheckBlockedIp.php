<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use Closure;
use Illuminate\Http\Request;

class CheckBlockedIp
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        if (BlockedIp::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->exists()) {
            abort(403, 'আপনার IP বা ডিভাইস ব্লক করা হয়েছে।');
        }

        return $next($request);
    }
}
