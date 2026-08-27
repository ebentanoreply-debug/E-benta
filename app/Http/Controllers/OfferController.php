<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\Message;
use App\Models\User;
use App\Models\ImpactLog;
use App\Models\Notification;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Show buyer dashboard with available listings.
     */
    public function buyerDashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user->isBuyer()) {
            return redirect('/')->with('error', 'Only buyers can access this');
        }

        // Check if buyer is verified
        if (!$user->is_verified) {
            // Get buyer's offers even if not verified
            $offers = Offer::where('buyer_id', $user->id)
                ->with(['listing', 'listing.seller'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('buyer.pending-verification', compact('offers'));
        }

        // Get available listings
        $query = Listing::where('status', 'available');

        if ($request->has('category') && $request->category) {
            $query->whereHas('deviceType', function ($deviceTypeQuery) use ($request) {
                $deviceTypeQuery->where('name', $request->category);
            });
        }

        $listings = $query->with(['seller', 'offers', 'deviceType', 'listingPhotos'])->paginate(15);

        // Get buyer's submitted offers
        $offers = Offer::where('buyer_id', $user->id)
            ->with(['listing', 'listing.seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('buyer.dashboard', [
            'availableListings' => $listings,
            'offers' => $offers
        ]);
    }

    /**
     * Show form to submit an offer.
     */
    public function create(Listing $listing)
    {
        // Check if listing is available
        if (!$listing->isAvailable()) {
            return redirect('/')->with('error', 'This listing is no longer available');
        }

        return view('offers.create', compact('listing'));
    }

    /**
     * Store a new offer.
     */
    public function store(Request $request, Listing $listing)
    {
        $user = Auth::user();

        // Only buyers can submit offers
        if (!$user->isBuyer()) {
            return redirect('/')->with('error', 'Only registered buyers can submit offers');
        }

        // Buyer must be verified
        if (!$user->is_verified) {
            return redirect('/')->with('error', 'Your account must be verified before submitting offers');
        }

        // Check listing is available
        if (!$listing->isAvailable()) {
            return redirect('/')->with('error', 'This listing is no longer available');
        }

        $request->validate([
            'bid_amount' => 'required|numeric|min:0.01',
            'proposed_method' => 'required|in:repair,harvest,refine,dispose',
            'handover_method' => 'nullable|in:pickup,meetup',
            'proposed_pickup_date' => 'required|date|after:today',
            'pickup_location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if buyer already submitted offer for this listing
        $existingOffer = Offer::where('listing_id', $listing->id)
            ->where('buyer_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingOffer) {
            return redirect()->back()
                ->with('error', 'You have already submitted a pending offer for this item');
        }

        $handoverMethod = $request->input('handover_method');
        if (!$handoverMethod) {
            $handoverMethod = $listing->handover_preference === 'meetup_only' ? 'meetup' : 'pickup';
        }

        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $user->id,
            'bid_amount' => $request->bid_amount,
            'proposed_method' => $request->proposed_method,
            'handover_method' => $handoverMethod,
            'proposed_pickup_date' => $request->proposed_pickup_date,
            'pickup_location' => $request->pickup_location,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Log offer creation
        AuditLogger::logCreate(
            'Offer',
            $offer->id,
            "Buyer {$user->name} created new offer for listing #{$listing->id}: ₱" . number_format($request->bid_amount, 2),
            [
                'listing_id' => $listing->id,
                'buyer_id' => $user->id,
                'bid_amount' => $request->bid_amount,
                'proposed_method' => $request->proposed_method,
            ]
        );

        // Notify seller about new offer
        $categoryName = $listing->category ?: ($listing->deviceType->name ?: 'item');
        Notification::notify(
            $listing->seller,
            'offer_received',
            'New Offer Received! 💰',
            "{$user->name} submitted an offer of ₱" . number_format($request->bid_amount, 2) . " for your {$categoryName}",
            [
                'listing_id' => $listing->id,
                'offer_id' => $offer->id,
                'buyer_name' => $user->name,
                'bid_amount' => $request->bid_amount,
            ]
        );

        return redirect()->route('buyer.dashboard')
            ->with('success', 'Offer submitted successfully! Waiting for seller response.');
    }

    /**
     * Show a specific offer.
     */
    public function show(Offer $offer)
    {
        // Only seller, buyer, or admin can view
        if (
            Auth::id() !== $offer->buyer_id &&
            Auth::id() !== $offer->listing->user_id &&
            !Auth::user()?->isAdmin()
        ) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $offer->load(['listing', 'buyer', 'listing.seller']);

        return view('offers.show', compact('offer'));
    }

    /**
     * Accept an offer (seller action).
     */
    public function accept(Offer $offer)
    {
        // Only seller can accept
        if (Auth::id() !== $offer->listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Listing must be active and not withdrawn
        if ($offer->listing->status === 'withdrawn') {
            return redirect()->back()
                ->with('error', 'This listing has been withdrawn and offers can no longer be accepted.');
        }

        if (!$offer->listing->isAvailable()) {
            return redirect()->back()
                ->with('error', 'This listing is no longer available for offers.');
        }

        // Offer must be pending
        if (!$offer->isPending()) {
            return redirect()->back()
                ->with('error', 'This offer is no longer pending');
        }

        try {
            if ($offer->accept()) {
                // Update listing status to matched
                $offer->listing->update([
                    'status' => 'matched',
                    'matched_buyer_id' => $offer->buyer_id,
                    'matched_at' => now(),
                    'pickup_scheduled_at' => $offer->proposed_pickup_date,
                ]);

                // Log offer acceptance
                AuditLogger::logOfferStatusChange(
                    $offer->id,
                    'pending',
                    'accepted',
                    "Seller {$offer->listing->seller->name} accepted offer of ₱" . number_format($offer->bid_amount, 2)
                );

                // Notify buyer that offer was accepted
                Notification::notify(
                    $offer->buyer,
                    'offer_accepted',
                    'Offer Accepted! 🎉',
                    "Your offer of ₱" . number_format($offer->bid_amount, 2) . " has been accepted. Pickup scheduled for " . $offer->proposed_pickup_date->format('M d, Y'),
                    [
                        'listing_id' => $offer->listing->id,
                        'offer_id' => $offer->id,
                        'seller_name' => $offer->listing->seller->name,
                    ]
                );

                // Create initial welcome message in the chat thread
                Message::create([
                    'offer_id' => $offer->id,
                    'sender_id' => $offer->listing->user_id,
                    'receiver_id' => $offer->buyer_id,
                    'message' => "Hello! I have accepted your offer of ₱" . number_format($offer->bid_amount, 2) . ". Let's coordinate the pickup details and location here.",
                    'is_read' => false,
                ]);

                return redirect()->route('listings.show', $offer->listing)
                    ->with('success', 'Offer accepted! Buyer will arrange pickup.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to accept offer. Please try again.');
        }
    }

    /**
     * Reject an offer (seller action).
     */
    public function reject(Offer $offer)
    {
        // Only seller can reject
        if (Auth::id() !== $offer->listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Listing must not be withdrawn
        if ($offer->listing->status === 'withdrawn') {
            return redirect()->back()
                ->with('error', 'This listing has been withdrawn and offers can no longer be modified.');
        }

        if (!$offer->isPending()) {
            return redirect()->back()->with('error', 'Only pending offers can be rejected');
        }

        if ($offer->reject()) {
            // Log offer rejection
            AuditLogger::logOfferStatusChange(
                $offer->id,
                'pending',
                'rejected',
                "Seller {$offer->listing->seller->name} rejected offer"
            );

            // Notify buyer that offer was rejected
            Notification::notify(
                $offer->buyer,
                'offer_rejected',
                'Offer Rejected',
                "Your offer of ₱" . number_format($offer->bid_amount, 2) . " for the item has been rejected by the seller.",
                [
                    'listing_id' => $offer->listing->id,
                    'offer_id' => $offer->id,
                    'seller_name' => $offer->listing->seller->name,
                ]
            );

            return redirect()->route('listings.show', $offer->listing)
                ->with('success', 'Offer rejected');
        }

        return redirect()->back()
            ->with('error', 'Failed to reject offer');
    }

    /**
     * Cancel an offer (buyer action).
     */
    public function cancel(Request $request, Offer $offer)
    {
        // Only buyer can cancel
        if (Auth::id() !== $offer->buyer_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if (!$offer->canBuyerCancel()) {
            return redirect()->back()
                ->with('error', 'This offer can no longer be cancelled');
        }

        $isAccepted = $offer->status === 'accepted';

        if ($isAccepted) {
            $request->validate([
                'cancellation_reason' => 'required|string|min:3|max:1000',
            ], [
                'cancellation_reason.required' => 'Please provide a reason for cancelling this accepted offer.',
            ]);
        }

        $cancellationReason = $request->input('cancellation_reason');

        DB::transaction(function () use ($offer, $isAccepted, $cancellationReason) {
            $previousStatus = $offer->status;

            $offer->status = 'cancelled';
            $offer->cancellation_reason = $cancellationReason;
            $offer->responded_at = now();
            $offer->save();

            if ($isAccepted) {
                $listing = $offer->listing;
                if ($listing && ($listing->matched_buyer_id === $offer->buyer_id || $listing->status === 'matched')) {
                    $listing->update([
                        'status' => 'available',
                        'matched_buyer_id' => null,
                        'matched_at' => null,
                        'pickup_scheduled_at' => null,
                        'picked_up_at' => null,
                    ]);
                }
            }

            AuditLogger::logOfferStatusChange(
                $offer->id,
                $previousStatus,
                'cancelled',
                "Buyer {$offer->buyer->name} cancelled the offer." . ($cancellationReason ? " Reason: {$cancellationReason}" : '')
            );

            $notificationMessage = $isAccepted
                ? "{$offer->buyer->name} cancelled their accepted offer on your listing. Reason: " . ($cancellationReason ?: 'None provided') . ". Your listing is now available again."
                : "{$offer->buyer->name} withdrew their pending offer on your listing.";

            Notification::notify(
                $offer->listing->seller,
                'offer_cancelled',
                'Offer Cancelled',
                $notificationMessage,
                [
                    'listing_id' => $offer->listing->id,
                    'offer_id' => $offer->id,
                    'buyer_name' => $offer->buyer->name,
                    'cancellation_reason' => $cancellationReason,
                ]
            );
        });

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Offer cancelled successfully');
    }

    /**
     * Mark offer as picked up (buyer action).
     */
    public function markPickedUp(Offer $offer)
    {
        // Only buyer can mark as picked up
        if (Auth::id() !== $offer->buyer_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if ($offer->isAccepted() && $offer->listing->matched_buyer_id === Auth::id() && $offer->listing->status === 'matched') {
            $offer->listing->update([
                'status' => 'in_transit',
                'picked_up_at' => now(),
            ]);

            return redirect()->route('offers.show', $offer)
                ->with('success', 'Item marked as picked up');
        }

        return redirect()->back()
            ->with('error', 'Invalid offer status');
    }

    /**
     * Update processing status (buyer action).
     */
    public function updateProcessingStatus(Request $request, Offer $offer)
    {
        // Only buyer can update
        if (Auth::id() !== $offer->buyer_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if (!$offer->isAccepted()
            || $offer->listing->matched_buyer_id !== Auth::id()
            || $offer->listing->status !== 'delivered') {
            return redirect()->back()->with('error', 'This offer is not ready for processing');
        }

        $validated = $request->validate([
            'processing_method' => 'required|in:repair,harvest,refine,dispose',
            'material_breakdown' => 'array',
            'material_breakdown.*.type' => 'required|string|in:gold,copper,plastic,aluminum,rare_earth',
            'material_breakdown.*.weight' => 'required|numeric|min:0|max:9999.99',
        ]);

        $deviceWeight = (float) ($offer->listing->estimated_weight ?? 1.0);
        if ($deviceWeight <= 0) {
            $deviceWeight = 1.0;
        }

        $totalRecoveredWeight = collect($validated['material_breakdown'] ?? [])
            ->sum(fn (array $material): float => (float) $material['weight']);

        if ($totalRecoveredWeight > $deviceWeight) {
            return redirect()->back()
                ->withErrors(['material_breakdown' => "Total recovered material ({$totalRecoveredWeight} kg) cannot exceed the estimated device weight ({$deviceWeight} kg)."])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $offer) {
            if ($offer->impactLog()->exists()) {
                throw new \RuntimeException('Impact has already been recorded for this offer');
            }

            // Update listing as processed
            $offer->listing->update([
                'status' => 'processed',
                'processed_at' => now(),
            ]);

            // Calculate impact and create impact log
            $impactController = new ImpactController();
            $impactController->createImpactLog($offer, $validated);

            // Mark offer as completed
            $offer->complete();
        });

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Processing status updated. Impact certificate generated!');
    }

    /**
     * Search listings by filters.
     */
    public function search(Request $request)
    {
        $query = Listing::where('status', 'available');

        if ($request->has('category') && $request->category) {
            $query->whereHas('deviceType', function ($deviceTypeQuery) use ($request) {
                $deviceTypeQuery->where('name', $request->category);
            });
        }

        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('suggested_price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('suggested_price', '<=', $request->max_price);
        }

        $listings = $query->with(['seller', 'offers', 'deviceType', 'listingPhotos'])->paginate(15);

        return view('listings.search-results', compact('listings'));
    }

    /**
     * Get offers by status for a buyer.
     */
    public function getOffersByStatus(Request $request)
    {
        $user = Auth::user();

        $status = $request->get('status', 'pending');
        $offers = Offer::where('buyer_id', $user->id)
            ->where('status', $status)
            ->with(['listing', 'listing.seller'])
            ->paginate(10);

        return view('buyer.offers', compact('offers', 'status'));
    }

    /**
     * Show buyer transaction history.
     */
    public function buyerTransactionHistory(Request $request)
    {
        $user = Auth::user();

        if (!$user->isBuyer()) {
            return redirect('/')->with('error', 'Only buyers can access this');
        }

        $query = Offer::where('buyer_id', $user->id)
            ->with(['listing', 'listing.seller', 'listing.impactLog', 'buyer', 'listing.deviceType']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Order by most recent first
        $offers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('buyer.transaction-history', compact('offers'));
    }

    /**
     * Show seller transaction history.
     */
    public function sellerTransactionHistory(Request $request)
    {
        $user = Auth::user();

        if (!$user->isSeller()) {
            return redirect('/')->with('error', 'Only sellers can access this');
        }

        // Get all offers for the seller's listings
        $query = Offer::whereIn('listing_id', $user->listings()->pluck('id'))
            ->with(['listing', 'listing.seller', 'listing.impactLog', 'buyer', 'listing.deviceType']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Order by most recent first
        $offers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('seller.transaction-history', compact('offers'));
    }

    /**
     * Show seller sales analytics.
     */
    public function sellerSalesAnalytics()
    {
        $user = Auth::user();

        if (!$user->isSeller()) {
            return redirect('/')->with('error', 'Only sellers can access this');
        }

        $listingIds = $user->listings()->pluck('id');
        $offersQuery = Offer::whereIn('listing_id', $listingIds);

        $totalListings = $user->listings()->count();
        $totalOffers = (clone $offersQuery)->count();
        $completedSales = (clone $offersQuery)->where('status', 'completed')->count();
        $pendingOffers = (clone $offersQuery)->where('status', 'pending')->count();
        $acceptedOffers = (clone $offersQuery)->where('status', 'accepted')->count();
        $rejectedOffers = (clone $offersQuery)->where('status', 'rejected')->count();
        $cancelledOffers = (clone $offersQuery)->where('status', 'cancelled')->count();

        $totalRevenue = (float) (clone $offersQuery)
            ->where('status', 'completed')
            ->sum('bid_amount');

        $averageCompletedBid = (float) ((clone $offersQuery)
            ->where('status', 'completed')
            ->avg('bid_amount') ?? 0);

        $acceptanceRate = $totalOffers > 0
            ? round((($acceptedOffers + $completedSales) / $totalOffers) * 100, 1)
            : 0;

        $monthlyLabels = [];
        $monthlySalesCounts = [];
        $monthlyRevenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();

            $salesInMonthQuery = (clone $offersQuery)
                ->where('status', 'completed')
                ->whereBetween('updated_at', [$monthStart, $monthEnd]);

            $monthlyLabels[] = $monthStart->format('M Y');
            $monthlySalesCounts[] = $salesInMonthQuery->count();
            $monthlyRevenue[] = (float) $salesInMonthQuery->sum('bid_amount');
        }

        $statusBreakdown = [
            'pending' => $pendingOffers,
            'accepted' => $acceptedOffers,
            'completed' => $completedSales,
            'rejected' => $rejectedOffers,
            'cancelled' => $cancelledOffers,
        ];

        $topCategories = Offer::query()
            ->join('listings', 'offers.listing_id', '=', 'listings.id')
            ->leftJoin('device_types', 'listings.device_type_id', '=', 'device_types.id')
            ->whereIn('offers.listing_id', $listingIds)
            ->where('offers.status', 'completed')
            ->selectRaw("COALESCE(NULLIF(device_types.name, ''), 'Uncategorized') as category")
            ->selectRaw('COUNT(*) as sales_count')
            ->selectRaw('COALESCE(SUM(offers.bid_amount), 0) as revenue')
            ->groupBy('device_types.name')
            ->orderByDesc('sales_count')
            ->limit(5)
            ->get();

        $recentCompletedSales = Offer::whereIn('listing_id', $listingIds)
            ->where('status', 'completed')
            ->with(['listing.deviceType', 'buyer'])
            ->orderBy('updated_at', 'desc')
            ->limit(8)
            ->get();

        return view('seller.sales-analytics', compact(
            'totalListings',
            'totalOffers',
            'completedSales',
            'pendingOffers',
            'acceptedOffers',
            'rejectedOffers',
            'totalRevenue',
            'averageCompletedBid',
            'acceptanceRate',
            'monthlyLabels',
            'monthlySalesCounts',
            'monthlyRevenue',
            'statusBreakdown',
            'topCategories',
            'recentCompletedSales'
        ));
    }
}
