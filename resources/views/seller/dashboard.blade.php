@extends('layouts.app')

@section('title', ($isRecentView ?? false) ? 'Seller Dashboard - E-Benta' : 'My Inventory - E-Benta')

@section('styles')
<style>
    /* ==========================================================================
       MODERN SELLER STUDIO OBSIDIAN DESIGN SYSTEM
       ========================================================================== */
    .seller-dashboard-container {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding-bottom: 4rem;
    }

    body.dark-mode .seller-dashboard-container {
        background-color: #09171f;
    }

    /* Executive Obsidian Hero Header */
    .seller-hero-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .seller-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 420px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .seller-live-pulse {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.78rem;
        font-weight: 800;
        color: #34d399;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 10px #10b981;
        animation: pulseAnimation 2s infinite;
    }

    @keyframes pulseAnimation {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.6; }
    }

    .seller-view-pill-group {
        display: inline-flex;
        background: rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 0.75rem;
        padding: 0.3rem;
        gap: 0.3rem;
    }

    .seller-view-pill {
        color: #94a3b8;
        padding: 0.45rem 0.95rem;
        border-radius: 0.55rem;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .seller-view-pill:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
    }

    .seller-view-pill.active {
        background: #0d9488;
        color: #ffffff;
        box-shadow: 0 2px 10px rgba(13, 148, 136, 0.4);
    }

    .btn-create-listing-cta {
        background: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.88rem;
        padding: 0.65rem 1.35rem;
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-create-listing-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(16, 185, 129, 0.45);
        background: linear-gradient(135deg, #0f766e 0%, #059669 100%);
    }

    /* Modern KPI Cards */
    .seller-kpi-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.18);
        border-radius: 1.1rem;
        padding: 1.35rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .seller-kpi-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .seller-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.4);
    }

    .seller-kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .seller-kpi-val {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.5px;
        margin: 0.35rem 0;
        font-family: 'Outfit', sans-serif;
    }

    body.dark-mode .seller-kpi-val {
        color: #ffffff;
    }

    /* Main Workspace Panel */
    .seller-panel-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.18);
        border-radius: 1.15rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    body.dark-mode .seller-panel-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .seller-panel-toolbar {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    body.dark-mode .seller-panel-toolbar {
        background: #0d1e27;
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .seller-filter-pill-group {
        display: inline-flex;
        background: #f1f5f9;
        padding: 0.25rem;
        border-radius: 0.65rem;
        border: 1px solid #e2e8f0;
        gap: 0.25rem;
    }

    body.dark-mode .seller-filter-pill-group {
        background: #08141b;
        border-color: rgba(13, 148, 136, 0.2);
    }

    .seller-filter-pill {
        padding: 0.35rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .seller-filter-pill:hover {
        color: #0d9488;
    }

    .seller-filter-pill.active {
        background: #ffffff;
        color: #0d9488;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    body.dark-mode .seller-filter-pill.active {
        background: #0f232d;
        color: #2dd4bf;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .seller-search-box {
        position: relative;
        min-width: 240px;
    }

    .seller-search-box i {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .seller-search-input {
        width: 100%;
        padding: 0.45rem 0.85rem 0.45rem 2.25rem;
        font-size: 0.84rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.6rem;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    body.dark-mode .seller-search-input {
        background: #08141b;
        border-color: rgba(13, 148, 136, 0.25);
        color: #ffffff;
    }

    .seller-search-input:focus {
        background: #ffffff;
        border-color: #0d9488;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }

    body.dark-mode .seller-search-input:focus {
        background: #0f232d;
    }

    /* Table Styles */
    .seller-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .seller-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.95rem 1.35rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        white-space: nowrap;
    }

    body.dark-mode .seller-table thead th {
        background: #08141b;
        color: #94a3b8;
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .seller-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }

    body.dark-mode .seller-table tbody tr {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .seller-table tbody tr:hover {
        background-color: rgba(13, 148, 136, 0.03);
    }

    body.dark-mode .seller-table tbody tr:hover {
        background-color: rgba(13, 148, 136, 0.08);
    }

    .seller-table td {
        padding: 1rem 1.35rem;
        vertical-align: middle;
        font-size: 0.88rem;
    }

    .seller-item-thumb {
        width: 52px;
        height: 52px;
        border-radius: 0.75rem;
        background: #f1f5f9;
        border: 1px solid rgba(13, 148, 136, 0.15);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    body.dark-mode .seller-item-thumb {
        background: #08141b;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .seller-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .seller-item-link {
        font-weight: 800;
        color: #0f172a;
        font-size: 0.95rem;
        text-decoration: none;
        display: block;
        transition: color 0.2s ease;
        margin-bottom: 0.2rem;
    }

    body.dark-mode .seller-item-link {
        color: #ffffff;
    }

    .seller-item-link:hover {
        color: #0d9488;
    }

    body.dark-mode .seller-item-link:hover {
        color: #2dd4bf;
    }

    .seller-btn-action {
        width: 34px;
        height: 34px;
        border-radius: 0.55rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    body.dark-mode .seller-btn-action {
        background: #08141b;
        border-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }

    .seller-btn-action:hover {
        background: #0d9488;
        color: #ffffff;
        border-color: #0d9488;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
    }

    .seller-empty-box {
        padding: 4.5rem 2rem;
        text-align: center;
    }
</style>
@endsection

@section('content')

<!-- Include Modern Obsidian Seller Sidebar -->
@include('seller.sidebar')

<div class="main-content-wrapper">
    <div class="seller-dashboard-container">
        
        <!-- 1. EXECUTIVE OBSIDIAN HERO HEADER -->
        <header class="seller-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="seller-live-pulse">
                                <span class="pulse-dot"></span> Verified Seller Studio
                            </div>
                            <span style="color: #94a3b8; font-size: 0.82rem;">• E-Benta Platform</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 900; letter-spacing: -0.5px; margin: 0;">
                            <i class="fas fa-store me-2" style="color: #10b981;"></i>{{ ($isRecentView ?? false) ? 'Seller Operations Dashboard' : 'Inventory Management' }}
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            {{ ($isRecentView ?? false)
                                ? 'Monitor items listed within the last 24 hours, respond to pending offers, and oversee operations.'
                                : 'Catalog of all electronic scrap items, active offers, pricing, and fulfillment history.' }}
                        </p>
                    </div>

                    <!-- Streamlined Quick Actions -->
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="seller-view-pill-group">
                            <a href="{{ route('seller.dashboard') }}" class="seller-view-pill {{ ($isRecentView ?? false) ? 'active' : '' }}">
                                <i class="fas fa-clock"></i> Recent 24h
                            </a>
                            <a href="{{ route('seller.listings') }}" class="seller-view-pill {{ !($isRecentView ?? false) ? 'active' : '' }}">
                                <i class="fas fa-boxes-stacked"></i> All Inventory
                            </a>
                        </div>

                        <a href="{{ route('listings.create') }}" class="btn-create-listing-cta">
                            <i class="fas fa-plus-circle"></i> List New Device
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- 2. HIGH-IMPACT 4-COLUMN KPI CARDS -->
        <div class="container-fluid px-3 px-md-4 mt-4">
            <div class="row g-3 g-lg-4 mb-4">
                
                <!-- KPI 1: Active Listings & Value -->
                <div class="col-sm-6 col-lg-3">
                    <div class="seller-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">ACTIVE INVENTORY</small>
                                <div class="seller-kpi-val">{{ $statistics['active_listings'] ?? 0 }}</div>
                            </div>
                            <div class="seller-kpi-icon" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                                <i class="fas fa-boxes-stacked"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-auto" style="font-size: 0.8rem;">
                            <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 800;">
                                ₱{{ number_format($statistics['active_inventory_value'] ?? 0, 0) }}
                            </span>
                            <span style="color: #64748b;">of {{ $statistics['total_listings'] ?? 0 }} total items</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 2: Pending Offers -->
                <div class="col-sm-6 col-lg-3">
                    <div class="seller-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">PENDING OFFERS</small>
                                <div class="seller-kpi-val">{{ $statistics['pending_offers'] ?? 0 }}</div>
                            </div>
                            <div class="seller-kpi-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                                <i class="fas fa-handshake-angle"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1 mt-auto" style="font-size: 0.8rem; font-weight: 700;">
                            @if(($statistics['pending_offers'] ?? 0) > 0)
                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">
                                    <i class="fas fa-bell me-1"></i> Action Needed
                                </span>
                            @else
                                <span style="color: #10b981;"><i class="fas fa-check-circle me-1"></i> All offers reviewed</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- KPI 3: Realized Revenue -->
                <div class="col-sm-6 col-lg-3">
                    <div class="seller-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">COMPLETED SALES</small>
                                <div class="seller-kpi-val">{{ $statistics['completed_transactions'] ?? 0 }}</div>
                            </div>
                            <div class="seller-kpi-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                                <i class="fas fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-auto" style="font-size: 0.8rem;">
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800;">
                                ₱{{ number_format($statistics['total_revenue'] ?? 0, 2) }}
                            </span>
                            <span style="color: #64748b;">net payout</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 4: Environmental Impact -->
                <div class="col-sm-6 col-lg-3">
                    <div class="seller-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">E-WASTE DIVERTED</small>
                                <div class="seller-kpi-val">{{ number_format($statistics['weight_diverted'] ?? 0, 1) }} <span style="font-size: 1.05rem; font-weight: 700; color: #10b981;">kg</span></div>
                            </div>
                            <div class="seller-kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1 mt-auto" style="font-size: 0.8rem; font-weight: 700; color: #10b981;">
                            <i class="fas fa-shield-halved"></i>
                            <span>Zero-Landfill Verified</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 3. INVENTORY CATALOG & MANAGEMENT WORKSPACE -->
            <div class="seller-panel-card">
                
                <!-- Panel Toolbar -->
                <div class="seller-panel-toolbar">
                    <div class="d-flex align-items-center gap-2">
                        <h2 style="font-size: 1.1rem; font-weight: 900; margin: 0; color: inherit; letter-spacing: -0.2px;">
                            <i class="fas fa-boxes-stacked me-2" style="color: #0d9488;"></i>{{ ($isRecentView ?? false) ? 'Recent Listings' : 'All Listings Catalog' }}
                        </h2>
                        <span class="badge rounded-pill" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 800; font-size: 0.75rem;">
                            {{ $listings->total() }} Items
                        </span>
                    </div>

                    <!-- Toolbar Filters and Search -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @php
                            $currentStatus = request('status', 'all');
                            $baseUrl = ($isRecentView ?? false) ? route('seller.dashboard') : route('seller.listings');
                        @endphp
                        <div class="seller-filter-pill-group">
                            <a href="{{ $baseUrl }}?status=all{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="seller-filter-pill {{ $currentStatus === 'all' || !$currentStatus ? 'active' : '' }}">
                                All
                            </a>
                            <a href="{{ $baseUrl }}?status=available{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="seller-filter-pill {{ $currentStatus === 'available' ? 'active' : '' }}">
                                Available
                            </a>
                            <a href="{{ $baseUrl }}?status=matched{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="seller-filter-pill {{ $currentStatus === 'matched' ? 'active' : '' }}">
                                Matched
                            </a>
                            <a href="{{ $baseUrl }}?status=processed{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="seller-filter-pill {{ $currentStatus === 'processed' ? 'active' : '' }}">
                                Processed
                            </a>
                        </div>

                        <form action="{{ $baseUrl }}" method="GET" class="d-flex align-items-center m-0">
                            @if(request('status') && request('status') !== 'all')
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="seller-search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search device or model..." class="seller-search-input" autocomplete="off">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Listings Table -->
                @if($listings->count() > 0)
                    <div class="table-responsive">
                        <table class="seller-table">
                            <thead>
                                <tr>
                                    <th>Item & Specs</th>
                                    <th>Status</th>
                                    <th>Suggested Price</th>
                                    <th>Buyer Offers</th>
                                    <th>Listed Date</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listings as $listing)
                                    @php
                                        $primaryPhoto = $listing->photos[0] ?? null;
                                        $pendingOffers = $listing->offers ? $listing->offers->where('status', 'pending')->count() : 0;
                                        $totalOffers = $listing->offers ? $listing->offers->count() : 0;
                                        $categoryName = $listing->category ?: ($listing->deviceType->name ?? 'E-Waste Item');
                                        $brandName = $listing->deviceBrand->name ?? null;
                                    @endphp
                                    <tr>
                                        <!-- Item & Specs -->
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="seller-item-thumb">
                                                    @if($primaryPhoto)
                                                        <img src="{{ $primaryPhoto }}" alt="{{ $categoryName }}" loading="lazy">
                                                    @else
                                                        <i class="fas fa-laptop" style="color: #94a3b8; font-size: 1.25rem;"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('listings.show', $listing) }}" class="seller-item-link">
                                                        {{ $categoryName }}
                                                        @if($brandName)
                                                            <span style="font-weight: 500; opacity: 0.7;">• {{ $brandName }}</span>
                                                        @endif
                                                    </a>
                                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                                        <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-size: 0.7rem; font-weight: 700; text-transform: capitalize;">
                                                            {{ str_replace('_', ' ', $listing->condition) }}
                                                        </span>
                                                        @if($listing->estimated_weight)
                                                            <span style="font-size: 0.75rem; color: #94a3b8;">
                                                                <i class="fas fa-weight-scale me-1"></i>{{ number_format($listing->estimated_weight, 1) }} kg
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status Badge -->
                                        <td>
                                            @if($listing->status === 'available')
                                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 2rem;">
                                                    <i class="fas fa-circle-check me-1"></i> Available
                                                </span>
                                            @elseif($listing->status === 'matched')
                                                <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 2rem;">
                                                    <i class="fas fa-handshake me-1"></i> Matched
                                                </span>
                                            @elseif($listing->status === 'processed')
                                                <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3); font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 2rem;">
                                                    <i class="fas fa-box-archive me-1"></i> Processed
                                                </span>
                                            @else
                                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 2rem;">
                                                    <i class="fas fa-hourglass-half me-1"></i> {{ ucfirst($listing->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Suggested Price -->
                                        <td>
                                            <span style="font-weight: 900; font-size: 1rem; color: #10b981; font-family: 'Outfit', sans-serif;">
                                                ₱{{ number_format($listing->suggested_price, 2) }}
                                            </span>
                                        </td>

                                        <!-- Offers -->
                                        <td>
                                            @if($pendingOffers > 0)
                                                <a href="{{ route('listings.offers', $listing) }}" class="badge text-decoration-none" style="background: rgba(245, 158, 11, 0.18); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.4); font-weight: 800; padding: 0.4rem 0.7rem; border-radius: 0.5rem;">
                                                    <i class="fas fa-bell me-1"></i> {{ $pendingOffers }} Pending
                                                </a>
                                            @elseif($totalOffers > 0)
                                                <a href="{{ route('listings.offers', $listing) }}" class="badge text-decoration-none" style="background: rgba(255, 255, 255, 0.08); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.12); font-weight: 700; padding: 0.4rem 0.7rem; border-radius: 0.5rem;">
                                                    <i class="fas fa-comments me-1"></i> {{ $totalOffers }} Offers
                                                </a>
                                            @else
                                                <span style="color: #94a3b8; font-weight: 500;">—</span>
                                            @endif
                                        </td>

                                        <!-- Listed Date -->
                                        <td>
                                            <div style="font-weight: 700; font-size: 0.85rem;">
                                                {{ $listing->created_at->format('M d, Y') }}
                                            </div>
                                            <small style="color: #94a3b8; font-size: 0.75rem;">
                                                {{ $listing->created_at->diffForHumans() }}
                                            </small>
                                        </td>

                                        <!-- Action Buttons -->
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-1">
                                                <a href="{{ route('listings.show', $listing) }}" class="seller-btn-action" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($listing->isAvailable())
                                                    <a href="{{ route('listings.edit', $listing) }}" class="seller-btn-action" title="Edit Listing">
                                                        <i class="fas fa-pen-to-square"></i>
                                                    </a>
                                                @endif
                                                @if($totalOffers > 0)
                                                    <a href="{{ route('listings.offers', $listing) }}" class="seller-btn-action" title="Review Offers">
                                                        <i class="fas fa-handshake"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($listings->hasPages())
                        <div style="padding: 1.25rem 1.5rem; border-top: 1px solid rgba(13, 148, 136, 0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                            <div style="font-size: 0.85rem; color: #64748b;">
                                Showing {{ $listings->firstItem() }} to {{ $listings->lastItem() }} of {{ $listings->total() }} items
                            </div>
                            <div>
                                {{ $listings->links('pagination.custom') }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="seller-empty-box">
                        <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(13, 148, 136, 0.12); color: #0d9488; font-size: 1.85rem; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; border: 1px solid rgba(13, 148, 136, 0.25);">
                            <i class="fas fa-box-open"></i>
                        </div>
                        @if(request('search') || (request('status') && request('status') !== 'all'))
                            <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 0.4rem;">No Matching Listings Found</h3>
                            <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0 auto 1.5rem;">
                                We couldn't find any listings matching your search or filters. Try clearing your filters to view all devices.
                            </p>
                            <a href="{{ ($isRecentView ?? false) ? route('seller.dashboard') : route('seller.listings') }}" class="btn-create-listing-cta">
                                <i class="fas fa-rotate-left"></i> Reset Filters
                            </a>
                        @elseif($isRecentView ?? false)
                            <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 0.4rem;">No Recent Listings</h3>
                            <p style="color: #64748b; font-size: 0.9rem; max-width: 440px; margin: 0 auto 1.5rem;">
                                You haven't listed any items in the last 24 hours. Explore your complete inventory history or publish a new device.
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('seller.listings') }}" class="btn seller-btn-action" style="width: auto; padding: 0.6rem 1.25rem; font-weight: 800; font-size: 0.85rem;">
                                    <i class="fas fa-boxes-stacked me-1"></i> View All Inventory
                                </a>
                                <a href="{{ route('listings.create') }}" class="btn-create-listing-cta">
                                    <i class="fas fa-plus-circle"></i> List New Device
                                </a>
                            </div>
                        @else
                            <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 0.4rem;">Your Inventory is Empty</h3>
                            <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0 auto 1.5rem;">
                                Start monetizing your electronic scrap by listing your first device for certified recyclers and buyers.
                            </p>
                            <a href="{{ route('listings.create') }}" class="btn-create-listing-cta">
                                <i class="fas fa-plus-circle"></i> Create First Listing
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
