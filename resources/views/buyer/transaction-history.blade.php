@extends('layouts.app')

@section('title', 'Transaction History - Buyer Hub - E-Benta')

@section('styles')
<style>
    .th-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .th-page-container {
        background: #09171f;
    }

    .th-hero-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .th-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.08) 50%, transparent 70%);
        pointer-events: none;
    }

    .th-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }

    body.dark-mode .th-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .th-metric-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.1rem;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
        transition: all 0.2s ease;
    }

    body.dark-mode .th-metric-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .th-transaction-item {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 1.1rem;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .th-transaction-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.1);
        border-color: rgba(13, 148, 136, 0.35);
    }

    body.dark-mode .th-transaction-item {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .th-transaction-item:hover {
        border-color: rgba(13, 148, 136, 0.45);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    }
</style>
@endsection

@section('content')

@include('buyer.sidebar')

<div class="main-content-wrapper">
    <div class="th-page-container">
        
        <!-- HERO HEADER -->
        <div class="th-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-receipt me-1"></i>Order Ledger
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $offers->total() }} Total Transactions</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Transaction History & Offers
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Track your offer statuses, negotiations, pickups, and verified environmental recovery impact.
                        </p>
                    </div>

                    <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 800; padding: 0.65rem 1.25rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);">
                        <i class="fas fa-search"></i>
                        <span>Browse Marketplace</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- METRIC CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="th-metric-card">
                        <span style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">Total Bids</span>
                        <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.2rem 0 0; color: #0f172a;" class="text-heading">{{ $offers->total() }}</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="th-metric-card">
                        <span style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">Completed Deals</span>
                        <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.2rem 0 0; color: #10b981;">{{ $offers->where('status', 'completed')->count() }}</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="th-metric-card">
                        <span style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">E-Waste Diverted</span>
                        <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.2rem 0 0; color: #0d9488;">{{ number_format((float)(auth()->user()->total_weight_diverted ?? 0), 2) }} kg</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="th-metric-card">
                        <span style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">CO₂ Offset</span>
                        <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.2rem 0 0; color: #06b6d4;">{{ number_format((float)(auth()->user()->total_co2_saved ?? 0), 2) }} kg</h3>
                    </div>
                </div>
            </div>

            <!-- FILTER TOOLBAR -->
            <div class="th-card mb-4 p-3 p-md-4">
                <form method="GET" action="{{ route('buyer.transaction-history') }}" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase; color: #475569;">Filter by Status</label>
                        <select name="status" class="form-select form-select-sm" style="border-radius: 0.6rem; font-weight: 600;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Negotiation</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted / Scheduled</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed Deals</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected Offers</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark font-weight-bold px-3" style="border-radius: 0.6rem; padding: 0.45rem 1rem;">
                            <i class="fas fa-filter me-1"></i>Apply Filter
                        </button>
                        @if(request('status'))
                            <a href="{{ route('buyer.transaction-history') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem; padding: 0.45rem 0.75rem;">
                                <i class="fas fa-rotate-left"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TRANSACTIONS LIST -->
            @if($offers->count() > 0)
                <div>
                    @foreach($offers as $offer)
                        <article class="th-transaction-item">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 pb-3 border-bottom mb-3" style="border-bottom-color: #f1f5f9 !important;">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 46px; height: 46px; border-radius: 0.65rem; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
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
                                        <h5 style="font-weight: 800; font-size: 1.05rem; margin: 0 0 0.2rem; color: #0f172a;" class="text-heading">
                                            {{ $offer->listing?->title ?: ($offer->listing?->category ?: 'Listing Item #'.$offer->listing_id) }}
                                        </h5>
                                        <div class="d-flex align-items-center gap-2 flex-wrap" style="font-size: 0.8rem; color: #64748b;">
                                            <span><i class="fas fa-store me-1"></i>Seller: <strong>{{ $offer->listing?->seller?->name ?? 'Verified Member' }}</strong></span>
                                            <span>•</span>
                                            <span><i class="fas fa-clock me-1"></i>{{ $offer->created_at->format('M d, Y • g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($offer->status === 'accepted')
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; font-size: 0.78rem; padding: 0.4rem 0.8rem; border-radius: 2rem;">
                                            <i class="fas fa-check-circle me-1"></i>Accepted
                                        </span>
                                    @elseif($offer->status === 'pending')
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; font-size: 0.78rem; padding: 0.4rem 0.8rem; border-radius: 2rem;">
                                            <i class="fas fa-clock me-1"></i>Pending Review
                                        </span>
                                    @elseif($offer->status === 'completed')
                                        <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 800; font-size: 0.78rem; padding: 0.4rem 0.8rem; border-radius: 2rem;">
                                            <i class="fas fa-flag-checkered me-1"></i>Completed
                                        </span>
                                    @else
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #dc2626; font-weight: 800; font-size: 0.78rem; padding: 0.4rem 0.8rem; border-radius: 2rem;">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Details Row -->
                            <div class="row g-3 mb-3">
                                <div class="col-6 col-md-3">
                                    <small style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; display: block;">Your Bid</small>
                                    <strong style="color: #0d9488; font-size: 1.1rem; font-weight: 900;">₱{{ number_format($offer->bid_amount ?? $offer->amount ?? 0, 2) }}</strong>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; display: block;">Method</small>
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #334155;">{{ ucfirst(str_replace('_', ' ', $offer->proposed_method ?? 'Pickup')) }}</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; display: block;">Pickup Target</small>
                                    <span style="font-size: 0.88rem; font-weight: 600; color: #334155;">{{ $offer->proposed_pickup_date?->format('M d, Y') ?? 'Not scheduled' }}</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; display: block;">Handover Point</small>
                                    <span style="font-size: 0.85rem; color: #64748b;" title="{{ $offer->pickup_location }}">{{ Str::limit($offer->pickup_location ?: 'Seller address', 22) }}</span>
                                </div>
                            </div>

                            <!-- Environmental Impact Pill if completed -->
                            @php $impact = $offer->listing?->impactLog; @endphp
                            @if($offer->status === 'completed' && $impact)
                                <div class="p-2 px-3 rounded-3 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: rgba(13, 148, 136, 0.08); border: 1px solid rgba(13, 148, 136, 0.2);">
                                    <div class="d-flex align-items-center gap-3">
                                        <span style="color: #0d9488; font-weight: 800; font-size: 0.8rem;"><i class="fas fa-leaf me-1"></i>Verified Impact:</span>
                                        <span style="font-size: 0.8rem; font-weight: 700; color: #0f766e;">{{ $impact->landfill_diverted_weight }} kg Diverted</span>
                                        <span style="font-size: 0.8rem; font-weight: 700; color: #06b6d4;">{{ $impact->co2_saved }} kg CO₂ Saved</span>
                                    </div>
                                    <a href="{{ route('certificates.show', $impact) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.5rem; font-weight: 800; font-size: 0.75rem; padding: 0.2rem 0.6rem;">
                                        <i class="fas fa-certificate me-1" style="color: #f59e0b;"></i>View Certificate
                                    </a>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center gap-2 pt-2 border-top" style="border-top-color: #f1f5f9 !important;">
                                <a href="{{ route('offers.show', $offer) }}" class="btn btn-sm btn-dark" style="border-radius: 0.6rem; font-weight: 700; font-size: 0.82rem; padding: 0.4rem 1rem;">
                                    <i class="fas fa-eye me-1"></i>View Offer Room
                                </a>

                                @if($offer->status === 'completed' && !auth()->user()->reviewsGiven()->where('offer_id', $offer->id)->exists())
                                    <a href="{{ route('reviews.create', $offer) }}" class="btn btn-sm btn-outline-warning" style="border-radius: 0.6rem; font-weight: 800; font-size: 0.82rem; padding: 0.4rem 0.9rem;">
                                        <i class="fas fa-star me-1"></i>Leave Review
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    @if($offers->hasPages())
                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $offers->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="p-5 text-center bg-white rounded-4 border" style="border-color: rgba(13, 148, 136, 0.15) !important;">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem;">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a;" class="text-heading">No Transaction History Found</h4>
                    <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0.35rem auto 1.5rem;">
                        You haven't submitted any offers yet or no results matched the selected status filter.
                    </p>
                    <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.65rem; font-weight: 800; padding: 0.55rem 1.25rem;">
                        <i class="fas fa-search"></i>
                        <span>Explore Marketplace Listings</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
