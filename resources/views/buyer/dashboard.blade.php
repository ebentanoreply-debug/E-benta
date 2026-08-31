@extends('layouts.app')

@section('title', 'Buyer Dashboard - E-Benta')

@section('styles')
<style>
    .buyer-dashboard-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .buyer-dashboard-container {
        background: #09171f;
    }

    /* === HERO HEADER === */
    .buyer-hero-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.5rem 0 2.25rem;
        position: relative;
        overflow: hidden;
    }

    .buyer-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 500px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.08) 50%, transparent 70%);
        pointer-events: none;
    }

    /* === METRIC CARDS === */
    .buyer-metric-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .buyer-metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.35);
    }

    body.dark-mode .buyer-metric-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    body.dark-mode .buyer-metric-card:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(13, 148, 136, 0.5);
    }

    .buyer-metric-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    /* === SECTION CARDS === */
    .buyer-panel-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }

    body.dark-mode .buyer-panel-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .buyer-panel-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    body.dark-mode .buyer-panel-header {
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    /* === ITEM CARDS === */
    .listing-grid-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 1.1rem;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    .listing-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.35);
    }

    body.dark-mode .listing-grid-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .listing-grid-card:hover {
        border-color: rgba(13, 148, 136, 0.45);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.4);
    }

    .listing-image-wrapper {
        position: relative;
        width: 100%;
        height: 190px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        overflow: hidden;
    }

    body.dark-mode .listing-image-wrapper {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
    }

    .listing-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .listing-grid-card:hover .listing-image-wrapper img {
        transform: scale(1.05);
    }

    /* === TABLES === */
    .buyer-table th {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    body.dark-mode .buyer-table th {
        background: rgba(0, 0, 0, 0.25);
        color: #94a3b8;
    }

    .buyer-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 0.88rem;
        color: #334155;
    }

    body.dark-mode .buyer-table td {
        border-top-color: rgba(255, 255, 255, 0.05);
        color: #cbd5e1;
    }

    .buyer-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.03);
    }

    body.dark-mode .buyer-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.08);
    }
</style>
@endsection

@section('content')

@include('buyer.sidebar')

