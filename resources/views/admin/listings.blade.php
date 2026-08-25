@extends('layouts.app')

@section('title', 'All Listings - E-Benta Admin')

@section('content')
<style>
    /* === LISTINGS WRAPPER === */
    .listings-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .listings-header {
        background: linear-gradient(135deg, #3b82f6 0%, #0891b2 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .listings-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    .listings-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        z-index: 0;
    }

    .listings-header-content {
        position: relative;
        z-index: 1;
    }

    .listings-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .listings-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === FILTER SECTION === */
    .filter-card {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(59, 130, 246, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-wrapper {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 250px;
    }

    .filter-label {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .filter-label i {
        color: #3b82f6;
    }

    .filter-select {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.95rem;
    }

    .filter-select:focus {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.15);
        background: white;
        outline: none;
    }

    .filter-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #0891b2 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        cursor: pointer;
        white-space: nowrap;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-btn:hover {
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    /* === TABLE SECTION === */
    .table-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(59, 130, 246, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border-bottom: 1px solid rgba(59, 130, 246, 0.15);
        padding: 1.5rem;
    }

    .table-header h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-header i {
        color: #3b82f6;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .listings-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .listings-table thead {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.04) 100%);
        border-bottom: 2px solid rgba(59, 130, 246, 0.15);
    }

    .listings-table thead th {
        color: #3b82f6;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
    }

    .listings-table tbody tr {
        border-bottom: 1px solid rgba(59, 130, 246, 0.08);
        transition: background 0.2s ease;
    }

    .listings-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.04);
    }

    .listings-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    .device-info {
        color: #1e293b;
        font-weight: 600;
    }

    .device-condition {
        color: #64748b;
        font-weight: 400;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .seller-info {
        color: #1e293b;
    }

    .seller-name {
        font-weight: 700;
        display: block;
    }

    .seller-email {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.3rem;
        display: block;
    }

    .status-badge {
        padding: 0.5rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        display: inline-block;
        font-weight: 700;
        border: 1px solid;
    }

    .status-available {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.2);
    }

    .status-matched {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .status-processed {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border-color: rgba(168, 85, 247, 0.2);
    }

    .status-other {
        background: rgba(203, 213, 225, 0.15);
        color: #64748b;
        border-color: rgba(203, 213, 225, 0.2);
    }

    .price-value {
        color: #3b82f6;
        font-weight: 700;
        font-size: 1rem;
    }

    .offers-container {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .offer-badge {
        padding: 0.4rem 0.7rem;
        border-radius: 0.3rem;
        font-size: 0.8rem;
        display: inline-block;
        font-weight: 700;
        border: 1px solid;
        white-space: nowrap;
    }

    .offer-pending {
        background: rgba(249, 115, 22, 0.15);
        color: #f97316;
        border-color: rgba(249, 115, 22, 0.15);
    }

    .offer-accepted {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.15);
    }

    .offer-completed {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.15);
    }

    .impact-value {
        color: #3b82f6;
        font-weight: 600;
    }

    .date-value {
        color: #64748b;
        font-size: 0.9rem;
    }

    .date-meta {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        padding: 1.5rem;
        border-top: 1px solid rgba(59, 130, 246, 0.1);
        display: flex;
        justify-content: center;
    }

    /* === EMPTY STATE === */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: #3b82f6;
    }

    .empty-title {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .empty-message {
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .empty-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
    }

    .empty-link:hover {
        text-decoration: underline;
    }

    /* === DARK MODE === */
    body.dark-mode .listings-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .filter-card,
    body.dark-mode .table-card {
        background: #2a2a2a;
        border-color: rgba(59, 130, 246, 0.2);
    }

    body.dark-mode .filter-label,
    body.dark-mode .table-header h5,
    body.dark-mode .device-info,
    body.dark-mode .seller-info,
    body.dark-mode .empty-title,
    body.dark-mode .listings-table td {
        color: #e0e0e0;
    }

    body.dark-mode .filter-select {
        background: #333333;
        border-color: rgba(59, 130, 246, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select:focus {
        background: #3a3a3a;
    }

    body.dark-mode .listings-table thead {
        background: rgba(59, 130, 246, 0.1);
    }

    body.dark-mode .listings-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.08);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .listings-header h1 {
            font-size: 1.8rem;
        }

        .filter-wrapper {
            flex-direction: column;
        }

        .filter-group,
        .filter-btn {
            width: 100%;
        }

        .listings-table {
            font-size: 0.85rem;
        }

        .listings-table td {
            padding: 0.85rem 0.5rem;
        }

        .offers-container {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="listings-wrapper">
        <!-- Header -->
        <div class="listings-header">
            <div class="container-fluid">
                <div class="listings-header-content">
                    <h1><i class="fas fa-list me-2"></i>All Listings</h1>
                    <p>Monitor and manage marketplace listings ({{ $listings->total() }} total)</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">
            <!-- Filter Section -->
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.listings') }}" class="filter-wrapper">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-filter"></i>Filter by Status
                        </label>
                        <select name="status" class="filter-select">
                            <option value="">All Statuses</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="matched" {{ request('status') == 'matched' ? 'selected' : '' }}>Matched</option>
                            <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search"></i>Filter
                    </button>
                </form>
            </div>

            <!-- Listings Table -->
            <div class="table-card">
                <div class="table-header">
                    <h5><i class="fas fa-boxes"></i>Listings Overview</h5>
                </div>
                <div class="table-responsive">
                    @if($listings->count() > 0)
                        <table class="listings-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-laptop me-1"></i>Device</th>
                                    <th><i class="fas fa-user me-1"></i>Seller</th>
                                    <th><i class="fas fa-flag me-1"></i>Status</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Price</th>
                                    <th><i class="fas fa-comments me-1"></i>Offers</th>
                                    <th><i class="fas fa-leaf me-1"></i>Impact</th>
                                    <th><i class="fas fa-calendar me-1"></i>Listed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listings as $listing)
                                    <tr>
                                        <td>
                                            <div class="device-info">{{ $listing->category ?: ($listing->deviceType ? $listing->deviceType->name : 'Uncategorized') }}</div>
                                            <div class="device-condition">{{ ucfirst($listing->condition) }}</div>
                                        </td>
                                        <td>
                                            <div class="seller-info">
                                                <span class="seller-name">{{ $listing->seller->name }}</span>
                                                <span class="seller-email">{{ $listing->seller->email }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($listing->status === 'available')
                                                <span class="status-badge status-available">
                                                    <i class="fas fa-circle-check me-1"></i>Available
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
                                                <span class="status-badge status-other">
                                                    <i class="fas fa-ban me-1"></i>{{ ucfirst($listing->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="price-value">
                                                @if($listing->suggested_price > 0)
                                                    ₱{{ $listing->suggested_price }}
                                                @else
                                                    Free
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $pendingOffers = $listing->offers()->where('status', 'pending')->count();
                                                $acceptedOffers = $listing->offers()->where('status', 'accepted')->count();
                                                $completedOffers = $listing->offers()->where('status', 'completed')->count();
                                            @endphp
                                            <div class="offers-container">
                                                @if($pendingOffers > 0)
                                                    <span class="offer-badge offer-pending">
                                                        <i class="fas fa-bell me-1"></i>{{ $pendingOffers }} pending
                                                    </span>
                                                @endif
                                                @if($acceptedOffers > 0)
                                                    <span class="offer-badge offer-accepted">
                                                        <i class="fas fa-check-circle me-1"></i>{{ $acceptedOffers }} accepted
                                                    </span>
                                                @endif
                                                @if($completedOffers > 0)
                                                    <span class="offer-badge offer-completed">
                                                        <i class="fas fa-trophy me-1"></i>{{ $completedOffers }} completed
                                                    </span>
                                                @endif
                                                @if($pendingOffers == 0 && $acceptedOffers == 0 && $completedOffers == 0)
                                                    <span style="color: #cbd5e1;">—</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="impact-value">{{ $listing->carbon_footprint }} kg CO₂</span>
                                        </td>
                                        <td>
                                            <div class="date-value">{{ $listing->created_at->format('M d, Y') }}</div>
                                            <span class="date-meta">{{ $listing->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper">
                            {{ $listings->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5 class="empty-title">No Listings Found</h5>
                            <p class="empty-message">
                                @if(request('status'))
                                    No listings found with the selected status. <a href="{{ route('admin.listings') }}" class="empty-link">Clear filters</a>
                                @else
                                    There are currently no listings in the system.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
