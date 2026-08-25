@extends('layouts.app')

@section('title', 'Buyer Dashboard - E-Benta')

@section('content')
<style>
    /* === BUYER DASHBOARD WRAPPER === */
    .bd-wrapper {
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 30%, #f0f9ff 70%, #f5f3ff 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
    }

    .bd-wrapper::before {
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
    .bd-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
        color: white;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid rgba(255, 255, 255, 0.2);
    }

    .bd-header::before {
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

    .bd-header::after {
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

    .bd-header-content {
        position: relative;
        z-index: 1;
    }

    .bd-header h1 {
        font-size: 2.8rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .bd-header p {
        opacity: 0.98;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* === ALERT SECTION === */
    .bd-alert {
        position: fixed;
        top: 80px;
        left: 0;
        right: 0;
        z-index: 1050;
        pointer-events: none;
    }

    .bd-alert-content {
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.08) 100%);
        border: 2px solid rgba(243, 156, 18, 0.25);
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 1rem 2rem;
        box-shadow: 0 8px 25px rgba(243, 156, 18, 0.15);
        pointer-events: auto;
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .bd-alert-icon {
        color: #f39c12;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .bd-alert-text {
        color: #1e293b;
        font-weight: 600;
        font-size: 0.95rem;
        flex: 1;
    }

    /* === STATS GRID === */
    .bd-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }

    .bd-stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 2px solid;
        border-top-width: 5px;
        padding: 2rem 1.75rem;
        border-radius: 1.1rem;
        text-align: left;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .bd-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(ellipse 400px 300px at 50% 0%, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .bd-stat-card:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        transform: translateY(-6px);
    }

    .bd-stat-card.status-card {
        border-top-color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .bd-stat-card.items-card {
        border-top-color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }

    .bd-stat-card.waste-card {
        border-top-color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
    }

    .bd-stat-card.carbon-card {
        border-top-color: #06b6d4;
        border-color: rgba(6, 182, 212, 0.2);
    }

    .bd-stat-info {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .bd-stat-label {
        color: #4b5563;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-size: 0.8rem;
        margin-bottom: 0.75rem;
    }

    .bd-stat-value {
        font-size: 2.2rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
    }

    .bd-stat-card.status-card .bd-stat-value {
        color: #3b82f6;
    }

    .bd-stat-card.items-card .bd-stat-value {
        color: #10b981;
    }

    .bd-stat-card.waste-card .bd-stat-value {
        color: #8b5cf6;
    }

    .bd-stat-card.carbon-card .bd-stat-value {
        color: #06b6d4;
    }

    .bd-stat-icon-box {
        width: 70px;
        height: 70px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        position: relative;
        z-index: 1;
    }

    .bd-stat-card.status-card .bd-stat-icon-box {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .bd-stat-card.items-card .bd-stat-icon-box {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%);
        color: #10b981;
    }

    .bd-stat-card.waste-card .bd-stat-icon-box {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(139, 92, 246, 0.08) 100%);
        color: #8b5cf6;
    }

    .bd-stat-card.carbon-card .bd-stat-icon-box {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
        color: #06b6d4;
    }

    /* === ACTION BUTTONS === */
    .bd-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }

    .bd-action-btn {
        padding: 1.2rem 1.5rem;
        border: none;
        border-radius: 0.8rem;
        font-weight: 800;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .bd-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }

    .bd-action-btn:hover::before {
        left: 100%;
    }

    .bd-browse-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }

    .bd-browse-btn:hover {
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
        transform: translateY(-3px);
    }

    .bd-history-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
    }

    .bd-history-btn:hover {
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
        transform: translateY(-3px);
    }

    .bd-address-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .bd-address-btn:hover {
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        transform: translateY(-3px);
    }

    /* === SECTION HEADERS === */
    .bd-section-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(59, 130, 246, 0.08) 100%);
        border: 2px solid rgba(59, 130, 246, 0.25);
        border-radius: 1rem;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .bd-section-header i {
        color: #3b82f6;
        font-size: 1.5rem;
    }

    .bd-section-header h2 {
        color: #1e293b;
        font-weight: 900;
        margin: 0;
        font-size: 1.4rem;
        letter-spacing: -0.5px;
    }

    /* === EMPTY STATE === */
    .bd-empty-state {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 2px solid rgba(59, 130, 246, 0.25);
        color: #1e293b;
        padding: 4.5rem 2rem;
        border-radius: 1.3rem;
        text-align: center;
        box-shadow: 0 8px 30px rgba(59, 130, 246, 0.15);
        position: relative;
        z-index: 1;
    }

    .bd-empty-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.15) 100%);
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #3b82f6;
    }

    .bd-empty-title {
        color: #1e293b;
        margin-bottom: 0.9rem;
        font-weight: 900;
        font-size: 1.5rem;
    }

    .bd-empty-text {
        color: #4b5563;
        margin: 0.9rem 0 2rem 0;
        font-size: 0.95rem;
    }

    .bd-empty-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        font-weight: 800;
        padding: 0.9rem 2rem;
        border-radius: 0.7rem;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .bd-empty-btn:hover {
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
        transform: translateY(-3px);
    }

    /* === DARK MODE === */
    body.dark-mode .bd-wrapper {
        background: linear-gradient(135deg, #1a3a3a 0%, #1a2a3a 30%, #1a1a3a 70%, #2a1a3a 100%);
    }

    body.dark-mode .bd-header {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #1a3a8a 100%);
    }

    body.dark-mode .bd-stat-card,
    body.dark-mode .bd-empty-state,
    body.dark-mode .bd-section-header {
        background: #2a2a2a;
        border-color: rgba(59, 130, 246, 0.2);
    }

    body.dark-mode .bd-stat-label,
    body.dark-mode .bd-empty-title,
    body.dark-mode .bd-section-header h2 {
        color: #e0e0e0;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .bd-header h1 {
            font-size: 2rem;
        }

        .bd-header p {
            font-size: 0.95rem;
        }

        .bd-stats-grid {
            grid-template-columns: 1fr;
        }

        .bd-stat-card {
            flex-direction: column;
        }

        .bd-stat-icon-box {
            align-self: flex-start;
        }

        .bd-actions-grid {
            grid-template-columns: 1fr;
        }

        .bd-stat-value {
            font-size: 2rem;
        }
    }
