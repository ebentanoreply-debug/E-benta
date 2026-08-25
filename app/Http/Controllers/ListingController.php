<?php

namespace App\Http\Controllers;

use App\Models\ImpactLog;
use App\Models\Listing;
use App\Models\User;
use App\Models\DeviceType;
use App\Models\DeviceBrand;
use App\Models\DeviceModel;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Show all available listings for buyers.
     */
    public function index(Request $request)
    {
        $query = Listing::where('status', 'available')
            ->with(['seller', 'offers', 'deviceType', 'listingPhotos']);

        $savedListingIds = collect();
        if (Auth::check() && Auth::user()->isBuyer()) {
            $savedListingIds = Auth::user()->savedListings()->pluck('listings.id');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('deviceType', function ($deviceTypeQuery) use ($request) {
                $deviceTypeQuery->where('name', $request->category);
            });
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        // Filter by intended action
        if ($request->has('action') && $request->action) {
            $query->where('intended_action', $request->action);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('suggested_price', 'asc'),
            'price_high' => $query->orderBy('suggested_price', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'), // latest
        };

        $listings = $query->paginate(15);

        return view('listings.index', compact('listings', 'savedListingIds'));
    }

    /**
     * Show seller's dashboard with their listings.
     */
    public function sellerDashboard()
    {
        $user = Auth::user();

        if (!$user->isSeller()) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $listings = Listing::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDay())
            ->with(['deviceType', 'listingPhotos'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statistics = [
            'total_listings' => Listing::where('user_id', $user->id)->count(),
            'active_listings' => Listing::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'available'])
                ->count(),
            'matched_listings' => Listing::where('user_id', $user->id)
                ->where('status', 'matched')
                ->count(),
            'completed_transactions' => Listing::where('user_id', $user->id)
                ->where('status', 'processed')
                ->count(),
        ];

        $isRecentView = true;

        return view('seller.dashboard', compact('listings', 'statistics', 'isRecentView'));
    }

    /**
     * Show seller's full listing history.
     */
    public function sellerListings()
    {
        $user = Auth::user();

        if (!$user->isSeller()) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $listings = Listing::where('user_id', $user->id)
            ->with(['deviceType', 'listingPhotos'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statistics = [
            'total_listings' => Listing::where('user_id', $user->id)->count(),
            'active_listings' => Listing::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'available'])
                ->count(),
            'matched_listings' => Listing::where('user_id', $user->id)
                ->where('status', 'matched')
                ->count(),
            'completed_transactions' => Listing::where('user_id', $user->id)
                ->where('status', 'processed')
                ->count(),
        ];

        $isRecentView = false;

        return view('seller.dashboard', compact('listings', 'statistics', 'isRecentView'));
    }

    /**
     * Show listing creation form.
     */
    public function create()
    {
        $deviceTypes = DeviceType::all();
        $deviceBrands = DeviceBrand::all();
        $categories = [
            'Laptop',
            'Desktop',
            'Smartphone',
            'Tablet',
            'Monitor',
            'Keyboard',
            'Mouse',
            'Printer',
            'Scanner',
            'Router',
            'Modem',
            'Motherboard',
            'Graphics Card',
            'RAM',
            'Hard Drive',
            'Power Supply',
            'Cooling Fan',
            'Case',
            'Cable',
            'Charger',
            'Other',
        ];

        return view('listings.create', compact('categories', 'deviceTypes', 'deviceBrands'));
    }

    /**
     * Store a new listing.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'device_brand_id' => 'nullable|exists:device_brands,id',
            'device_model_id' => ['nullable', 'exists:device_models,id', function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->device_brand_id) {
                    $model = DeviceModel::find($value);
                    if (!$model || $model->device_type_id != $request->device_type_id || $model->device_brand_id != $request->device_brand_id) {
                        $fail('The selected model does not match the selected device type and brand.');
                    }
                }
            }],
            'device_details' => 'nullable|string|max:255',
            'condition' => 'required|in:working,minor_damage,major_damage,non_functional',
            'description' => 'required|string|max:1000',
            'intended_action' => 'required|in:sell,donate,recycle',
            'suggested_price' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->intended_action === 'sell') {
            $request->validate([
                'suggested_price' => 'required|numeric|min:0|max:9999999.99',
            ]);
        }

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('listings', 'public');
                $photos[] = Storage::url($path);
            }
        }

        $deviceType = DeviceType::find($request->device_type_id);
        $categoryName = $deviceType?->name;

        // Get estimated weight based on category
        $weight = Listing::getDefaultWeight($categoryName);

        // Calculate carbon footprint
        $carbonFootprint = Listing::calculateCarbonFootprint($categoryName, $weight);

        $listing = Listing::create([
            'user_id' => Auth::id(),
            'device_type_id' => $request->device_type_id,
            'device_brand_id' => $request->device_brand_id,
            'device_model_id' => $request->device_model_id,
            'device_details' => $request->device_details,
            'condition' => $request->condition,
            'description' => $request->description,
            'estimated_weight' => $weight,
            'intended_action' => $request->intended_action,
            'suggested_price' => $request->filled('suggested_price') ? round((float) $request->suggested_price, 2) : null,
            'status' => 'pending',
            'carbon_footprint' => $carbonFootprint,
        ]);

        if (!empty($photos)) {
            $listing->listingPhotos()->createMany(
                collect($photos)->values()->map(function (string $photoUrl, int $index): array {
                    return [
                        'photo_url' => $photoUrl,
                        'sort_order' => $index,
                    ];
                })->all()
            );
        }

        // Auto-approve if not requiring admin verification, set to available
        $listing->update(['status' => 'available']);

        // Notify seller that listing was created successfully
        $itemName = $listing->category ?: ($listing->deviceType->name ?: 'item');
        Notification::notify(
            Auth::user(),
            'listing_created',
            'Listing Created Successfully! 📋',
            "Your " . $itemName . " is now available for offers.",
            [
                'listing_id' => $listing->id,
                'listing_status' => 'available',
            ]
        );

        return redirect()->route('seller.dashboard')
            ->with('success', 'Listing created successfully! Item is now available for offers.');
    }

    /**
     * Show a single listing.
     */
    public function show(Listing $listing)
    {
        // Check if listing is available or user is the seller/admin
        if ($listing->status !== 'available' && Auth::id() !== $listing->user_id && !Auth::user()?->isAdmin()) {
            return redirect('/')->with('error', 'Listing not found');
        }

        $listing->load(['seller', 'offers' => function ($query) {
            $query->where('status', 'pending')->with('buyer');
        }, 'deviceType', 'listingPhotos']);

        return view('listings.show', compact('listing'));
    }

    /**
     * Show listing edit form.
     */
    public function edit(Listing $listing)
    {
        // Only owner can edit
        if (Auth::id() !== $listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Can only edit if not matched yet
        if ($listing->isMatched()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Cannot edit a matched listing');
        }

        $deviceTypes = DeviceType::all();
        $deviceBrands = DeviceBrand::all();
        $deviceModels = $listing->device_type_id ? DeviceModel::where('device_type_id', $listing->device_type_id)->get() : collect();
        $categories = [
            'Laptop', 'Desktop', 'Smartphone', 'Tablet', 'Monitor',
            'Keyboard', 'Mouse', 'Printer', 'Scanner', 'Router', 'Modem',
            'Motherboard', 'Graphics Card', 'RAM', 'Hard Drive',
            'Power Supply', 'Cooling Fan', 'Case', 'Cable', 'Charger', 'Other',
        ];

        return view('listings.edit', compact('listing', 'categories', 'deviceTypes', 'deviceBrands', 'deviceModels'));
    }

    /**
     * Update a listing.
     */
    public function update(Request $request, Listing $listing)
    {
        // Only owner can update
        if (Auth::id() !== $listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Cannot update if matched
        if ($listing->isMatched()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Cannot edit a matched listing');
        }

        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'device_brand_id' => 'nullable|exists:device_brands,id',
            'device_model_id' => ['nullable', 'exists:device_models,id', function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->device_brand_id) {
                    $model = DeviceModel::find($value);
                    if (!$model || $model->device_type_id != $request->device_type_id || $model->device_brand_id != $request->device_brand_id) {
                        $fail('The selected model does not match the selected device type and brand.');
                    }
                }
            }],
            'device_details' => 'nullable|string|max:255',
            'condition' => 'required|in:working,minor_damage,major_damage,non_functional',
            'description' => 'required|string|max:1000',
            'intended_action' => 'required|in:sell,donate,recycle',
            'suggested_price' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_photos' => 'array',
            'delete_photos.*' => 'integer',
        ]);

        if ($request->intended_action === 'sell') {
            $request->validate([
                'suggested_price' => 'required|numeric|min:0|max:9999999.99',
            ]);
        }

        // Handle photo deletions
        $currentPhotos = $listing->listingPhotos()->orderBy('sort_order')->get()->values();
        $deleteIndices = collect($request->input('delete_photos', []))
            ->map(fn ($index) => (int) $index)
            ->filter(fn (int $index) => $index >= 0)
            ->unique()
            ->sortDesc()
            ->values();

        foreach ($deleteIndices as $index) {
            $photo = $currentPhotos->get($index);
            if ($photo) {
                // Extract the path from the URL and delete from storage
                $path = str_replace('/storage/', '', $photo->photo_url);
                Storage::disk('public')->delete($path);
                $photo->delete();
            }
        }

        $remainingPhotos = $listing->listingPhotos()->orderBy('sort_order')->get()->values();
        foreach ($remainingPhotos as $newOrder => $photo) {
            if ((int) $photo->sort_order !== $newOrder) {
                $photo->update(['sort_order' => $newOrder]);
            }
        }

        // Handle new photo uploads
        $nextSortOrder = $remainingPhotos->count();
        $newPhotoRows = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('listings', 'public');
                $newPhotoRows[] = [
                    'photo_url' => Storage::url($path),
                    'sort_order' => $nextSortOrder++,
                ];
            }
        }

        if (!empty($newPhotoRows)) {
            $listing->listingPhotos()->createMany($newPhotoRows);
        }

        $deviceType = DeviceType::find($request->device_type_id);
        $categoryName = $deviceType?->name;
        $weight = Listing::getDefaultWeight($categoryName);
        $carbonFootprint = Listing::calculateCarbonFootprint($categoryName, $weight);

        $listing->update([
            'device_type_id' => $request->device_type_id,
            'device_brand_id' => $request->device_brand_id,
            'device_model_id' => $request->device_model_id,
            'device_details' => $request->device_details,
            'condition' => $request->condition,
            'description' => $request->description,
            'intended_action' => $request->intended_action,
            'suggested_price' => $request->filled('suggested_price') ? round((float) $request->suggested_price, 2) : null,
            'estimated_weight' => $weight,
            'carbon_footprint' => $carbonFootprint,
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully');
    }

    /**
     * Withdraw a listing (mark as unavailable without deletion).
     */
    public function withdraw(Listing $listing)
    {
        // Only owner can withdraw
        if (Auth::id() !== $listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Cannot withdraw if already matched
        if ($listing->isMatched()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Cannot withdraw a matched listing');
        }

        $listing->update(['status' => 'withdrawn']);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Listing has been withdrawn and is no longer available');
    }

    /**
     * Delete a listing (admin only).
     */
    public function destroy(Listing $listing)
    {
        // Only admin can delete permanently
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Only administrators can delete listings');
        }

        $listing->delete();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Listing deleted successfully');
    }

    /**
     * Get available offers for a listing.
     */
    public function getOffers(Listing $listing)
    {
        // Only seller can view offers
        if (Auth::id() !== $listing->user_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $offers = $listing->offers()
            ->where('status', 'pending')
            ->with('buyer')
            ->orderBy('bid_amount', 'desc')
            ->get();

        return view('listings.offers', compact('listing', 'offers'));
    }

    /**
     * Mark listing as delivered.
     */
    public function markDelivered(Listing $listing)
    {
        // Only matched buyer can mark as delivered
        if (Auth::id() !== $listing->matched_buyer_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if ($listing->status !== 'in_transit') {
            return redirect()->back()->with('error', 'Only items in transit can be marked as delivered');
        }

        $listing->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Item marked as delivered');
    }

    /**
     * Get listing statistics for dashboard.
     */
    public function getStatistics(User $user)
    {
        return [
            'total_listings' => Listing::where('user_id', $user->id)->count(),
            'pending_offers' => Listing::where('user_id', $user->id)
                ->whereHas('offers', function ($q) {
                    $q->where('status', 'pending');
                })
                ->count(),
            'total_co2_saved' => ImpactLog::where('seller_id', $user->id)->sum('co2_saved'),
            'total_items_processed' => ImpactLog::where('seller_id', $user->id)->count(),
        ];
    }
}