<div class="main-content-wrapper">
    <div class="buyer-dashboard-container">
        
        <!-- HERO HEADER -->
        <div class="buyer-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-shopping-bag me-1"></i>Buyer Hub
                            </span>
                            @if(auth()->user()->is_verified)
                                <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-check-circle me-1"></i>Verified Buyer
                                </span>
                            @else
                                <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-clock me-1"></i>Pending ID Verification
                                </span>
                            @endif
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Welcome back, {{ auth()->user()->name }}!
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Source e-waste devices, negotiate offers with verified sellers, and track environmental impact.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 800; padding: 0.65rem 1.25rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);">
                            <i class="fas fa-search"></i>
                            <span>Browse Marketplace</span>
                        </a>
                        <a href="{{ route('buyer.transaction-history') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.25); padding: 0.65rem 1.1rem;">
                            <i class="fas fa-receipt"></i>
                            <span>My Offers</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTAINER -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- ID VERIFICATION NOTICE IF PENDING -->
            @if(!auth()->user()->is_verified)
                <div class="alert mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 1rem; padding: 1rem 1.25rem;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 44px; height: 44px; border-radius: 0.75rem; background: rgba(245, 158, 11, 0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <strong style="color: #b45309; font-size: 0.95rem; display: block;">Account Pending Verification</strong>
                            <span style="color: #64748b; font-size: 0.85rem;">You can browse listings freely. To submit purchase offers and finalize transactions, submit your ID for instant verification.</span>
                        </div>
                    </div>
                    <a href="{{ route('settings') }}#verification" class="btn btn-sm btn-warning" style="border-radius: 0.6rem; font-weight: 800; padding: 0.45rem 1rem;">
                        Verify Identity <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif

            <!-- 4 METRICS MATRIX -->
            <div class="row g-3 mb-4">
                <!-- Account Status -->
                <div class="col-sm-6 col-xl-3">
                    <div class="buyer-metric-card">
                        <div>
                            <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Account Tier</span>
                            <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.25rem 0 0; color: #0f172a;" class="text-heading">
                                @if(auth()->user()->is_verified)
                                    <span style="color: #10b981;">Verified</span>
                                @else
                                    <span style="color: #f59e0b;">Pending ID</span>
                                @endif
                            </h3>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Platform Access Level</small>
                        </div>
                        <div class="buyer-metric-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                            <i class="fas fa-shield-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Items Processed -->
                <div class="col-sm-6 col-xl-3">
                    <div class="buyer-metric-card">
                        <div>
                            <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Items Acquired</span>
                            <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.25rem 0 0; color: #0f172a;" class="text-heading">
                                {{ auth()->user()->items_processed ?? (isset($offers) ? $offers->where('status', 'completed')->count() : 0) }}
                            </h3>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Processed Transactions</small>
                        </div>
                        <div class="buyer-metric-icon" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                            <i class="fas fa-box-archive"></i>
                        </div>
                    </div>
                </div>

                <!-- E-Waste Diverted -->
                <div class="col-sm-6 col-xl-3">
                    <div class="buyer-metric-card">
                        <div>
                            <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">E-Waste Diverted</span>
                            <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.25rem 0 0; color: #0f172a;" class="text-heading">
                                {{ number_format((float)(auth()->user()->total_weight_diverted ?? 0), 2) }} <span style="font-size: 0.85rem; font-weight: 700; color: #64748b;">kg</span>
                            </h3>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Recovered materials</small>
                        </div>
                        <div class="buyer-metric-icon" style="background: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                            <i class="fas fa-recycle"></i>
                        </div>
                    </div>
                </div>

                <!-- CO2 Saved -->
                <div class="col-sm-6 col-xl-3">
                    <div class="buyer-metric-card">
                        <div>
                            <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">CO₂ Avoided</span>
                            <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.25rem 0 0; color: #0f172a;" class="text-heading">
                                {{ number_format((float)(auth()->user()->total_co2_saved ?? 0), 2) }} <span style="font-size: 0.85rem; font-weight: 700; color: #64748b;">kg</span>
                            </h3>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Carbon footprint offset</small>
                        </div>
                        <div class="buyer-metric-icon" style="background: rgba(168, 85, 247, 0.12); color: #a855f7;">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT OFFERS & ACTIVE NEGOTIATIONS -->
            @if(isset($offers) && $offers->count() > 0)
                <div class="buyer-panel-card mb-4">
                    <div class="buyer-panel-header">
                        <div>
                            <h5 style="font-weight: 800; margin: 0; font-size: 1.1rem; color: #0f172a;" class="text-heading">
                                <i class="fas fa-receipt me-2" style="color: #0d9488;"></i>My Recent Offers
                            </h5>
                            <p style="color: #94a3b8; font-size: 0.82rem; margin: 0.2rem 0 0;">Latest bids and negotiations submitted by your account.</p>
                        </div>
                        <a href="{{ route('buyer.transaction-history') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem; font-weight: 700;">
                            View All ({{ $offers->total() }}) <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table buyer-table mb-0">
                            <thead>
                                <tr>
                                    <th>Listing Item</th>
                                    <th>Seller</th>
                                    <th>Offered Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers->take(5) as $offer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width: 38px; height: 38px; border-radius: 0.5rem; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                                                    @if($offer->listing?->photos && count(is_array($offer->listing->photos) ? $offer->listing->photos : json_decode($offer->listing->photos, true) ?? []) > 0)
                                                        @php
                                                            $photos = is_array($offer->listing->photos) ? $offer->listing->photos : json_decode($offer->listing->photos, true) ?? [];
                                                        @endphp
                                                        <img src="{{ $photos[0] }}" alt="Item" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-microchip text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong style="display: block; font-size: 0.88rem; color: #0f172a;" class="text-heading">
                                                        {{ Str::limit($offer->listing?->title ?? 'Listing #'.$offer->listing_id, 35) }}
                                                    </strong>
                                                    <small class="text-muted">{{ $offer->created_at?->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-size: 0.85rem; font-weight: 600; color: #475569;">{{ $offer->listing?->seller?->name ?? 'Verified Seller' }}</span>
                                        </td>
                                        <td>
                                            <span style="font-weight: 800; color: #0d9488; font-size: 0.95rem;">₱{{ number_format($offer->bid_amount ?? $offer->amount ?? 0, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(100, 116, 139, 0.1); color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.72rem;">
                                                {{ ucfirst($offer->proposed_method ?? 'Pickup') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($offer->status === 'accepted')
                                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 1rem;">
                                                    <i class="fas fa-check-circle me-1"></i>Accepted
                                                </span>
                                            @elseif($offer->status === 'pending')
                                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 1rem;">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @elseif($offer->status === 'completed')
                                                <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 1rem;">
                                                    <i class="fas fa-flag-checkered me-1"></i>Completed
                                                </span>
                                            @else
                                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #dc2626; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 1rem;">
                                                    {{ ucfirst($offer->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.5rem; font-weight: 700; font-size: 0.78rem; padding: 0.3rem 0.7rem;">
                                                Details <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- RECOMMENDED & AVAILABLE LISTINGS -->
            <div class="buyer-panel-card">
                <div class="buyer-panel-header">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 style="font-weight: 800; margin: 0; font-size: 1.15rem; color: #0f172a;" class="text-heading">
                                <i class="fas fa-store me-2" style="color: #0d9488;"></i>Available E-Waste Listings
                            </h5>
                            <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 800; font-size: 0.75rem; border-radius: 1rem;">
                                {{ $availableListings->total() }} Available
                            </span>
                        </div>
                        <p style="color: #94a3b8; font-size: 0.85rem; margin: 0.25rem 0 0;">Recent devices listed by verified community members ready for acquisition.</p>
                    </div>

                    <a href="{{ route('listings.index') }}" class="btn btn-sm d-inline-flex align-items-center gap-2" style="background: #f1f5f9; color: #0d9488; border-radius: 0.65rem; font-weight: 800; padding: 0.45rem 1rem;">
                        <span>Explore Full Catalog</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="p-3 p-md-4">
                    @if($availableListings->count() > 0)
                        <div class="row g-3 g-md-4">
                            @foreach($availableListings as $listing)
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="listing-grid-card">
                                        <!-- Image Box -->
                                        <div class="listing-image-wrapper">
                                            @php
                                                $photos = is_array($listing->photos) ? $listing->photos : (json_decode($listing->photos, true) ?? []);
                                                $firstPhoto = count($photos) > 0 ? $photos[0] : null;
                                            @endphp
                                            @if($firstPhoto)
                                                <img src="{{ $firstPhoto }}" alt="{{ $listing->title }}" loading="lazy">
                                            @else
                                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
                                                    <i class="fas fa-microchip" style="font-size: 2.5rem; opacity: 0.6; margin-bottom: 0.4rem; color: #0d9488;"></i>
                                                    <span style="font-size: 0.75rem; font-weight: 700;">E-Waste Device</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Condition Tag -->
                                            <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                                                <span class="badge" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #ffffff; font-weight: 800; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 0.45rem; text-transform: uppercase;">
                                                    {{ str_replace('_', ' ', $listing->condition ?? 'Good') }}
                                                </span>
                                            </div>

                                            <!-- Verification Badge -->
                                            @if($listing->seller?->is_verified)
                                                <div style="position: absolute; top: 0.75rem; right: 0.75rem;" title="Verified Seller">
                                                    <span style="background: rgba(16, 185, 129, 0.9); color: #ffffff; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Card Body -->
                                        <div class="p-3 d-flex flex-column flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                                <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0d9488; letter-spacing: 0.5px;">
                                                    {{ $listing->deviceType->name ?? ($listing->category ?? 'Electronics') }}
                                                </span>
                                                <span style="font-size: 0.72rem; color: #94a3b8;">
                                                    <i class="fas fa-location-dot me-1"></i>{{ Str::limit($listing->pickup_address ?: 'Local', 15) }}
                                                </span>
                                            </div>

                                            <h6 style="font-weight: 800; font-size: 0.95rem; margin-bottom: 0.4rem; color: #0f172a; line-height: 1.35;" class="text-heading">
                                                {{ Str::limit($listing->title ?: 'Electronic Component', 40) }}
                                            </h6>

                                            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem; line-height: 1.4; flex-grow: 1;">
                                                {{ Str::limit($listing->description ?? 'No extra specifications provided.', 65) }}
                                            </p>

                                            <!-- Price and Action -->
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto" style="border-top-color: #f1f5f9 !important;">
                                                <div>
                                                    <small style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Suggested Price</small>
                                                    <strong style="color: #0d9488; font-size: 1.1rem; font-weight: 900;">
                                                        @if($listing->suggested_price > 0)
                                                            ₱{{ number_format($listing->suggested_price, 2) }}
                                                        @else
                                                            <span style="color: #10b981;">Free Claim</span>
                                                        @endif
                                                    </strong>
                                                </div>

                                                <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm d-inline-flex align-items-center gap-1" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 800; border-radius: 0.6rem; padding: 0.45rem 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#0d9488'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(13, 148, 136, 0.12)'; this.style.color='#0d9488';">
                                                    <span>View</span>
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- PAGINATION -->
                        @if($availableListings->hasPages())
                            <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                                {{ $availableListings->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem;">
                                <i class="fas fa-store-slash"></i>
                            </div>
                            <h5 style="font-weight: 800; color: #0f172a;" class="text-heading">No Listings Available At The Moment</h5>
                            <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0.35rem auto 1.5rem;">
                                New e-waste lots and devices are posted daily by our verified community sellers.
                            </p>
                            <a href="{{ route('listings.index') }}" class="btn btn-sm btn-dark" style="border-radius: 0.65rem; font-weight: 700; padding: 0.5rem 1.25rem;">
                                Refresh Catalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
