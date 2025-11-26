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
        if (BlockedIp::where('ip', $ip)->exists()) {
            abort(403, 'আপনার IP ব্লক করা হয়েছে।');
        }

        return $next($request);
    }
}
