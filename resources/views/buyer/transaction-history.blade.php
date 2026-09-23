@extends('layouts.buyer')

@section('title', 'Transaction History - Buyer Hub - E-Benta')

@section('styles')
<style>
    .th-page-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    .th-hero-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1.25rem;
        color: #ffffff;
        padding: 2.25rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(13, 148, 136, 0.15);
    }

    .th-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.25) 0%, rgba(6, 182, 212, 0.12) 50%, transparent 70%);
        pointer-events: none;
    }

    .th-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }

    .th-metric-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.1rem;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
        transition: all 0.2s ease;
        height: 100%;
    }

    .th-metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.1);
        border-color: rgba(13, 148, 136, 0.3);
    }

    .th-transaction-item {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
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

    /* 5-Stage Order Tracking Stepper */
    .order-stepper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        padding: 0.75rem 0.5rem;
        margin: 1rem 0;
        background: rgba(13, 148, 136, 0.03);
        border-radius: 0.75rem;
        border: 1px solid rgba(13, 148, 136, 0.1);
    }
    .order-stepper::before {
        content: '';
        position: absolute;
        top: 28px;
        left: 30px;
        right: 30px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .order-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .order-step-node {
        width: 32px;
        height: 32px;
        margin: 0 auto;
        border-radius: 50%;
        background: #f1f5f9;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
        color: #94a3b8;
        transition: all 0.25s ease;
    }
    .order-step.completed .order-step-node {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .order-step.active .order-step-node {
        background: #0d9488;
        border-color: #0d9488;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.3);
    }
    .order-step-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748b;
        margin-top: 0.35rem;
        letter-spacing: 0.2px;
    }
    .order-step.completed .order-step-title,
    .order-step.active .order-step-title {
        color: #0f172a;
        font-weight: 800;
    }
    @media (max-width: 576px) {
        .order-step-title {
            display: none;
        }
    }
</style>
@endsection

@section('content')

<div class="th-page-wrapper py-4">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4">
            
            <!-- LEFT COLUMN: INTEGRATED BUYER ACCOUNT NAVIGATION -->
            <aside class="col-lg-3 col-xl-3">
                @include('buyer.sidebar')
            </aside>

            <!-- RIGHT COLUMN: MAIN CONTENT -->
            <main class="col-lg-9 col-xl-9">
                <!-- HERO HEADER -->
                <div class="th-hero-header mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 1;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-receipt me-1"></i>Order Ledger
                                </span>
                                <span style="color: #cbd5e1; font-size: 0.85rem;">• {{ $offers->total() }} Total Transactions</span>
                            </div>
                            <h1 style="font-size: clamp(1.6rem, 2.3vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px; color: #ffffff;">
                                Transaction History & Offers
                            </h1>
                            <p style="color: #cbd5e1; font-size: 0.95rem; margin: 0.4rem 0 0;">
                                Track your offer statuses, negotiations, pickups, and verified environmental recovery impact.
                            </p>
                        </div>

                        <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 800; padding: 0.65rem 1.25rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);">
                            <i class="fas fa-search"></i>
                            <span>Browse Marketplace</span>
                        </a>
                    </div>
                </div>

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
                            <span style="color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">CO₂ Avoided</span>
                            <h3 style="font-size: 1.45rem; font-weight: 900; margin: 0.2rem 0 0; color: #a855f7;">{{ number_format((float)(auth()->user()->total_co2_saved ?? 0), 2) }} kg</h3>
                        </div>
                    </div>
                </div>

                <!-- FILTER TABS & SEARCH -->
                <div class="th-card mb-4 p-3 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('buyer.transaction-history') }}" class="btn btn-sm {{ !request('status') ? 'btn-teal' : 'btn-light' }}" style="{{ !request('status') ? 'background: #0d9488; color: #ffffff; font-weight: 800;' : 'font-weight: 600;' }} border-radius: 0.6rem;">
                            All ({{ $offers->total() }})
                        </a>
                        <a href="{{ route('buyer.transaction-history', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-teal' : 'btn-light' }}" style="{{ request('status') === 'pending' ? 'background: #0d9488; color: #ffffff; font-weight: 800;' : 'font-weight: 600;' }} border-radius: 0.6rem;">
                            Pending Review
                        </a>
                        <a href="{{ route('buyer.transaction-history', ['status' => 'accepted']) }}" class="btn btn-sm {{ request('status') === 'accepted' ? 'btn-teal' : 'btn-light' }}" style="{{ request('status') === 'accepted' ? 'background: #0d9488; color: #ffffff; font-weight: 800;' : 'font-weight: 600;' }} border-radius: 0.6rem;">
                            Accepted & Active
                        </a>
                        <a href="{{ route('buyer.transaction-history', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') === 'completed' ? 'btn-teal' : 'btn-light' }}" style="{{ request('status') === 'completed' ? 'background: #0d9488; color: #ffffff; font-weight: 800;' : 'font-weight: 600;' }} border-radius: 0.6rem;">
                            Completed
                        </a>
                    </div>
                </div>

                <!-- OFFERS LIST -->
                @if($offers->count() > 0)
                    <div>
                        @foreach($offers as $offer)
                            <article class="th-transaction-item">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span style="font-size: 0.72rem; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                                Offer #{{ $offer->id }} • {{ $offer->created_at->format('M d, Y') }}
                                            </span>
                                            @if($offer->status === 'accepted')
                                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; font-size: 0.72rem; border-radius: 1rem;">
                                                    <i class="fas fa-check-circle me-1"></i>Accepted
                                                </span>
                                            @elseif($offer->status === 'pending')
                                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; font-size: 0.72rem; border-radius: 1rem;">
                                                    <i class="fas fa-clock me-1"></i>Pending Seller Review
                                                </span>
                                            @elseif($offer->status === 'completed')
                                                <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 800; font-size: 0.72rem; border-radius: 1rem;">
                                                    <i class="fas fa-flag-checkered me-1"></i>Completed
                                                </span>
                                            @else
                                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #dc2626; font-weight: 800; font-size: 0.72rem; border-radius: 1rem;">
                                                    {{ ucfirst($offer->status) }}
                                                </span>
                                            @endif
                                        </div>
                                        <h5 style="font-weight: 800; margin: 0; color: #0f172a;" class="text-heading">
                                            {{ $offer->listing?->title ?? 'E-Waste Item #'.$offer->listing_id }}
                                        </h5>
                                    </div>

                                    <div class="text-end">
                                        <small style="color: #94a3b8; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; display: block;">Offer Amount</small>
                                        <strong style="color: #0d9488; font-size: 1.25rem; font-weight: 900;">
                                            ₱{{ number_format($offer->bid_amount ?? $offer->amount ?? 0, 2) }}
                                        </strong>
                                    </div>
                                </div>

                                <!-- 5-Stage Stepper Flow -->
                                @php
                                    $stepState = 1;
                                    if ($offer->status === 'accepted') { $stepState = 2; }
                                    if ($offer->payment_status === 'paid') { $stepState = 3; }
                                    if ($offer->processing_status === 'picked_up' || $offer->processing_status === 'in_transit') { $stepState = 4; }
                                    if ($offer->status === 'completed') { $stepState = 5; }
                                @endphp
                                <div class="order-stepper">
                                    <div class="order-step {{ $stepState >= 1 ? ($stepState == 1 ? 'active' : 'completed') : '' }}">
                                        <div class="order-step-node">
                                            @if($stepState > 1)<i class="fas fa-check"></i>@else 1 @endif
                                        </div>
                                        <div class="order-step-title">Offer Placed</div>
                                    </div>
                                    <div class="order-step {{ $stepState >= 2 ? ($stepState == 2 ? 'active' : 'completed') : '' }}">
                                        <div class="order-step-node">
                                            @if($stepState > 2)<i class="fas fa-check"></i>@else 2 @endif
                                        </div>
                                        <div class="order-step-title">Accepted</div>
                                    </div>
                                    <div class="order-step {{ $stepState >= 3 ? ($stepState == 3 ? 'active' : 'completed') : '' }}">
                                        <div class="order-step-node">
                                            @if($stepState > 3)<i class="fas fa-check"></i>@else 3 @endif
                                        </div>
                                        <div class="order-step-title">Escrow Paid</div>
                                    </div>
                                    <div class="order-step {{ $stepState >= 4 ? ($stepState == 4 ? 'active' : 'completed') : '' }}">
                                        <div class="order-step-node">
                                            @if($stepState > 4)<i class="fas fa-check"></i>@else 4 @endif
                                        </div>
                                        <div class="order-step-title">Handover</div>
                                    </div>
                                    <div class="order-step {{ $stepState >= 5 ? 'completed' : '' }}">
                                        <div class="order-step-node">
                                            @if($stepState == 5)<i class="fas fa-check"></i>@else 5 @endif
                                        </div>
                                        <div class="order-step-title">Completed</div>
                                    </div>
                                </div>

                                <!-- Transaction Details -->
                                <div class="row g-2 text-muted mb-3" style="font-size: 0.82rem;">
                                    <div class="col-sm-4">
                                        <i class="fas fa-user me-1 text-teal"></i> Seller: <strong>{{ $offer->listing?->seller?->name ?? 'Verified Seller' }}</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <i class="fas fa-wrench me-1 text-teal"></i> Recovery: <strong>{{ ucfirst($offer->proposed_method ?? 'Repair') }}</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <i class="fas fa-truck me-1 text-teal"></i> Handover: <strong>{{ ucfirst($offer->handover_method ?? 'Pickup') }}</strong>
                                    </div>
                                </div>

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

            </main>
        </div>
    </div>
</div>

@endsection
