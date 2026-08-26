@extends('layouts.app')

@section('title', 'Transaction History - Seller - E-Benta')

@section('content')
<style>
    /* === TRANSACTION HISTORY WRAPPER === */
    .th-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .th-header {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .th-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .th-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .th-header-content {
        position: relative;
        z-index: 1;
    }

    .th-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .th-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === FILTER SECTION === */
    .th-filter-wrapper {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .th-filter-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .th-filter-group {
        flex: 1;
        min-width: 200px;
    }

    .th-filter-group label {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .th-filter-group select {
        background: rgba(13, 148, 136, 0.1);
        border: 1px solid rgba(13, 148, 136, 0.3);
        color: #1e293b;
        padding: 0.75rem;
        border-radius: 0.6rem;
        width: 100%;
        font-weight: 500;
    }

    .th-filter-btn {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
        cursor: pointer;
    }

    .th-filter-btn:hover {
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.35);
        transform: translateY(-2px);
    }

    .th-clear-btn {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        border: 1px solid rgba(13, 148, 136, 0.3);
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .th-clear-btn:hover {
        background: rgba(13, 148, 136, 0.25);
    }

    /* === STAT CARDS === */
    .th-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.75rem;
        margin-bottom: 2rem;
    }

    .th-stat-card {
        background: white;
        border: 1px solid rgba(13, 148, 136, 0.1);
        border-top: 4px solid #0d9488;
        border-radius: 1.2rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.06);
        transition: all 0.3s ease;
    }

    .th-stat-card:hover {
        box-shadow: 0 12px 35px rgba(13, 148, 136, 0.15);
        transform: translateY(-5px);
    }

    .th-stat-card.stat-sold {
        border-top-color: #0d9488;
    }

    .th-stat-card.stat-pending {
        border-top-color: #f59e0b;
    }

    .th-stat-card.stat-weight {
        border-top-color: #9b59b6;
    }

    .th-stat-card.stat-co2 {
        border-top-color: #06b6d4;
    }

    .th-stat-label {
        color: #64748b;
        font-size: 0.8rem;
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 0.75rem;
    }

    .th-stat-value {
        margin: 0;
        font-weight: 800;
        font-size: 2rem;
        color: #1e293b;
    }

    .th-stat-card.stat-sold .th-stat-value {
        color: #0d9488;
    }

    .th-stat-card.stat-pending .th-stat-value {
        color: #f39c12;
    }

    .th-stat-card.stat-weight .th-stat-value {
        color: #9b59b6;
    }

    .th-stat-card.stat-co2 .th-stat-value {
        color: #06b6d4;
    }

    /* === TRANSACTION CARD === */
    .th-transaction-card {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.02) 100%);
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .th-transaction-card:hover {
        box-shadow: 0 12px 35px rgba(13, 148, 136, 0.15);
        border-color: rgba(13, 148, 136, 0.3);
    }

    .th-tx-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: start;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.1);
    }

    .th-tx-title {
        color: #1e293b;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        font-size: 1.3rem;
    }

    .th-tx-info {
        color: #64748b;
        font-size: 0.9rem;
        display: block;
        margin-top: 0.25rem;
    }

    .th-tx-badge {
        display: inline-block;
        padding: 0.6rem 1rem;
        border-radius: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        border: 1px solid;
    }

    .th-tx-badge.status-pending {
        background: rgba(243, 156, 18, 0.2);
        color: #f39c12;
        border-color: rgba(243, 156, 18, 0.3);
    }

    .th-tx-badge.status-accepted {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
        border-color: rgba(52, 152, 219, 0.3);
    }

    .th-tx-badge.status-rejected {
        background: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
        border-color: rgba(231, 76, 60, 0.3);
    }

    .th-tx-badge.status-completed {
        background: rgba(13, 148, 136, 0.2);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.3);
    }

    /* === DETAILS GRID === */
    .th-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .th-detail-box {
        padding: 1rem;
        border-radius: 0.8rem;
        border-left: 3px solid;
    }

    .th-detail-box.bid-amount {
        background: rgba(243, 156, 18, 0.1);
        border-left-color: #f39c12;
    }

    .th-detail-box.method {
        background: rgba(155, 89, 182, 0.1);
        border-left-color: #9b59b6;
    }

    .th-detail-box.condition {
        background: rgba(52, 152, 219, 0.1);
        border-left-color: #3498db;
    }

    .th-detail-box.price {
        background: rgba(13, 148, 136, 0.1);
        border-left-color: #0d9488;
    }

    .th-detail-label {
        color: #a4b8b5;
        font-weight: 700;
        text-transform: uppercase;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
    }

    .th-detail-value {
        color: #1e293b;
        font-weight: 800;
        margin: 0;
        font-size: 1.1rem;
    }

    .th-detail-box.bid-amount .th-detail-value {
        color: #f39c12;
    }

    .th-detail-box.method .th-detail-value {
        color: #9b59b6;
    }

    .th-detail-box.condition .th-detail-value {
        color: #3498db;
    }

    .th-detail-box.price .th-detail-value {
        color: #0d9488;
    }

    /* === IMPACT BOX === */
    .th-impact-box {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%);
        border: 1px solid rgba(13, 148, 136, 0.2);
        padding: 1.5rem;
        border-radius: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .th-impact-title {
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .th-impact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .th-impact-item {
        text-align: center;
    }

    .th-impact-item small {
        color: #a4b8b5;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
    }

    .th-impact-item h4 {
        color: #1e293b;
        font-weight: 800;
        margin: 0;
        font-size: 1.2rem;
    }

    /* === ACTION BUTTONS === */
    .th-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .th-action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.6rem;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .th-action-view {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }

    .th-action-view:hover {
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.35);
        transform: translateY(-2px);
    }

    .th-action-accept {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    }

    .th-action-accept:hover {
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.35);
        transform: translateY(-2px);
    }

    .th-action-reject {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
    }

    .th-action-reject:hover {
        box-shadow: 0 8px 20px rgba(231, 76, 60, 0.35);
        transform: translateY(-2px);
    }

    /* === EMPTY STATE === */
    .th-empty-state {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.05) 100%);
        border: 1px solid rgba(13, 148, 136, 0.2);
        border-left: 4px solid #0d9488;
        color: #1e293b;
        padding: 3rem 2rem;
        border-radius: 1rem;
        text-align: center;
    }

    .th-empty-icon {
        font-size: 3rem;
        color: #0d9488;
        margin-bottom: 1rem;
        display: block;
        opacity: 0.7;
    }

    .th-empty-title {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }

    .th-empty-text {
        color: #64748b;
        margin: 0 0 1.5rem 0;
    }

    .th-empty-btn {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.6rem;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .th-empty-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }

    /* === PAGINATION === */
    .th-pagination-wrapper {
        margin-top: 2rem;
        text-align: center;
    }

    .th-pagination-wrapper .pagination {
        gap: 0.35rem !important;
        margin-bottom: 0 !important;
        justify-content: center;
    }

    .th-pagination-wrapper .page-item {
        margin: 0 !important;
    }

    .th-pagination-wrapper .page-link {
        padding: 0.5rem 0.8rem !important;
        font-size: 0.9rem !important;
        color: #0d9488 !important;
        border: 1px solid rgba(13, 148, 136, 0.25) !important;
        border-radius: 0.5rem !important;
        transition: all 0.2s ease !important;
        background: white !important;
    }

    .th-pagination-wrapper .page-link:hover {
        background: rgba(13, 148, 136, 0.08) !important;
        color: #059669 !important;
        border-color: rgba(13, 148, 136, 0.4) !important;
        transform: translateY(-1px) !important;
    }

    .th-pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%) !important;
        color: white !important;
        border-color: #0d9488 !important;
        box-shadow: 0 2px 6px rgba(13, 148, 136, 0.2) !important;
    }

    .th-pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1 !important;
        background: #f8fafc !important;
        border-color: rgba(13, 148, 136, 0.12) !important;
        cursor: not-allowed !important;
        opacity: 0.65 !important;
    }

    /* === DARK MODE === */
    body.dark-mode .th-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .th-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    body.dark-mode .th-stat-card {
        background: #2a2a2a;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .th-transaction-card {
        background: rgba(42, 42, 42, 0.5);
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .th-detail-box {
        background: rgba(13, 148, 136, 0.1) !important;
    }

    body.dark-mode .th-tx-title {
        color: #e0e0e0;
    }

    body.dark-mode .th-tx-info {
        color: #a0a0a0;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .th-header h1 {
            font-size: 1.75rem;
        }

        .th-stat-value {
            font-size: 1.5rem;
        }

        .th-tx-header {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .th-filter-form {
            flex-direction: column;
        }

        .th-filter-group {
            width: 100%;
        }

        .th-details-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .th-wrapper {
            padding: 1rem 0.5rem;
        }

        .th-header h1 {
            font-size: 1.45rem;
        }

        .th-stat-card {
            padding: 1.25rem 1rem;
            border-radius: 1rem;
        }

        .th-tx-card {
            padding: 1.25rem 1rem;
            border-radius: 1rem;
        }
    }
</style>

@include('seller.sidebar')
<div class="main-content-wrapper">
    <div class="th-wrapper">
        <!-- Header -->
        <div class="th-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="th-header-content">
                    <h1><i class="fas fa-history me-2"></i>Sales History</h1>
                    <p>Track your offers received, completed sales, and environmental contributions</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-3 px-md-4">
        <!-- Filter Section -->
        <div class="th-filter-wrapper">
            <form method="GET" action="{{ route('seller.transaction-history') }}" class="th-filter-form">
                <div class="th-filter-group">
                    <label><i class="fas fa-filter me-2" style="color: #0d9488;"></i>Filter by Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Offers</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <button type="submit" class="th-filter-btn">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                @if(request('status'))
                    <a href="{{ route('seller.transaction-history') }}" class="th-clear-btn">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Summary Stats -->
        <div class="th-stats-grid">
            <div class="th-stat-card stat-sold">
                <small class="th-stat-label"><i class="fas fa-check-circle me-2" style="color: #0d9488;"></i>Total Sold</small>
                <h3 class="th-stat-value">{{ $offers->where('status', 'completed')->count() }}</h3>
            </div>
            <div class="th-stat-card stat-pending">
                <small class="th-stat-label"><i class="fas fa-hourglass-half me-2" style="color: #f59e0b;"></i>Pending Offers</small>
                <h3 class="th-stat-value">{{ $offers->where('status', 'pending')->count() }}</h3>
            </div>
            <div class="th-stat-card stat-weight">
                <small class="th-stat-label"><i class="fas fa-weight me-2" style="color: #9b59b6;"></i>Weight Processed</small>
                <h3 class="th-stat-value">{{ number_format(auth()->user()->total_weight_diverted ?? 0) }} <span style="font-size: 0.6em;">kg</span></h3>
            </div>
            <div class="th-stat-card stat-co2">
                <small class="th-stat-label"><i class="fas fa-leaf me-2" style="color: #06b6d4;"></i>CO₂ Diverted</small>
                <h3 class="th-stat-value">{{ number_format(auth()->user()->total_co2_saved ?? 0) }} <span style="font-size: 0.6em;">kg</span></h3>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="row">
            <div class="col-12">
            @if($offers->count() > 0)
                @foreach($offers as $offer)
                    <div class="th-transaction-card">
                        <!-- Header with Item and Status -->
                        <div class="th-tx-header">
                            <div>
                                <h4 class="th-tx-title">
                                    {{ $offer->listing->category ?: ($offer->listing->deviceType->name ?: 'Device') }}
                                </h4>
                                <small class="th-tx-info">
                                    <i class="fas fa-user me-1" style="color: #0d9488;"></i>Buyer: <strong>{{ $offer->buyer->name }}</strong>
                                </small>
                                <small class="th-tx-info">
                                    <i class="fas fa-calendar me-1" style="color: #0d9488;"></i>Offer Date: <strong>{{ $offer->created_at->format('M d, Y') }}</strong>
                                </small>
                            </div>
                            <div style="text-align: right;">
                                @php
                                    $statusClass = match($offer->status) {
                                        'pending' => 'status-pending',
                                        'accepted' => 'status-accepted',
                                        'rejected' => 'status-rejected',
                                        'completed' => 'status-completed',
                                        default => 'status-pending'
                                    };
                                    $statusText = ucfirst($offer->status);
                                @endphp
                                <span class="th-tx-badge {{ $statusClass }}">
                                    <i class="fas fa-circle-notch me-1"></i>{{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="th-details-grid">
                            <div class="th-detail-box bid-amount">
                                <small class="th-detail-label"><i class="fas fa-dollar-sign me-1"></i>Buyer Bid</small>
                                <h5 class="th-detail-value">₱{{ number_format($offer->bid_amount, 2) }}</h5>
                            </div>
                            <div class="th-detail-box method">
                                <small class="th-detail-label"><i class="fas fa-cogs me-1"></i>Processing Method</small>
                                <h5 class="th-detail-value">{{ ucfirst(str_replace('_', ' ', $offer->proposed_method)) }}</h5>
                            </div>
                            <div class="th-detail-box condition">
                                <small class="th-detail-label"><i class="fas fa-info-circle me-1"></i>Condition</small>
                                <h5 class="th-detail-value">{{ ucfirst(str_replace('_', ' ', $offer->listing->condition)) }}</h5>
                            </div>
                            <div class="th-detail-box price">
                                <small class="th-detail-label"><i class="fas fa-tag me-1"></i>Price Listed</small>
                                <h5 class="th-detail-value">₱{{ number_format($offer->listing->suggested_price, 2) }}</h5>
                            </div>
                        </div>

                        <!-- Impact Log if Completed -->
                        @if($offer->status === 'completed' && $offer->listing->impactLog)
                            @php
                                $impact = $offer->listing->impactLog->first();
                            @endphp
                            @if($impact)
                            <div class="th-impact-box">
                                <h5 class="th-impact-title">
                                    <i class="fas fa-trophy" style="color: #0d9488;"></i>Your Impact
                                </h5>
                                <div class="th-impact-grid">
                                    <div class="th-impact-item">
                                        <small>CO₂ Diverted</small>
                                        <h4 style="color: #0d9488;">{{ $impact->co2_saved }} kg</h4>
                                    </div>
                                    <div class="th-impact-item">
                                        <small>Weight Diverted</small>
                                        <h4 style="color: #3498db;">{{ $impact->weight_diverted }} kg</h4>
                                    </div>
                                    <div class="th-impact-item">
                                        <small>Processing Method</small>
                                        <h4 style="color: #f39c12;">{{ ucfirst($impact->processing_method) }}</h4>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif

                        <!-- Action Buttons -->
                        <div class="th-actions">
                            <a href="{{ route('offers.show', $offer) }}" class="th-action-btn th-action-view">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                            @if($offer->status === 'pending' && $offer->listing->status === 'available')
                                <form method="POST" action="{{ route('offers.accept', $offer) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="th-action-btn th-action-accept">
                                        <i class="fas fa-check me-2"></i>Accept
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('offers.reject', $offer) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="th-action-btn th-action-reject">
                                        <i class="fas fa-times me-2"></i>Reject
                                    </button>
                                </form>
                            @elseif($offer->listing->status === 'withdrawn')
                                <span class="badge" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); padding: 0.5rem 0.8rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700;">
                                    <i class="fas fa-ban me-1"></i>Item Withdrawn
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($offers->hasPages())
                    <div class="th-pagination-wrapper">
                        {{ $offers->links() }}
                    </div>
                @endif
            @else
                <div class="th-empty-state">
                    <i class="fas fa-inbox th-empty-icon"></i>
                    <h3 class="th-empty-title">No Offers Received Yet</h3>
                    <p class="th-empty-text">
                        Create new listings to receive offers from buyers interested in your e-waste.
                    </p>
                    <a href="{{ route('listings.create') }}" class="th-empty-btn">
                        <i class="fas fa-plus me-2"></i>Create Listing
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</div>

@endsection