</style>

@include('buyer.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="bd-wrapper">
        <!-- Header -->
        <div class="bd-header">
            <div class="container-fluid">
                <div class="bd-header-content">
                    <h1><i class="fas fa-shopping-cart me-3"></i>Buyer Dashboard</h1>
                    <p>Browse listings, submit offers, and track your e-waste impact</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem; position: relative; z-index: 1;">
            <!-- Verification Alert -->
            @if(!auth()->user()->is_verified)
                <div class="bd-alert">
                    <div class="bd-alert-content">
                        <i class="fas fa-hourglass-half bd-alert-icon"></i>
                        <div class="bd-alert-text">
                            <strong>Account Pending Verification!</strong> Your buyer account is awaiting admin verification. You can browse listings but cannot submit offers until verified. We'll notify you once you're approved!
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistics Grid -->
            <div class="bd-stats-grid">
                <!-- Account Status Card -->
                <div class="bd-stat-card status-card">
                    <div class="bd-stat-info">
                        <div class="bd-stat-label"><i class="fas fa-user-check me-1"></i>Account Status</div>
                        @if(auth()->user()->is_verified)
                            <div class="bd-stat-value" style="color: #10b981;">Verified</div>
                        @else
                            <div class="bd-stat-value" style="color: #f59e0b;">Pending</div>
                        @endif
                    </div>
                    <div class="bd-stat-icon-box">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>

                <!-- Items Processed Card -->
                <div class="bd-stat-card items-card">
                    <div class="bd-stat-info">
                        <div class="bd-stat-label"><i class="fas fa-box me-1"></i>Items Processed</div>
                        <div class="bd-stat-value">{{ auth()->user()->items_processed ?? 0 }}</div>
                    </div>
                    <div class="bd-stat-icon-box">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>

                <!-- E-Waste Diverted Card -->
                <div class="bd-stat-card waste-card">
                    <div class="bd-stat-info">
                        <div class="bd-stat-label"><i class="fas fa-weight me-1"></i>E-Waste Diverted</div>
                        <div class="bd-stat-value">{{ auth()->user()->total_weight_diverted ?? 0 }}<small style="font-size: 0.45em;"> kg</small></div>
                    </div>
                    <div class="bd-stat-icon-box">
                        <i class="fas fa-dumpster"></i>
                    </div>
                </div>

                <!-- CO₂ Saved Card -->
                <div class="bd-stat-card carbon-card">
                    <div class="bd-stat-info">
                        <div class="bd-stat-label"><i class="fas fa-leaf me-1"></i>CO₂ Saved</div>
                        <div class="bd-stat-value">{{ auth()->user()->total_co2_saved ?? 0 }}<small style="font-size: 0.45em;"> kg</small></div>
                    </div>
                    <div class="bd-stat-icon-box">
                        <i class="fas fa-tree"></i>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bd-actions-grid">
                <a href="{{ route('listings.index') }}" class="bd-action-btn bd-browse-btn">
                    <i class="fas fa-search"></i>Browse Listings
                </a>
                <a href="{{ route('buyer.transaction-history') }}" class="bd-action-btn bd-history-btn">
                    <i class="fas fa-history"></i>View Offer History
                </a>
                <a href="{{ route('addresses.index') }}" class="bd-action-btn bd-address-btn">
                    <i class="fas fa-map-marker-alt"></i>Manage Addresses
                </a>
            </div>

            <!-- Available Listings Section -->
            <div class="bd-section-header">
                <i class="fas fa-list"></i>
                <h2>Available Listings</h2>
            </div>

            @if($availableListings->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                    @foreach($availableListings as $listing)
                        <div style="background: white; border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 1.2rem; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);" onmouseover="this.style.boxShadow='0 12px 35px rgba(59, 130, 246, 0.2)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.08)'; this.style.transform='translateY(0)';">
                            <!-- Image Container -->
                            <div style="position: relative; height: 240px; overflow: hidden; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));">
                                @if($listing->photos && count(is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? []) > 0)
                                    @php
                                        $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                                    @endphp
                                    <img src="{{ $photos[0] }}" alt="Device" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3b82f6;">
                                        <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 0.75rem; opacity: 0.4;"></i>
                                    </div>
                                @endif
                                <!-- Status Badge -->
                                <div style="position: absolute; top: 1rem; right: 1rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 700; padding: 0.6rem 1rem; border-radius: 0.6rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.4px;">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="padding: 1.5rem;">
                                <h5 style="color: #1e293b; font-weight: 800; margin-bottom: 0.75rem; font-size: 1.1rem;">
                                    {{ Str::limit($listing->category ?: ($listing->deviceType->name ?: 'Uncategorized'), 45, '...') }}
                                </h5>
                                <p style="color: #4b5563; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                    {{ Str::limit($listing->description, 80, '...') }}
                                </p>

                                <!-- Condition Badge -->
                                <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem;">
                                    <span style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%); color: #3b82f6; font-size: 0.8rem; font-weight: 700; padding: 0.5rem 0.9rem; border-radius: 0.6rem; border: 1px solid rgba(59, 130, 246, 0.2); text-transform: uppercase; letter-spacing: 0.4px;">
                                        {{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                                    </span>
                                </div>

                                <!-- Price -->
                                <div style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%); border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 0.6rem; margin-bottom: 1rem;">
                                    <small style="color: #4b5563; display: block; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.75rem;">Price</small>
                                    <h4 style="color: #3b82f6; margin: 0.5rem 0 0 0; font-weight: 900; font-size: 1.4rem;">
                                        @if($listing->suggested_price > 0)
                                            ₱{{ number_format($listing->suggested_price, 2) }}
                                        @else
                                            <i class="fas fa-gift me-1"></i>Free
                                        @endif
                                    </h4>
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('listings.show', $listing) }}" class="btn w-100" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; font-weight: 800; padding: 0.8rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);" onmouseover="this.style.boxShadow='0 8px 20px rgba(59, 130, 246, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.25)'; this.style.transform='translateY(0)';">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bd-empty-state">
                    <div class="bd-empty-icon"><i class="fas fa-search-minus"></i></div>
                    <h5 class="bd-empty-title">No Listings Found</h5>
                    <p class="bd-empty-text">There are no listings matching your criteria at the moment. Check back soon!</p>
                    <a href="{{ route('listings.index') }}" class="bd-empty-btn">
                        <i class="fas fa-arrow-right me-2"></i>Browse All Listings
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
