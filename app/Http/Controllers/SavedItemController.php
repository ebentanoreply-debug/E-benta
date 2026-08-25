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
        $savedListings = Auth::user()
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
