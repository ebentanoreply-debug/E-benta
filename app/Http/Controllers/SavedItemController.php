<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedItemController extends Controller
{
    /**
     * Display saved items for the authenticated buyer.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->isIdVerified()) {
            if ($user->id_verification_status === 'rejected') {
                return redirect()->route('settings', ['tab' => 'id-verification'])
                    ->with('error', 'Your buyer verification was rejected: ' . ($user->id_rejection_reason ?: 'Document or details unreadable.') . '. Please update your ID and location details in Settings to re-verify.');
            }
            if ($user->isIdPending()) {
                return redirect()->route('buyer.dashboard')
                    ->with('warning', 'Your ID verification is currently pending admin review.');
            }
            return redirect()->route('settings', ['tab' => 'id-verification'])
                ->with('warning', 'Please submit your valid ID and location verification in Settings to access your saved items.');
        }

        $savedListings = $user
            ->savedListings()
            ->with(['seller', 'deviceType'])
            ->where('listings.status', 'available')
            ->orderByDesc('saved_items.created_at')
            ->paginate(12);

        return view('buyer.saved-items', compact('savedListings'));
    }

    /**
     * Save a listing for the authenticated buyer.
     */
    public function store(Listing $listing)
    {
        if (!$listing->isAvailable()) {
            return back()->with('error', 'Only available listings can be saved.');
        }

        Auth::user()->savedListings()->syncWithoutDetaching([$listing->id]);

        return back()->with('success', 'Listing added to saved items.');
    }

    /**
     * Remove a listing from the authenticated buyer's saved items.
     */
    public function destroy(Listing $listing)
    {
        Auth::user()->savedListings()->detach($listing->id);

        return back()->with('success', 'Listing removed from saved items.');
    }
}
