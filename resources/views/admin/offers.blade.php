@extends('layouts.app')

@section('title', 'All Offers - E-Benta Admin')

@section('content')
<style>
    /* === OFFERS WRAPPER === */
    .offers-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .offers-header {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .offers-header::before {
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

    .offers-header::after {
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

    .offers-header-content {
        position: relative;
        z-index: 1;
    }

    .offers-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .offers-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === FILTER SECTION === */
    .filter-card-offers {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(168, 85, 247, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-wrapper-offers {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group-offers {
        flex: 1;
        min-width: 250px;
    }

    .filter-label-offers {
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

    .filter-label-offers i {
        color: #a855f7;
    }

    .filter-select-offers {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(168, 85, 247, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.95rem;
    }

    .filter-select-offers:focus {
        border-color: rgba(168, 85, 247, 0.5);
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.15);
        background: white;
        outline: none;
    }

    .filter-btn-offers {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.25);
        cursor: pointer;
        white-space: nowrap;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-btn-offers:hover {
        box-shadow: 0 6px 20px rgba(168, 85, 247, 0.35);
        transform: translateY(-2px);
    }

    /* === TABLE SECTION === */
    .table-card-offers {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(168, 85, 247, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-header-offers {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(168, 85, 247, 0.05) 100%);
        border-bottom: 1px solid rgba(168, 85, 247, 0.15);
        padding: 1.5rem;
    }

    .table-header-offers h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-header-offers i {
        color: #a855f7;
    }

    .table-responsive-offers {
        overflow-x: auto;
    }

    .offers-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .offers-table thead {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.08) 0%, rgba(168, 85, 247, 0.04) 100%);
        border-bottom: 2px solid rgba(168, 85, 247, 0.15);
    }

    .offers-table thead th {
        color: #a855f7;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
    }

    .offers-table tbody tr {
        border-bottom: 1px solid rgba(168, 85, 247, 0.08);
        transition: background 0.2s ease;
    }

    .offers-table tbody tr:hover {
        background: rgba(168, 85, 247, 0.04);
    }

    .offers-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    .listing-info {
        color: #1e293b;
        font-weight: 600;
    }

    .listing-condition {
        color: #64748b;
        font-weight: 400;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .buyer-info,
    .seller-info-offers {
        color: #1e293b;
    }

    .buyer-name,
    .seller-name-offers {
        font-weight: 700;
        display: block;
    }

    .buyer-email,
    .seller-email-offers {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.3rem;
        display: block;
    }

    .status-badge-offers {
        padding: 0.5rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        display: inline-block;
        font-weight: 700;
        border: 1px solid;
    }

    .status-pending-offers {
        background: rgba(249, 115, 22, 0.15);
        color: #f97316;
        border-color: rgba(249, 115, 22, 0.2);
    }

    .status-accepted-offers {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.2);
    }

    .status-rejected-offers {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .status-picked-up-offers {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .status-completed-offers {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border-color: rgba(168, 85, 247, 0.2);
    }

    .price-value-offers {
        color: #a855f7;
        font-weight: 700;
        font-size: 1rem;
    }

    .date-value-offers {
        color: #64748b;
        font-size: 0.9rem;
    }

    .date-meta-offers {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }

    /* === PAGINATION === */
    .pagination-wrapper-offers {
        padding: 1.5rem;
        border-top: 1px solid rgba(168, 85, 247, 0.1);
        display: flex;
        justify-content: center;
    }

    /* === EMPTY STATE === */
    .empty-state-offers {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-icon-offers {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(168, 85, 247, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: #a855f7;
    }

    .empty-title-offers {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .empty-message-offers {
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .empty-link-offers {
        color: #a855f7;
        text-decoration: none;
        font-weight: 700;
    }

    .empty-link-offers:hover {
        text-decoration: underline;
    }

    /* === DARK MODE === */
    body.dark-mode .offers-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .filter-card-offers,
    body.dark-mode .table-card-offers {
        background: #2a2a2a;
        border-color: rgba(168, 85, 247, 0.2);
    }

    body.dark-mode .filter-label-offers,
    body.dark-mode .table-header-offers h5,
    body.dark-mode .listing-info,
    body.dark-mode .buyer-info,
    body.dark-mode .seller-info-offers,
    body.dark-mode .empty-title-offers,
    body.dark-mode .offers-table td {
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-offers {
        background: #333333;
        border-color: rgba(168, 85, 247, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-offers:focus {
        background: #3a3a3a;
    }

    body.dark-mode .offers-table thead {
        background: rgba(168, 85, 247, 0.1);
    }

    body.dark-mode .offers-table tbody tr:hover {
        background: rgba(168, 85, 247, 0.08);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .offers-header h1 {
            font-size: 1.8rem;
        }

        .filter-wrapper-offers {
            flex-direction: column;
        }

        .filter-group-offers,
        .filter-btn-offers {
            width: 100%;
        }

        .offers-table {
            font-size: 0.85rem;
        }

        .offers-table td {
            padding: 0.85rem 0.5rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="offers-wrapper">
        <!-- Header -->
        <div class="offers-header">
            <div class="container-fluid">
                <div class="offers-header-content">
                    <h1><i class="fas fa-handshake me-2"></i>All Offers</h1>
                    <p>Monitor and manage buyer offers ({{ $offers->total() }} total)</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">
            <!-- Filter Section -->
            <div class="filter-card-offers">
                <form method="GET" action="{{ route('admin.offers') }}" class="filter-wrapper-offers">
                    <div class="filter-group-offers">
                        <label class="filter-label-offers">
                            <i class="fas fa-filter"></i>Filter by Status
                        </label>
                        <select name="status" class="filter-select-offers">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="filter-btn-offers">
                        <i class="fas fa-search"></i>Filter
                    </button>
                </form>
            </div>

            <!-- Offers Table -->
            <div class="table-card-offers">
                <div class="table-header-offers">
                    <h5><i class="fas fa-comments"></i>Offers Overview</h5>
                </div>
                <div class="table-responsive-offers">
                    @if($offers->count() > 0)
                        <table class="offers-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-laptop me-1"></i>Listing</th>
                                    <th><i class="fas fa-user me-1"></i>Buyer</th>
                                    <th><i class="fas fa-handshake me-1"></i>Seller</th>
                                    <th><i class="fas fa-flag me-1"></i>Status</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Offered Price</th>
                                    <th><i class="fas fa-calendar me-1"></i>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $offer)
                                    <tr>
                                        <!-- Listing -->
                                        <td>
                                            <div class="listing-info">{{ $offer->listing->category }}</div>
                                            <div class="listing-condition">{{ ucfirst($offer->listing->condition) }}</div>
                                        </td>

                                        <!-- Buyer -->
                                        <td>
                                            <div class="buyer-info">
                                                <span class="buyer-name">{{ $offer->buyer->name }}</span>
                                                <span class="buyer-email">{{ $offer->buyer->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Seller -->
                                        <td>
                                            <div class="seller-info-offers">
                                                <span class="seller-name-offers">{{ $offer->listing->seller->name }}</span>
                                                <span class="seller-email-offers">{{ $offer->listing->seller->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($offer->status === 'pending')
                                                <span class="status-badge-offers status-pending-offers">
                                                    <i class="fas fa-hourglass-half me-1"></i>Pending
                                                </span>
                                            @elseif($offer->status === 'accepted')
                                                <span class="status-badge-offers status-accepted-offers">
                                                    <i class="fas fa-check-circle me-1"></i>Accepted
                                                </span>
                                            @elseif($offer->status === 'rejected')
                                                <span class="status-badge-offers status-rejected-offers">
                                                    <i class="fas fa-times-circle me-1"></i>Rejected
                                                </span>
                                            @elseif($offer->status === 'picked_up')
                                                <span class="status-badge-offers status-picked-up-offers">
                                                    <i class="fas fa-truck me-1"></i>Picked Up
                                                </span>
                                            @elseif($offer->status === 'completed')
                                                <span class="status-badge-offers status-completed-offers">
                                                    <i class="fas fa-certificate me-1"></i>Completed
                                                </span>
                                            @else
                                                <span class="status-badge-offers" style="background: rgba(203, 213, 225, 0.15); color: #64748b; border-color: rgba(203, 213, 225, 0.2);">
                                                    <i class="fas fa-ban me-1"></i>{{ ucfirst(str_replace('_', ' ', $offer->status)) }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Offered Price -->
                                        <td>
                                            <span class="price-value-offers">
                                                @if($offer->bid_amount > 0)
                                                    ₱{{ number_format($offer->bid_amount, 2) }}
                                                @else
                                                    Free
                                                @endif
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <div class="date-value-offers">{{ $offer->created_at->format('M d, Y') }}</div>
                                            <span class="date-meta-offers">{{ $offer->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper-offers">
                            {{ $offers->links() }}
                        </div>
                    @else
                        <div class="empty-state-offers">
                            <div class="empty-icon-offers">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5 class="empty-title-offers">No Offers Found</h5>
                            <p class="empty-message-offers">
                                @if(request('status'))
                                    No offers found with the selected status. <a href="{{ route('admin.offers') }}" class="empty-link-offers">Clear filters</a>
                                @else
                                    There are currently no offers in the system.
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
