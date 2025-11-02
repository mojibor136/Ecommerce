<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearBuyNow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (! $request->is('checkout*') && $request->hasSession()) {
                $request->session()->forget('buy_now');
            }
        } catch (\Exception $e) {
            \Log::warning('ClearBuyNow Middleware: '.$e->getMessage());
        }

        return $next($request);
    }
}
