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

        $user = auth()->user();

        // Enforce buyer verification rejection:
        // A rejected buyer cannot access the buyer dashboard or portal features until they re-verify in Settings
        if ($user->id_verification_status === 'rejected') {
            return redirect()->route('settings', ['tab' => 'id-verification'])
                ->with('error', 'Your buyer verification was rejected: ' . ($user->id_rejection_reason ?: 'Document or details unreadable.') . '. Please update your ID and location details in Settings to re-verify.');
        }

        return $next($request);
    }
}
