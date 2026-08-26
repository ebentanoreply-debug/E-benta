@extends('layouts.app')

@section('title', 'Transaction History - Buyer - E-Benta')

@section('content')
<style>
    /* === TRANSACTION HISTORY WRAPPER === */
    .th-wrapper {
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 30%, #f0f9ff 70%, #f5f3ff 100%);
        min-height: 100vh;
        padding: 0;
        position: relative;
    }

    .th-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse 800px 600px at 15% 25%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse 600px 500px at 85% 75%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    /* === HEADER === */
    .th-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
        color: white;
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid rgba(255, 255, 255, 0.2);
    }

    .th-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -15%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .th-header::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite 1s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(20px); }
    }

    .th-header-content {
        position: relative;
        z-index: 1;
    }

    .th-header h1 {
        font-size: 2.8rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .th-header p {
        opacity: 0.98;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* === FILTER SECTION === */
    .th-filter {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.15);
        padding: 1.5rem;
        border-radius: 1.2rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);
        margin-bottom: 2rem;
    }

    .th-filter form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .th-filter-group {
        flex: 1;
        min-width: 200px;
    }

    .th-filter label {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .th-filter select {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #1e293b;
        padding: 0.75rem;
        border-radius: 0.6rem;
        width: 100%;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .th-filter select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .th-filter-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        cursor: pointer;
    }

    .th-filter-btn:hover {
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    .th-clear-btn {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .th-clear-btn:hover {
        background: rgba(59, 130, 246, 0.25);
    }

    /* === STATS GRID === */
    .th-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .th-stat-card {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-top: 5px solid #3b82f6;
        padding: 1.75rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);
        transition: all 0.3s ease;
    }

    .th-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
    }

    .th-stat-label {
        color: #4b5563;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
        display: block;
        margin-bottom: 0.75rem;
    }

    .th-stat-value {
        color: #3b82f6;
        font-weight: 900;
        font-size: 2.2rem;
        margin: 0;
    }

    .th-stat-card.completed .th-stat-value { color: #10b981; border-top-color: #10b981; }
    .th-stat-card.completed { border-top-color: #10b981; }
    .th-stat-card.weight .th-stat-value { color: #f59e0b; }
    .th-stat-card.weight { border-top-color: #f59e0b; }
    .th-stat-card.carbon .th-stat-value { color: #06b6d4; }
    .th-stat-card.carbon { border-top-color: #06b6d4; }

    /* === TRANSACTION CARD === */
    .th-transaction {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-radius: 1.2rem;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);
        transition: all 0.3s ease;
    }

    .th-transaction:hover {
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .th-transaction-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: start;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .th-transaction-title {
        color: #1e293b;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        font-size: 1.3rem;
    }

    .th-transaction-meta {
        color: #4b5563;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    .th-status-badge {
        font-weight: 800;
        padding: 0.6rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        border: 1px solid;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .th-status-pending { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border-color: rgba(245, 158, 11, 0.3); }
    .th-status-accepted { background: rgba(59, 130, 246, 0.15); color: #3b82f6; border-color: rgba(59, 130, 246, 0.3); }
    .th-status-rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; border-color: rgba(239, 68, 68, 0.3); }
    .th-status-cancelled { background: rgba(107, 114, 128, 0.15); color: #6b7280; border-color: rgba(107, 114, 128, 0.3); }
    .th-status-completed { background: rgba(16, 185, 129, 0.15); color: #10b981; border-color: rgba(16, 185, 129, 0.3); }

    /* === DETAILS GRID === */
    .th-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .th-detail-item {
        padding: 1rem;
        border-radius: 0.8rem;
        border-left: 3px solid #3b82f6;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.02) 100%);
    }

    .th-detail-label {
        color: #4b5563;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        display: block;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .th-detail-value {
        color: #3b82f6;
        font-weight: 800;
        margin: 0;
        font-size: 1.2rem;
    }

    /* === IMPACT BOX === */
    .th-impact {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 1.5rem;
        border-radius: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .th-impact h5 {
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

    .th-impact-label {
        color: #4b5563;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }

    .th-impact-value {
        color: #10b981;
        font-weight: 800;
        margin: 0;
        font-size: 1.3rem;
    }

    /* === ACTION BUTTONS === */
    .th-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .th-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.6rem;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .th-btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .th-btn-primary:hover {
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    .th-btn-success {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }

    .th-btn-success:hover {
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
        transform: translateY(-2px);
    }

    /* === EMPTY STATE === */
    .th-empty {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-left: 4px solid #3b82f6;
        padding: 3rem 2rem;
        border-radius: 1.2rem;
        text-align: center;
    }

    .th-empty-icon {
        font-size: 3rem;
        color: #3b82f6;
        margin-bottom: 1rem;
        display: block;
        opacity: 0.7;
    }

    .th-empty h3 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .th-empty p {
        color: #4b5563;
        margin: 0 0 1.5rem 0;
    }

    .th-empty-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
    }

    /* === PAGINATION === */
    .pagination {
        margin-top: 2rem;
        gap: 0.5rem;
    }

    .pagination .page-link {
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }

    .pagination .page-item.active .page-link {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .th-header h1 {
            font-size: 2rem;
        }

        .th-container {
            padding: 1.5rem;
        }

        .th-transaction-header {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .th-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .th-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .th-header h1 {
            font-size: 1.5rem;
        }

        .th-stats {
            grid-template-columns: 1fr;
        }

        .th-filter form {
            flex-direction: column;
        }

        .th-filter-group {
            width: 100%;
        }

        .th-actions {
            flex-direction: column;
        }

        .th-btn {
            justify-content: center;
        }
    }

    body.dark-mode .th-wrapper {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    }

    body.dark-mode .th-transaction,
    body.dark-mode .th-filter {
        background: #2d2d44;
        border-color: rgba(59, 130, 246, 0.2);
    }

    body.dark-mode .th-stat-card {
        background: #2d2d44;
    }

    body.dark-mode .th-filter select {
        background: rgba(59, 130, 246, 0.15);
        color: #f0f9ff;
    }

    body.dark-mode .th-transaction-title,
    body.dark-mode .th-empty h3 {
        color: #f0f9ff;
    }

    body.dark-mode .th-stat-label,
    body.dark-mode .th-detail-label,
    body.dark-mode .th-transaction-meta {
        color: #cbd5e1;
    }
</style>

@include('buyer.sidebar')
<div class="main-content-wrapper">
    <div class="th-wrapper">
        <!-- Header -->
        <div class="th-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="th-header-content">
                    <h1><i class="fas fa-history me-3"></i>Transaction History</h1>
                    <p>View all your past offers, completed transactions, and environmental impact</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-3 px-md-4" style="position: relative; z-index: 1;">
            <!-- Filter Section -->
            <div class="th-filter">
                <form method="GET" action="{{ route('buyer.transaction-history') }}">
                    <div class="th-filter-group">
                        <label><i class="fas fa-filter me-2"></i>Filter by Status</label>
                        <select name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="th-filter-btn">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    @if(request('status'))
                        <a href="{{ route('buyer.transaction-history') }}" class="th-clear-btn">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Summary Stats -->
            <div class="th-stats">
                <div class="th-stat-card">
                    <small class="th-stat-label">
                        <i class="fas fa-exchange-alt me-1"></i>Total Transactions
                    </small>
                    <h3 class="th-stat-value">{{ $offers->count() }}</h3>
                </div>
                <div class="th-stat-card completed">
                    <small class="th-stat-label">
                        <i class="fas fa-check-circle me-1"></i>Completed
                    </small>
                    <h3 class="th-stat-value">{{ $offers->where('status', 'completed')->count() }}</h3>
                </div>
                <div class="th-stat-card weight">
                    <small class="th-stat-label">
                        <i class="fas fa-weight me-1"></i>Weight Diverted
                    </small>
                    <h3 class="th-stat-value">{{ number_format(auth()->user()->total_weight_diverted ?? 0) }}<span style="font-size: 0.5em;"> kg</span></h3>
                </div>
                <div class="th-stat-card carbon">
                    <small class="th-stat-label">
                        <i class="fas fa-leaf me-1"></i>CO₂ Saved
                    </small>
                    <h3 class="th-stat-value">{{ number_format(auth()->user()->total_co2_saved ?? 0) }}<span style="font-size: 0.5em;"> kg</span></h3>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="row">
                <div class="col-12">
            @if($offers->count() > 0)
                @foreach($offers as $offer)
                    <div class="th-transaction">
                        <!-- Header -->
                        <div class="th-transaction-header">
                            <div>
                                <h4 class="th-transaction-title">{{ $offer->listing->category ?: ($offer->listing->deviceType->name ?: 'Device') }}</h4>
                                <small class="th-transaction-meta">
                                    <i class="fas fa-store me-1"></i>Seller: <strong>{{ $offer->listing->seller->name }}</strong>
                                </small>
                                <small class="th-transaction-meta">
                                    <i class="fas fa-calendar me-1"></i>Offer Date: <strong>{{ $offer->created_at->format('M d, Y') }}</strong>
                                </small>
                            </div>
                            <div>
                                @php
                                    $statusClass = match($offer->status) {
                                        'pending' => 'th-status-pending',
                                        'accepted' => 'th-status-accepted',
                                        'rejected' => 'th-status-rejected',
                                        'cancelled' => 'th-status-cancelled',
                                        'completed' => 'th-status-completed',
                                        default => 'th-status-pending'
                                    };
                                @endphp
                                <span class="th-status-badge {{ $statusClass }}">
                                    <i class="fas fa-circle me-1"></i>{{ ucfirst($offer->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="th-details">
                            <div class="th-detail-item">
                                <small class="th-detail-label">Your Bid</small>
                                <h5 class="th-detail-value">₱{{ number_format($offer->bid_amount, 2) }}</h5>
                            </div>
                            <div class="th-detail-item" style="border-left-color: #06b6d4;">
                                <small class="th-detail-label">Processing Method</small>
                                <h5 class="th-detail-value" style="color: #06b6d4;">{{ ucfirst(str_replace('_', ' ', $offer->proposed_method)) }}</h5>
                            </div>
                            <div class="th-detail-item" style="border-left-color: #f59e0b;">
                                <small class="th-detail-label">Pickup Date</small>
                                <h5 class="th-detail-value" style="color: #f59e0b;">{{ $offer->proposed_pickup_date?->format('M d, Y') ?? 'Not scheduled' }}</h5>
                            </div>
                            <div class="th-detail-item" style="border-left-color: #8b5cf6;">
                                <small class="th-detail-label">Pickup Location</small>
                                <h5 class="th-detail-value" style="color: #8b5cf6;">{{ $offer->pickup_location }}</h5>
                            </div>
                        </div>

                        <!-- Impact Log -->
                        @php $impact = $offer->listing->impactLog; @endphp
                        @if($offer->status === 'completed' && $impact)
                            <div class="th-impact">
                                <h5><i class="fas fa-leaf"></i>Environmental Impact</h5>
                                <div class="th-impact-grid">
                                    <div class="th-impact-item">
                                        <small class="th-impact-label">CO₂ Saved</small>
                                        <h4 class="th-impact-value">{{ $impact->co2_saved }} kg</h4>
                                    </div>
                                    <div class="th-impact-item">
                                        <small class="th-impact-label">Weight Diverted</small>
                                        <h4 class="th-impact-value">{{ $impact->landfill_diverted_weight }} kg</h4>
                                    </div>
                                    <div class="th-impact-item">
                                        <small class="th-impact-label">Certificate</small>
                                        <a href="{{ route('certificates.show', $impact) }}" style="color: #f59e0b; font-weight: 800; text-decoration: none; display: inline-block;">
                                            <i class="fas fa-certificate me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="th-actions">
                            <a href="{{ route('offers.show', $offer) }}" class="th-btn th-btn-primary">
                                <i class="fas fa-eye"></i>View Details
                            </a>
                            @if($offer->status === 'completed' && !auth()->user()->reviewsGiven()->where('offer_id', $offer->id)->exists())
                                <a href="{{ route('reviews.create', $offer) }}" class="th-btn th-btn-success">
                                    <i class="fas fa-star"></i>Leave Review
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($offers->hasPages())
                    <div style="display: flex; justify-content: center;">
                        {{ $offers->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="th-empty">
                    <i class="th-empty-icon fas fa-inbox"></i>
                    <h3>No Transactions Yet</h3>
                    <p>Start browsing listings and submit your first offer to begin your sustainable e-waste journey.</p>
                    <a href="{{ route('listings.index') }}" class="th-empty-btn">
                        <i class="fas fa-search me-2"></i>Browse Listings
                    </a>
                </div>
            @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
