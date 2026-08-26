<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Offer;
use App\Models\User;
use App\Models\Report;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Auth;

class ReviewController extends Controller
{
    /**
     * Show form to create a review for a completed offer
     */
    public function create(Offer $offer)
    {
        // Only buyer or seller can review
        $user = Auth::user();
        if ($user->id !== $offer->buyer_id && $user->id !== $offer->listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Reviews are available only after the transaction is completed.
        if ($offer->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed transactions');
        }

        // Check if user already reviewed this offer
        $existingReview = Review::where('offer_id', $offer->id)
            ->where('reviewer_id', $user->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this transaction');
        }

        $isBuyer = $user->id === $offer->buyer_id;
        $reviewee = $isBuyer ? $offer->listing->seller : $offer->buyer;

        return view('reviews.create', compact('offer', 'reviewee', 'isBuyer'));
    }

    /**
     * Store a review
     */
    public function store(Request $request, Offer $offer)
    {
        $user = Auth::user();

        // Authorization
        if ($user->id !== $offer->buyer_id && $user->id !== $offer->listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if ($offer->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed transactions');
        }

        // Validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:100',
            'comment' => 'nullable|string|max:1000',
            'communication' => 'nullable|integer|min:1|max:5',
            'professionalism' => 'nullable|integer|min:1|max:5',
            'cleanliness' => 'nullable|integer|min:1|max:5',
            'accuracy' => 'nullable|integer|min:1|max:5',
            'promptness' => 'nullable|integer|min:1|max:5',
            'honesty' => 'nullable|integer|min:1|max:5',
        ]);

        $isBuyer = $user->id === $offer->buyer_id;
        $reviewee = $isBuyer ? $offer->listing->seller : $offer->buyer;

        // Build attributes array
        $attributes = [];
        foreach (['communication', 'professionalism', 'cleanliness', 'accuracy', 'promptness', 'honesty'] as $attr) {
            if ($request->has($attr) && $request->get($attr)) {
                $attributes[$attr] = (int) $request->get($attr);
            }
        }

        // Create review
        $review = Review::create([
            'reviewer_id' => $user->id,
            'reviewee_id' => $reviewee->id,
            'offer_id' => $offer->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'review_type' => $isBuyer ? 'buyer' : 'seller',
            'is_verified' => true,
        ]);

        if (!empty($attributes)) {
            $review->attributeScores()->createMany(
                collect($attributes)->map(function (int $rating, string $attributeKey): array {
                    return [
                        'attribute' => $attributeKey,
                        'score' => $rating,
                    ];
                })->values()->all()
            );
        }

        // Log review creation
        AuditLogger::log(
            action: 'create_review',
            description: "{$user->name} left a {$request->rating}-star review for {$reviewee->name}",
            modelType: 'Review',
            modelId: $review->id,
            newValues: [
                'rating' => $request->rating,
                'title' => $request->title,
                'review_type' => $isBuyer ? 'buyer' : 'seller',
            ]
        );

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Thank you for your review! Your feedback helps improve our community.');
    }

    /**
     * Display reviews for a user (profile)
     */
    public function userReviews(User $user)
    {
        abort_unless(
            $user->profile_visibility !== 'private'
                || Auth::id() === $user->id
                || Auth::user()?->isAdmin(),
            404
        );

        $reviews = $user->reviewsReceived()
            ->with(['reviewer', 'offer.listing', 'offer.buyer', 'attributeScores'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $averageRating = $user->getAverageRating();
        $totalReviews = $user->getTotalReviews();

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $user->reviewsReceived()->where('rating', $i)->count();
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0,
            ];
        }

        return view('reviews.user-reviews', compact('user', 'reviews', 'averageRating', 'totalReviews', 'ratingDistribution'));
    }

    /**
     * Display a single review
     */
    public function show(Review $review)
    {
        abort_unless(
            $review->reviewee->profile_visibility !== 'private'
                || Auth::id() === $review->reviewee_id
                || Auth::user()?->isAdmin(),
            404
        );

        $review->load(['reviewer', 'reviewee', 'offer.listing', 'attributeScores']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Delete a review (reviewer or admin only)
     */
    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->reviewer_id && !Auth::user()?->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $reviewId = $review->id;
        $review->delete();

        // Log deletion
        AuditLogger::log(
            action: 'delete_review',
            description: "Review #{$reviewId} deleted",
            modelType: 'Review',
            modelId: $reviewId
        );

        return redirect()->back()->with('success', 'Review deleted successfully');
    }

    /**
     * Report a review (inappropriate content)
     */
    public function report(Request $request, Review $review)
    {
        $request->validate([
            'reason' => 'required|string|in:inappropriate_content,scam_fraud,offensive_language,harassment_abuse,spam,false_information,fake_listing,broken_item_misrepresentation,seller_unresponsive,suspicious_behavior,other',
            'description' => 'nullable|string|max:1000',
        ]);

        $alreadyReported = Report::where('user_id', Auth::id())
            ->where('reportable_type', Review::class)
            ->where('reportable_id', $review->id)
            ->where('status', '!=', 'dismissed')
            ->exists();

        if ($alreadyReported) {
            return redirect()->back()->with('warning', 'You have already reported this review');
        }

        Report::create([
            'user_id' => Auth::id(),
            'reportable_type' => Review::class,
            'reportable_id' => $review->id,
            'reason' => $request->reason,
            'description' => $request->description ?: 'Review reported for moderation.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
        ]);

        AuditLogger::log(
            action: 'report_review',
            description: "Review #{$review->id} reported by " . Auth::user()->name . ". Reason: " . $request->reason,
            modelType: 'Review',
            modelId: $review->id
        );

        return redirect()->back()->with('success', 'Thank you for reporting. Our team will review this.');
    }

    /**
     * Get reviews statistics for admin dashboard
     */
    public function getStatistics()
    {
        $totalReviews = Review::count();
        $averageRating = Review::avg('rating');
        $fiveStarCount = Review::where('rating', 5)->count();
        $oneStarCount = Review::where('rating', 1)->count();

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating ?? 0, 2),
            'five_star_percentage' => $totalReviews > 0 ? round(($fiveStarCount / $totalReviews) * 100) : 0,
            'one_star_percentage' => $totalReviews > 0 ? round(($oneStarCount / $totalReviews) * 100) : 0,
        ];
    }
}
