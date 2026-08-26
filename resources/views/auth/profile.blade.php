@extends('layouts.app')

@section('title', 'My Profile - E-Benta')

@section('content')
<style>
    /* === GLOBAL PROFILE STYLES === */
    .profile-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === PROFILE HEADER === */
    .profile-hero {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: white;
        padding: 3rem 2rem;
        margin: -2rem 0 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .profile-hero::before {
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

    .profile-hero::after {
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

    .profile-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar-large {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        flex-shrink: 0;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .profile-hero-info h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .profile-hero-info p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
    }

    /* === PROFILE CARD BASE === */
    .profile-card {
        background: white;
        border-radius: 1.2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(13, 148, 136, 0.1);
    }

    .profile-card:hover {
        box-shadow: 0 8px 24px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.2);
    }

    .card-header-accent {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.12) 0%, rgba(6, 182, 212, 0.08) 100%);
        padding: 1.5rem;
        border-bottom: 2px solid rgba(13, 148, 136, 0.15);
    }

    .card-header-accent h5 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .card-header-accent i {
        color: #0d9488;
        font-size: 1.4rem;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(13, 148, 136, 0.15);
        border-radius: 0.6rem;
    }

    .card-body-spacious {
        padding: 2rem;
    }

    /* === FORM ELEMENTS === */
    .form-field-group {
        margin-bottom: 1.8rem;
    }

    .form-field-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #1e293b;
        margin-bottom: 0.8rem;
    }

    .form-label i {
        color: #0d9488;
        font-size: 1rem;
    }

    .label-required {
        color: #e74c3c;
        font-weight: 900;
    }

    .form-control {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 0.7rem;
        padding: 0.95rem 1.1rem;
        font-size: 1rem;
        color: #1e293b;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus {
        background: white;
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        outline: none;
    }

    .form-control:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .form-text {
        display: block;
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 0.6rem;
    }

    .form-error {
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 0.6rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-row-flex {
        display: flex;
        gap: 1.2rem;
        align-items: flex-end;
    }

    .form-row-flex > div {
        flex: 1;
    }

    /* === STATUS BADGE === */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.2rem;
        border-radius: 2rem;
        font-weight: 800;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .status-badge.verified {
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
    }

    .status-badge.pending {
        background: rgba(243, 156, 18, 0.12);
        color: #f39c12;
    }

    /* === STATS GRID === */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.04) 100%);
        border-radius: 1rem;
        border: 1px solid rgba(13, 148, 136, 0.15);
    }

    .stat-item {
        text-align: center;
    }

    .stat-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 800;
        margin-bottom: 0.8rem;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 900;
        color: #0d9488;
        line-height: 1;
    }

    .stat-unit {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-left: 0.3rem;
        font-weight: 600;
    }

    /* === BUTTONS === */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.95rem 1.8rem;
        border-radius: 0.8rem;
        font-weight: 800;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
    }

    .btn-secondary {
        background: transparent;
        color: #0d9488;
        border: 2px solid rgba(13, 148, 136, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(13, 148, 136, 0.08);
        border-color: #0d9488;
    }

    /* === ACTION BAR === */
    .action-bar {
        display: flex;
        gap: 1rem;
        padding: 1.8rem 2rem;
        background: rgba(13, 148, 136, 0.05);
        border-top: 1px solid rgba(13, 148, 136, 0.15);
        margin: 0 -2rem -2rem -2rem;
    }

    .action-bar .btn-action {
        flex: 1;
    }

    /* === QUICK LINKS GRID === */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .quick-link {
        display: block;
        padding: 1.8rem;
        background: white;
        border: 2px solid rgba(13, 148, 136, 0.1);
        border-radius: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .quick-link:hover {
        border-color: #0d9488;
        box-shadow: 0 8px 24px rgba(13, 148, 136, 0.15);
        transform: translateY(-4px);
    }

    .quick-link-icon {
        font-size: 2.5rem;
        color: #0d9488;
        margin-bottom: 1rem;
        display: block;
    }

    .quick-link-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0.8rem 0 0.5rem 0;
    }

    .quick-link-desc {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .profile-hero-content {
            flex-direction: column;
            text-align: center;
        }

        .profile-hero {
            padding: 2rem 1.5rem;
        }

        .profile-hero-info h1 {
            font-size: 2rem;
        }

        .form-row-flex {
            flex-direction: column;
            align-items: stretch;
        }

        .form-row-flex > div {
            flex: 1;
        }

        .action-bar {
            flex-direction: column;
        }

        .quick-links {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* === DARK MODE === */
    body.dark-mode .profile-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .profile-card {
        background: #2a2a2a;
        border-color: rgba(6, 182, 212, 0.2);
    }

    body.dark-mode .profile-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    body.dark-mode .card-header-accent {
        background: rgba(13, 148, 136, 0.15);
        border-bottom-color: rgba(13, 148, 136, 0.3);
    }

    body.dark-mode .card-header-accent h5 {
        color: #e0e0e0;
    }

    body.dark-mode .form-label {
        color: #e0e0e0;
    }

    body.dark-mode .form-control {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(13, 148, 136, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .form-control:focus {
        background: rgba(255, 255, 255, 0.12);
        border-color: #06b6d4;
    }

    body.dark-mode .form-control:disabled {
        background: rgba(255, 255, 255, 0.04);
        color: #64748b;
    }

    body.dark-mode .form-text {
        color: #b0b0b0;
    }

    body.dark-mode .stats-grid {
        background: rgba(13, 148, 136, 0.1);
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .action-bar {
        background: rgba(13, 148, 136, 0.08);
        border-top-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .quick-link {
        background: #2a2a2a;
        border-color: rgba(13, 148, 136, 0.15);
    }

    body.dark-mode .quick-link:hover {
        background: #333333;
        box-shadow: 0 8px 24px rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .quick-link-title {
        color: #e0e0e0;
    }

    body.dark-mode .quick-link-desc {
        color: #b0b0b0;
    }

    /* Modern profile presentation */
    .profile-wrapper {
        background:
            radial-gradient(circle at 8% 10%, rgba(6, 182, 212, 0.12), transparent 28rem),
            linear-gradient(135deg, #f7fafc 0%, #eef6f5 52%, #f8fbff 100%);
        padding-bottom: 4rem;
    }

    .profile-hero {
        max-width: 1180px;
        margin: 0 auto 2rem;
        padding: 2.5rem 2rem;
        border-radius: 0 0 1.5rem 1.5rem;
        background: linear-gradient(120deg, #102a43 0%, #0d9488 58%, #06b6d4 100%);
        box-shadow: 0 18px 45px rgba(16, 42, 67, 0.2);
    }

    .profile-hero::before,
    .profile-hero::after {
        opacity: 0.45;
    }

    .profile-avatar-large {
        width: 104px;
        height: 104px;
        font-size: 2.8rem;
        background: rgba(255, 255, 255, 0.16);
    }

    .profile-hero-info h1 {
        font-size: clamp(2rem, 4vw, 3rem);
        letter-spacing: 0;
    }

    .profile-role-line {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.7rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .profile-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 900px);
        gap: 1.5rem;
        justify-content: center;
        align-items: stretch;
    }

    .profile-card {
        border-radius: 0.8rem;
        box-shadow: 0 8px 24px rgba(15, 42, 67, 0.07);
        border-color: rgba(15, 42, 67, 0.08);
    }

    .card-header-accent {
        padding: 1.25rem 1.5rem;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-header-accent h5 {
        font-size: 1rem;
        letter-spacing: 0;
    }

    .card-body-spacious {
        padding: 1.5rem;
    }

    .profile-sidebar-card {
        position: sticky;
        top: 80px;
    }

    .profile-sidebar-action {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 0;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
        text-decoration: none;
        font-weight: 700;
    }

    .profile-sidebar-action:last-child {
        border-bottom: 0;
    }

    .profile-sidebar-action i {
        width: 30px;
        color: #0d9488;
        text-align: center;
    }

    .profile-readonly-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .profile-readonly-item {
        min-width: 0;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.65rem;
        background: #f8fafc;
    }

    .profile-readonly-item strong {
        display: block;
        margin-top: 0.5rem;
        color: #1e293b;
        overflow-wrap: anywhere;
    }

    .profile-readonly-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-readonly-label i {
        color: #0d9488;
    }

    @media (max-width: 900px) {
        .profile-main-grid {
            grid-template-columns: 1fr;
        }

        .profile-sidebar-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .profile-hero {
            border-radius: 0;
            margin-bottom: 1.25rem;
            padding: 2rem 1.25rem;
        }

        .profile-hero-content {
            gap: 1rem;
        }

        .profile-readonly-grid {
            grid-template-columns: 1fr;
        }

        .action-bar .btn-action {
            width: 100%;
        }
    }

    body.dark-mode .card-header-accent {
        background: #2a2a2a;
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .profile-sidebar-action {
        color: #e0e0e0;
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .profile-readonly-item {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .profile-readonly-item strong {
        color: #e0e0e0;
    }
</style>

<div class="profile-wrapper">
    <!-- Hero Section -->
    <div class="profile-hero">
        <div class="container">
            <div class="profile-hero-content">
                <div class="profile-avatar-wrapper" style="position: relative; display: inline-block;">
                    @if(auth()->user()->avatar_url)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="profile-avatar-large" style="object-fit: cover;">
                    @else
                        <div class="profile-avatar-large">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <button type="button" class="btn-avatar-edit" data-bs-toggle="modal" data-bs-target="#avatarModal" title="Change Profile Picture" style="position: absolute; bottom: 5px; right: 5px; background: white; color: #0d9488; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); cursor: pointer; transition: all 0.2s ease; z-index: 2;" onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#0d9488'; this.style.color='white';" onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='white'; this.style.color='#0d9488';">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <div class="profile-hero-info">
                    <h1>{{ auth()->user()->name }}</h1>
                    <div class="profile-role-line">
                        <p>{{ ucfirst(auth()->user()->role) }} account</p>
                        <span class="profile-role-badge">
                            <i class="fas fa-{{ auth()->user()->is_verified ? 'check-circle' : 'clock' }}"></i>
                            {{ auth()->user()->is_verified ? 'Verified' : 'Pending verification' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content -->
    <div class="container py-4" style="padding-bottom: 3rem;">
        <div class="profile-main-grid">
            <div>
                <!-- Personal Information Card -->
                <div class="profile-card">
                    <div class="card-header-accent">
                        <h5><i class="fas fa-id-card"></i>Personal Information</h5>
                    </div>
                    <div class="card-body-spacious">
                        <div class="profile-readonly-grid">
                            <div class="profile-readonly-item">
                                <span class="profile-readonly-label"><i class="fas fa-user"></i>Full Name</span>
                                <strong>{{ auth()->user()->name }}</strong>
                            </div>
                            <div class="profile-readonly-item">
                                <span class="profile-readonly-label"><i class="fas fa-envelope"></i>Email Address</span>
                                <strong>{{ auth()->user()->email }}</strong>
                            </div>
                            <div class="profile-readonly-item">
                                <span class="profile-readonly-label"><i class="fas fa-phone"></i>Phone Number</span>
                                <strong>{{ auth()->user()->phone ?: 'Not provided' }}</strong>
                            </div>
                            <div class="profile-readonly-item">
                                <span class="profile-readonly-label"><i class="fas fa-shield-alt"></i>Account Type</span>
                                <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                            </div>
                            @if(auth()->user()->isSeller() || auth()->user()->isBuyer())
                                <div class="profile-readonly-item">
                                    <span class="profile-readonly-label"><i class="fas fa-{{ auth()->user()->isSeller() ? 'store' : 'building' }}"></i>{{ auth()->user()->isSeller() ? 'Business Name' : 'Organization Name' }}</span>
                                    <strong>{{ auth()->user()->business_name ?: 'Not provided' }}</strong>
                                </div>
                            @endif
                            <div class="profile-readonly-item">
                                <span class="profile-readonly-label"><i class="fas fa-check-circle"></i>Account Status</span>
                                <strong class="{{ auth()->user()->is_verified ? 'text-success' : 'text-warning' }}">{{ auth()->user()->is_verified ? 'Verified' : 'Pending verification' }}</strong>
                            </div>
                        </div>

                        <div class="action-bar">
                            <a href="{{ route('settings') }}" class="btn-action btn-primary">
                                <i class="fas fa-sliders-h"></i>Edit in Account Settings
                            </a>
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard')) }}" class="btn-action btn-secondary">
                                <i class="fas fa-arrow-left"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact Card (Buyers Only) -->
                @if(auth()->user()->isBuyer())
                    <div class="profile-card">
                        <div class="card-header-accent">
                            <h5><i class="fas fa-leaf"></i>Your Environmental Impact</h5>
                        </div>
                        <div class="card-body-spacious">
                            <p style="color: #64748b; margin-bottom: 1.5rem;">Track your positive contribution to environmental sustainability</p>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-label"><i class="fas fa-box"></i>Items Processed</div>
                                    <div class="stat-value">{{ auth()->user()->items_processed ?? 0 }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label"><i class="fas fa-weight"></i>E-Waste Diverted</div>
                                    <div class="stat-value">{{ auth()->user()->total_weight_diverted ?? 0 }}<span class="stat-unit">kg</span></div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label"><i class="fas fa-wind"></i>CO₂ Saved</div>
                                    <div class="stat-value">{{ auth()->user()->total_co2_saved ?? 0 }}<span class="stat-unit">kg</span></div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label"><i class="fas fa-calendar"></i>Member Since</div>
                                    <div class="stat-value" style="font-size: 1.3rem;">{{ auth()->user()->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Links -->
                <div style="margin-top: 3rem;">
                    <h4 style="color: #1e293b; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;">
                        <i class="fas fa-rocket" style="color: #0d9488; font-size: 1.4rem;"></i>Quick Actions
                    </h4>
                    <div class="quick-links">
                        @if(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="quick-link">
                                <i class="fa-solid fa-chart-line quick-link-icon"></i>
                                <h6 class="quick-link-title">My Listings</h6>
                                <p class="quick-link-desc">View and manage your listings</p>
                            </a>
                            <a href="{{ route('seller.dashboard') }}" class="quick-link">
                                <i class="fas fa-shopping-cart quick-link-icon"></i>
                                <h6 class="quick-link-title">Sales</h6>
                                <p class="quick-link-desc">Track your sales and orders</p>
                            </a>
                        @else
                            <a href="{{ route('buyer.dashboard') }}" class="quick-link">
                                <i class="fas fa-inbox quick-link-icon"></i>
                                <h6 class="quick-link-title">My Offers</h6>
                                <p class="quick-link-desc">View your active offers</p>
                            </a>
                            <a href="{{ route('buyer.dashboard') }}" class="quick-link">
                                <i class="fas fa-tree quick-link-icon"></i>
                                <h6 class="quick-link-title">Impact Stats</h6>
                                <p class="quick-link-desc">View environmental impact</p>
                            </a>
                        @endif
                        <a href="#" class="quick-link">
                            <i class="fas fa-question-circle quick-link-icon"></i>
                            <h6 class="quick-link-title">Help & Support</h6>
                            <p class="quick-link-desc">Get help and support</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Picture Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true" style="backdrop-filter: blur(6px);">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content" style="background: #ffffff; border-radius: 1.25rem; border: 1px solid rgba(13, 148, 136, 0.2); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%); padding: 1.5rem 1.75rem; border-bottom: 1px solid rgba(13, 148, 136, 0.15);">
                <h5 class="modal-title" id="avatarModalLabel" style="color: #1e293b; font-weight: 800; font-size: 1.25rem; display: flex; align-items: center; gap: 0.6rem; margin: 0;">
                    <i class="fas fa-camera" style="color: #0d9488;"></i>Update Profile Picture
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                @csrf
                <div class="modal-body" style="padding: 2rem 1.75rem; text-align: center;">
                    <!-- Preview Box -->
                    <div style="margin-bottom: 1.5rem;">
                        <div id="avatarPreviewContainer" style="width: 130px; height: 130px; border-radius: 50%; margin: 0 auto 1rem; overflow: hidden; border: 3px solid #0d9488; box-shadow: 0 6px 20px rgba(13, 148, 136, 0.2); display: flex; align-items: center; justify-content: center; background: #f1f5f9;">
                            @if(auth()->user()->avatar_url)
                                <img id="avatarImagePreview" src="{{ auth()->user()->avatar_url }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div id="avatarInitialsPreview" style="font-size: 3.5rem; font-weight: 800; color: #0d9488;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <img id="avatarImagePreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            @endif
                        </div>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Supported formats: JPG, PNG, WEBP, GIF (Max 2MB)</p>
                    </div>

                    <!-- File input -->
                    <div style="margin-bottom: 1.25rem;">
                        <input type="file" name="avatar" id="avatarFileInput" accept="image/jpeg,image/png,image/webp,image/gif" required class="form-control" style="border: 2px dashed rgba(13, 148, 136, 0.4); padding: 0.75rem; border-radius: 0.75rem; background: #f8fafc; font-size: 0.9rem;" onchange="previewAvatar(this)">
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; padding: 1.25rem 1.75rem; border-top: 1px solid rgba(13, 148, 136, 0.1); display: flex; justify-content: space-between;">
                    @if(auth()->user()->avatar)
                        <button type="button" class="btn btn-outline-danger" style="border-radius: 0.6rem; font-weight: 700; font-size: 0.85rem;" onclick="document.getElementById('deleteAvatarForm').submit();">
                            <i class="fas fa-trash me-1"></i>Remove
                        </button>
                    @else
                        <div></div>
                    @endif

                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 0.6rem; font-weight: 700; font-size: 0.85rem;">Cancel</button>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: white; border-radius: 0.6rem; font-weight: 700; font-size: 0.85rem; border: none; padding: 0.5rem 1.25rem;">
                            <i class="fas fa-save me-1"></i>Save Picture
                        </button>
                    </div>
                </div>
            </form>

            @if(auth()->user()->avatar)
                <form id="deleteAvatarForm" action="{{ route('profile.avatar.delete') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatarImagePreview');
                const initials = document.getElementById('avatarInitialsPreview');
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (initials) {
                    initials.style.display = 'none';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
