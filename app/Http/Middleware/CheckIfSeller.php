<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfSeller
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isSeller()) {
            if (auth()->check() && auth()->user()->isBuyer()) {
                return redirect()->route('buyer.dashboard')->with('error', 'Buyers cannot access the seller portal.');
            }
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('info', 'Redirected to Admin Dashboard.');
            }
            return redirect('/')->with('error', 'Only sellers can access this section');
        }

        return $next($request);
    }
}
