@extends('layouts.app')

@section('title', 'Seller Dashboard - E-Benta')

@section('content')
<style>
    /* === SELLER DASHBOARD WRAPPER === */
    .seller-dashboard-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .seller-dashboard-header {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .seller-dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .seller-dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .seller-dashboard-header-content {
        position: relative;
        z-index: 1;
    }

    .seller-dashboard-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .seller-dashboard-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === STAT CARDS === */
    .stat-card {
        background: white;
        border: 1px solid rgba(13, 148, 136, 0.1);
        border-top: 4px solid #0d9488;
        border-radius: 1.2rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.06);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .stat-card:hover {
        box-shadow: 0 12px 35px rgba(13, 148, 136, 0.15);
        transform: translateY(-5px);
    }

    .stat-card.stat-card-teal {
        border-top-color: #0d9488;
    }

    .stat-card.stat-card-cyan {
        border-top-color: #06b6d4;
    }

    .stat-card.stat-card-blue {
        border-top-color: #3b82f6;
    }

    .stat-card.stat-card-amber {
        border-top-color: #f59e0b;
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.stat-card-teal .stat-card-icon {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.08) 100%);
        color: #0d9488;
    }

    .stat-card.stat-card-cyan .stat-card-icon {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
        color: #06b6d4;
    }

    .stat-card.stat-card-blue .stat-card-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .stat-card.stat-card-amber .stat-card-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.08) 100%);
        color: #f59e0b;
    }

    .stat-card-label {
        color: #64748b;
        font-size: 0.8rem;
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card-value {
        margin: 0.75rem 0 0.5rem 0;
        font-weight: 800;
        font-size: 2rem;
        color: #1e293b;
    }

    .stat-card.stat-card-teal .stat-card-value {
        color: #0d9488;
    }

    .stat-card.stat-card-cyan .stat-card-value {
        color: #06b6d4;
    }

    .stat-card.stat-card-blue .stat-card-value {
        color: #3b82f6;
    }

    .stat-card.stat-card-amber .stat-card-value {
        color: #f59e0b;
    }

    .stat-card-description {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
        font-weight: 500;
    }

    /* === ACTION BUTTONS === */
    .action-btn {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .action-btn:hover {
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.4);
        transform: translateY(-2px);
        color: white;
    }

    /* === TABLE CARD === */
    .table-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(13, 148, 136, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-card-header {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        padding: 1.5rem;
    }

    .table-card-header h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-card-icon {
        color: #0d9488;
    }

    /* === TABLE STYLES === */
    .listing-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
    }

    .listing-table thead {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.04) 100%);
        border-bottom: 2px solid rgba(13, 148, 136, 0.15);
    }

    .listing-table th {
        color: #0d9488;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
        letter-spacing: 1px;
        border: none;
    }

    .listing-table tbody tr {
        border-bottom: 1px solid rgba(13, 148, 136, 0.08);
        transition: background 0.2s ease;
    }

    .listing-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.04);
    }

    .listing-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        color: #1e293b;
        font-size: 0.9rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    /* === STATUS BADGES === */
    .status-badge {
        display: inline-block;
        padding: 0.5rem 0.9rem;
        border-radius: 0.6rem;
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid;
    }

    .status-available {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.3);
    }

    .status-matched {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.3);
    }

    .status-processed {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
    }

    /* === ACTION BTN SMALL === */
    .action-btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        border: none;
        border-radius: 0.4rem;
        font-weight: 700;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
    }

    .action-btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.2);
    }

    .action-btn-view:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        transform: translateY(-1px);
    }

    .action-btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.2);
    }

    .action-btn-edit:hover {
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
        transform: translateY(-1px);
    }

    .action-btn-offers {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 6px rgba(13, 148, 136, 0.2);
    }

    .action-btn-offers:hover {
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.35);
        transform: translateY(-1px);
    }

    /* === EMPTY STATE === */
    .empty-state-container {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(13, 148, 136, 0.08));
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        color: rgba(13, 148, 136, 0.3);
    }

    .empty-state-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #64748b;
        margin: 0;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        padding: 1.5rem;
        border-top: 1px solid rgba(13, 148, 136, 0.1);
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        gap: 0.35rem !important;
        margin-bottom: 0 !important;
    }

    .pagination-wrapper .page-item {
        margin: 0 !important;
    }

    .pagination-wrapper .page-link {
        padding: 0.5rem 0.8rem !important;
        font-size: 0.9rem !important;
        color: #0d9488 !important;
        border: 1px solid rgba(13, 148, 136, 0.25) !important;
        border-radius: 0.5rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1.4 !important;
        background: white !important;
    }

    .pagination-wrapper .page-link:hover {
        background: rgba(13, 148, 136, 0.08) !important;
        color: #059669 !important;
        border-color: rgba(13, 148, 136, 0.4) !important;
        transform: translateY(-1px) !important;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%) !important;
        color: white !important;
        border-color: #0d9488 !important;
        box-shadow: 0 2px 6px rgba(13, 148, 136, 0.2) !important;
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1 !important;
        background: #f8fafc !important;
        border-color: rgba(13, 148, 136, 0.12) !important;
        cursor: not-allowed !important;
        opacity: 0.65 !important;
    }

    /* === DARK MODE === */
    body.dark-mode .seller-dashboard-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .seller-dashboard-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    body.dark-mode .table-card {
        background: #2a2a2a;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .stat-card {
        background: #2a2a2a;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .listing-table th {
        color: #10b981;
    }

    body.dark-mode .listing-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.1);
    }

    body.dark-mode .listing-table td {
        color: #e0e0e0;
    }

    body.dark-mode .table-card-header {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .seller-dashboard-header h1 {
            font-size: 1.75rem;
        }

        .stat-card-value {
            font-size: 1.5rem;
        }

        .listing-table {
            font-size: 0.8rem;
        }

        .listing-table th,
        .listing-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

@include('seller.sidebar')
<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="seller-dashboard-wrapper">
        <!-- Header -->
        <div class="seller-dashboard-header">
            <div class="container-fluid">
                <div class="seller-dashboard-header-content">
                    <h1>
                        <i class="fas fa-store me-2"></i>
                        {{ ($isRecentView ?? false) ? 'Dashboard' : 'My Listing' }}
                    </h1>
                    <p>
                        {{ ($isRecentView ?? false)
                            ? 'Showing listings created in the last 24 hours. Use My Listings in the sidebar to see your full listing history.'
                            : 'Showing all your listings, including older items.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">

        @if($isRecentView ?? false)
        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-teal">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Total Listings</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">{{ $statistics['total_listings'] }}</h3>
                    <p class="stat-card-description">All your e-waste items</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-cyan">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Active Listings</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">{{ $statistics['active_listings'] }}</h3>
                    <p class="stat-card-description">Currently available</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-blue">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Matched Listings</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">{{ $statistics['matched_listings'] }}</h3>
                    <p class="stat-card-description">Pending transactions</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-amber">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Completed</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">{{ $statistics['completed_transactions'] }}</h3>
                    <p class="stat-card-description">Successful sales</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Listings Table -->
        <div class="row">
            <div class="col-12">
                <div class="table-card">
                    <div class="table-card-header">
                        <h5>
                            <i class="fas fa-boxes table-card-icon"></i>
                            {{ ($isRecentView ?? false) ? 'Recent Listings (Last 24 Hours)' : 'My Listing (All Time)' }}
                        </h5>
                    </div>

                    <div style="padding: 0;">
                        @if(count($listings) > 0)
                            <div class="table-responsive">
                                <table class="listing-table">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-laptop me-1"></i>Device/Item</th>
                                            <th><i class="fas fa-flag me-1"></i>Status</th>
                                            <th><i class="fas fa-dollar-sign me-1"></i>Price</th>
                                            <th><i class="fas fa-comments me-1"></i>Offers</th>
                                            <th><i class="fas fa-calendar me-1"></i>Listed On</th>
                                            <th><i class="fas fa-cog me-1"></i>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($listings as $listing)
                                            <tr>
                                                <td>
                                                    <div style="font-weight: 600;">{{ $listing->category ?: ($listing->deviceType->name ?: 'Uncategorized') }}</div>
                                                    <small style="color: #64748b;">{{ ucfirst(str_replace('_', ' ', $listing->condition)) }} condition</small>
                                                </td>
                                                <td>
                                                    @if($listing->status === 'available')
                                                        <span class="status-badge status-available">
                                                            <i class="fas fa-check-circle me-1"></i>Available
                                                        </span>
                                                    @elseif($listing->status === 'matched')
                                                        <span class="status-badge status-matched">
                                                            <i class="fas fa-handshake me-1"></i>Matched
                                                        </span>
                                                    @elseif($listing->status === 'processed')
                                                        <span class="status-badge status-processed">
                                                            <i class="fas fa-check me-1"></i>Processed
                                                        </span>
                                                    @else
                                                        <span class="status-badge">
                                                            <i class="fas fa-ban me-1"></i>{{ ucfirst($listing->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td style="color: #0d9488; font-weight: 800; font-size: 1rem;">
                                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                                </td>
                                                <td>
                                                    @if($listing->offers()->where('status', 'pending')->count() > 0)
                                                        <span class="status-badge status-processed">
                                                            <i class="fas fa-bell me-1"></i>{{ $listing->offers()->where('status', 'pending')->count() }} pending
                                                        </span>
                                                    @else
                                                        <span style="color: #64748b;">—</span>
                                                    @endif
                                                </td>
                                                <td style="color: #64748b; font-size: 0.9rem;">
                                                    {{ $listing->created_at->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                                        <a href="{{ route('listings.show', $listing) }}" class="action-btn-small action-btn-view">
                                                            <i class="fas fa-eye"></i>View
                                                        </a>
                                                        @if($listing->isAvailable())
                                                            <a href="{{ route('listings.edit', $listing) }}" class="action-btn-small action-btn-edit">
                                                                <i class="fas fa-edit"></i>Edit
                                                            </a>
                                                        @endif
                                                        @if($listing->offers()->where('status', 'pending')->count() > 0)
                                                            <a href="{{ route('listings.offers', $listing) }}" class="action-btn-small action-btn-offers">
                                                                <i class="fas fa-handshake"></i>Offers
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
                                <div class="pagination-wrapper">
                                    {{ $listings->links('pagination.custom') }}
                                </div>
                            @endif
                        @else
                            <!-- Empty State -->
                            <div class="empty-state-container">
                                <div class="empty-state-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                @if($isRecentView ?? false)
                                    <h5 class="empty-state-title">No Recent Listings</h5>
                                    <p class="empty-state-text" style="margin-bottom: 1.5rem;">
                                        You have no listings created within the last 24 hours.
                                    </p>
                                    <a href="{{ route('seller.listings') }}" class="action-btn">
                                        <i class="fas fa-list"></i>View All My Listings
                                    </a>
                                @else
                                    <h5 class="empty-state-title">No Listings Yet</h5>
                                    <p class="empty-state-text" style="margin-bottom: 1.5rem;">
                                        Start creating listings to begin managing your e-waste items and generating environmental impact.
                                    </p>
                                    <a href="{{ route('listings.create') }}" class="action-btn">
                                        <i class="fas fa-plus-circle"></i>Create First Listing
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
