<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBuyer
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isBuyer()) {
            if (auth()->check() && auth()->user()->isSeller()) {
                return redirect()->route('seller.dashboard')->with('error', 'Sellers cannot access the buyer portal.');
            }
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('info', 'Redirected to Admin Dashboard.');
            }
            return redirect('/')->with('error', 'Only buyers can access this section');
        }

        return $next($request);
    }
}
