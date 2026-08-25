<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a user's profile with their reviews and listings
     */
    public function show(User $user)
    {
        abort_unless(
            $user->profile_visibility !== 'private'
                || auth()->id() === $user->id
                || auth()->user()?->isAdmin(),
            404
        );

        // Get user's reviews received (for buyer/seller ratings)
        $reviewsReceived = $user->reviewsReceived()
            ->latest()
            ->paginate(10);

        // Get average rating and review count
        $avgRating = $user->getAverageRating();
        $totalReviews = $user->getTotalReviews();

        // Show only currently available listings on a public profile.
        $listingsCount = $user->isSeller()
            ? $user->listings()->where('status', 'available')->count()
            : 0;

        // Count completed transactions using the correct side of the relationship.
        $successfulTransactions = $user->isSeller()
            ? \App\Models\Offer::whereHas('listing', fn ($query) => $query->where('user_id', $user->id))
                ->where('status', 'completed')
                ->count()
            : $user->offers()->where('status', 'completed')->count();

        return view('users.show', compact(
            'user',
            'reviewsReceived',
            'avgRating',
            'totalReviews',
            'listingsCount',
            'successfulTransactions'
        ));
    }

    /**
     * Get user's reviews via API (for dynamic filtering)
     */
    public function getReviews(User $user, Request $request)
    {
        $reviews = $user->reviewsReceived()
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}
