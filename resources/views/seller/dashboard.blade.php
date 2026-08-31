@extends('layouts.app')

@section('title', ($isRecentView ?? false) ? 'Seller Dashboard - E-Benta' : 'My Listings - E-Benta')

@section('content')
<style>
    /* === MODERN SELLER STUDIO THEME === */
    :root {
        --seller-primary: #0d9488;
        --seller-primary-dark: #0f766e;
        --seller-primary-light: #f0fdfa;
        --seller-emerald: #059669;
        --seller-amber: #f59e0b;
        --seller-blue: #3b82f6;
        --seller-indigo: #6366f1;
        --seller-card-bg: #ffffff;
        --seller-border-color: rgba(226, 232, 240, 0.9);
        --seller-text-main: #0f172a;
        --seller-text-muted: #64748b;
    }

    .seller-dashboard-page {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding-bottom: 3rem;
    }

    .main-content-wrapper {
        margin-left: 260px;
        width: calc(100% - 260px);
        transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1), width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @media (max-width: 991.98px) {
        .main-content-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }

    /* === COMPACT HERO / HEADER === */
    .seller-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0d9488 160%);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .seller-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.25) 0%, rgba(13, 148, 136, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-greeting {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #2dd4bf;
        margin-bottom: 0.35rem;
    }

    .hero-title {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 0.35rem;
        color: #ffffff;
    }

    .hero-subtitle {
        color: #94a3b8;
        font-size: 0.92rem;
        margin-bottom: 0;
        max-width: 650px;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-create-listing {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 0.65rem 1.25rem;
        border-radius: 0.65rem;
        border: none;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-create-listing:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.45);
        background: linear-gradient(135deg, #0f766e 0%, #047857 100%);
    }

    .view-toggle-pill-group {
        display: inline-flex;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0.65rem;
        padding: 0.25rem;
        gap: 0.25rem;
    }

    .view-toggle-pill {
        color: #cbd5e1;
        padding: 0.45rem 0.9rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .view-toggle-pill:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
    }

    .view-toggle-pill.active {
        background: #0d9488;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.35);
    }

    /* === KPI GRID MATRIX === */
    .kpi-section {
        margin-top: -1.25rem;
        position: relative;
        z-index: 10;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid var(--seller-border-color);
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        border-color: rgba(13, 148, 136, 0.3);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
    }

    .kpi-card.kpi-teal::before { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .kpi-card.kpi-amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .kpi-card.kpi-blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .kpi-card.kpi-emerald::before { background: linear-gradient(90deg, #059669, #34d399); }

    .kpi-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }

    .kpi-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        margin: 0;
    }

    .kpi-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .kpi-teal .kpi-icon-box { background: rgba(13, 148, 136, 0.12); color: #0d9488; }
    .kpi-amber .kpi-icon-box { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
    .kpi-blue .kpi-icon-box { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
    .kpi-emerald .kpi-icon-box { background: rgba(5, 150, 105, 0.12); color: #059669; }

    .kpi-number {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.4rem;
        letter-spacing: -0.02em;
    }

    .kpi-meta {
        margin-top: auto;
        font-size: 0.78rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .kpi-tag {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 0.4rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .kpi-tag-success { background: #f0fdf4; color: #16a34a; }
    .kpi-tag-warning { background: #fffbeb; color: #d97706; }
    .kpi-tag-info { background: #f0fdfa; color: #0d9488; }

    /* === CONTENT WORKSPACE CARD === */
    .content-panel-card {
        background: #ffffff;
        border: 1px solid var(--seller-border-color);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    /* Toolbar Header */
    .panel-toolbar {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--seller-border-color);
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .panel-title-wrap {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .panel-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.2px;
    }

    .panel-badge-count {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 1rem;
    }

    /* Filter Pills & Search */
    .filter-tabs-wrapper {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        background: #f8fafc;
        padding: 0.25rem;
        border-radius: 0.6rem;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
    }

    .filter-tab-btn {
        padding: 0.35rem 0.8rem;
        border-radius: 0.45rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .filter-tab-btn:hover {
        color: #0d9488;
        background: rgba(13, 148, 136, 0.06);
    }

    .filter-tab-btn.active {
        background: #ffffff;
        color: #0d9488;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.08);
    }

    .search-input-group {
        position: relative;
        min-width: 220px;
    }

    .search-input-group i {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .search-input-control {
        width: 100%;
        padding: 0.45rem 0.85rem 0.45rem 2.25rem;
        font-size: 0.84rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.55rem;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .search-input-control:focus {
        background: #ffffff;
        border-color: #0d9488;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
    }

    /* === DATA TABLE STYLES === */
    .table-responsive-wrapper {
        overflow-x: auto;
    }

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
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid var(--seller-border-color);
        white-space: nowrap;
    }

    .seller-table tbody tr {
        border-bottom: 1px solid rgba(241, 245, 249, 1);
        transition: background-color 0.15s ease;
    }

    .seller-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .seller-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        font-size: 0.88rem;
    }

    /* Item Column with Thumbnail */
    .item-cell-wrap {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .item-thumb-box {
        width: 48px;
        height: 48px;
        border-radius: 0.6rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-thumb-icon {
        color: #94a3b8;
        font-size: 1.25rem;
    }

    .item-details-wrap {
        display: flex;
        flex-direction: column;
    }

    .item-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.9rem;
        text-decoration: none;
        line-height: 1.25;
        margin-bottom: 0.2rem;
        transition: color 0.2s ease;
    }

    .item-title:hover {
        color: #0d9488;
    }

    .item-sub-tags {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .badge-condition {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 0.35rem;
        background: #f1f5f9;
        color: #475569;
        text-transform: capitalize;
    }

    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-status-available {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .badge-status-matched {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .badge-status-processed {
        background: #faf5ff;
        color: #7c3aed;
        border: 1px solid #e9d5ff;
    }

    .badge-status-pending {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    /* Price styling */
    .price-value {
        font-weight: 800;
        font-size: 0.95rem;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    /* Offers Tag */
    .offers-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.25rem 0.6rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .offers-pill.has-pending {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
        animation: pulseSubtle 2s infinite ease-in-out;
    }

    .offers-pill.has-pending:hover {
        background: #fef3c7;
        color: #b45309;
        transform: scale(1.02);
    }

    .offers-pill.no-offers {
        color: #94a3b8;
        font-weight: 500;
    }

    @keyframes pulseSubtle {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.75; }
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-action-icon:hover {
        background: #ffffff;
        color: #0d9488;
        border-color: #0d9488;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(13, 148, 136, 0.15);
    }

    .btn-action-icon.btn-action-edit:hover {
        color: #f59e0b;
        border-color: #f59e0b;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.15);
    }

    .btn-action-icon.btn-action-offers:hover {
        color: #059669;
        border-color: #059669;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.15);
    }

    /* === EMPTY STATE === */
    .empty-state-wrap {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f0fdfa;
        color: #0d9488;
        font-size: 1.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        border: 1px solid #ccfbf1;
    }

    .empty-state-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.4rem;
    }

    .empty-state-desc {
        color: #64748b;
        font-size: 0.88rem;
        max-width: 420px;
        margin: 0 auto 1.5rem;
    }

    /* === PAGINATION === */
    .panel-footer-pagination {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--seller-border-color);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    /* === DARK MODE ADAPTATION === */
    body.dark-mode .seller-dashboard-page {
        background-color: #0b1120;
    }
    body.dark-mode .kpi-card {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    body.dark-mode .kpi-number {
        color: #ffffff;
    }
    body.dark-mode .content-panel-card {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    body.dark-mode .panel-toolbar {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    body.dark-mode .panel-title {
        color: #ffffff;
    }
    body.dark-mode .filter-tabs-wrapper {
        background: #0f172a;
        border-color: rgba(255, 255, 255, 0.08);
    }
    body.dark-mode .filter-tab-btn.active {
        background: #1e293b;
        color: #2dd4bf;
    }
    body.dark-mode .search-input-control {
        background: #0f172a;
        border-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }
    body.dark-mode .seller-table thead th {
        background: #0f172a;
        border-color: rgba(255, 255, 255, 0.08);
        color: #94a3b8;
    }
    body.dark-mode .seller-table tbody tr {
        border-color: rgba(255, 255, 255, 0.05);
    }
    body.dark-mode .seller-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }
    body.dark-mode .item-title {
        color: #ffffff;
    }
    body.dark-mode .price-value {
        color: #ffffff;
    }
    body.dark-mode .btn-action-icon {
        background: #0f172a;
        border-color: rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
    }
    body.dark-mode .panel-footer-pagination {
        background: #182234;
        border-color: rgba(255, 255, 255, 0.08);
    }
</style>

@include('seller.sidebar')

<div class="main-content-wrapper">
    <div class="seller-dashboard-page">
        <!-- Hero Header -->
        <header class="seller-hero">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <div class="hero-greeting">
                            <i class="fas fa-certificate"></i>
                            <span>Verified Seller Studio</span>
                        </div>
                        <h1 class="hero-title">
                            {{ ($isRecentView ?? false) ? 'Seller Dashboard' : 'Inventory Management' }}
                        </h1>
                        <p class="hero-subtitle">
                            {{ ($isRecentView ?? false)
                                ? 'Overview of your listings created within the last 24 hours and active performance metrics.'
                                : 'Comprehensive catalog of all your electronic waste listings and transaction records.' }}
                        </p>
                    </div>

                    <div class="hero-actions">
                        <div class="view-toggle-pill-group">
                            <a href="{{ route('seller.dashboard') }}" class="view-toggle-pill {{ ($isRecentView ?? false) ? 'active' : '' }}">
                                <i class="fas fa-clock"></i> Recent 24h
                            </a>
                            <a href="{{ route('seller.listings') }}" class="view-toggle-pill {{ !($isRecentView ?? false) ? 'active' : '' }}">
                                <i class="fas fa-boxes-stacked"></i> All Listings
                            </a>
                        </div>

                        <a href="{{ route('listings.create') }}" class="btn-create-listing">
                            <i class="fas fa-plus"></i> List Device
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid px-3 px-md-4">
            <!-- 4-Tier KPI Matrix -->
            <section class="kpi-section">
                <div class="row g-3">
                    <!-- KPI 1: Active Listings -->
                    <div class="col-6 col-lg-3">
                        <div class="kpi-card kpi-teal">
                            <div class="kpi-head">
                                <span class="kpi-label">Active Inventory</span>
                                <div class="kpi-icon-box">
                                    <i class="fas fa-boxes-stacked"></i>
                                </div>
                            </div>
                            <div class="kpi-number">{{ $statistics['active_listings'] ?? 0 }}</div>
                            <div class="kpi-meta">
                                <span class="kpi-tag kpi-tag-info">
                                    ₱{{ number_format($statistics['active_inventory_value'] ?? 0, 0) }}
                                </span>
                                <span>of {{ $statistics['total_listings'] ?? 0 }} total items</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 2: Pending Offers -->
                    <div class="col-6 col-lg-3">
                        <div class="kpi-card kpi-amber">
                            <div class="kpi-head">
                                <span class="kpi-label">Pending Offers</span>
                                <div class="kpi-icon-box">
                                    <i class="fas fa-handshake-angle"></i>
                                </div>
                            </div>
                            <div class="kpi-number">{{ $statistics['pending_offers'] ?? 0 }}</div>
                            <div class="kpi-meta">
                                @if(($statistics['pending_offers'] ?? 0) > 0)
                                    <span class="kpi-tag kpi-tag-warning">
                                        <i class="fas fa-bell"></i> Action needed
                                    </span>
                                @else
                                    <span class="text-muted">All offers reviewed</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- KPI 3: Realized Revenue / Completed -->
                    <div class="col-6 col-lg-3">
                        <div class="kpi-card kpi-blue">
                            <div class="kpi-head">
                                <span class="kpi-label">Completed Sales</span>
                                <div class="kpi-icon-box">
                                    <i class="fas fa-circle-check"></i>
                                </div>
                            </div>
                            <div class="kpi-number">{{ $statistics['completed_transactions'] ?? 0 }}</div>
                            <div class="kpi-meta">
                                <span class="kpi-tag kpi-tag-success">
                                    ₱{{ number_format($statistics['total_revenue'] ?? 0, 2) }}
                                </span>
                                <span>earned</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 4: Environmental Impact -->
                    <div class="col-6 col-lg-3">
                        <div class="kpi-card kpi-emerald">
                            <div class="kpi-head">
                                <span class="kpi-label">E-Waste Diverted</span>
                                <div class="kpi-icon-box">
                                    <i class="fas fa-leaf"></i>
                                </div>
                            </div>
                            <div class="kpi-number">{{ number_format($statistics['weight_diverted'] ?? 0, 1) }} <small style="font-size: 1rem; font-weight: 600;">kg</small></div>
                            <div class="kpi-meta">
                                <span class="kpi-tag kpi-tag-info">
                                    <i class="fas fa-earth-americas"></i> Landfill avoided
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Listings Workspace -->
            <section class="content-panel-card">
                <!-- Panel Toolbar -->
                <div class="panel-toolbar">
                    <div class="panel-title-wrap">
                        <h2 class="panel-title">
                            {{ ($isRecentView ?? false) ? 'Recent Listings' : 'All Listings Catalog' }}
                        </h2>
                        <span class="panel-badge-count">{{ $listings->total() }} items</span>
                    </div>

                    <!-- Filters and Search Toolbar -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <!-- Status Filter Tabs -->
                        <div class="filter-tabs-wrapper">
                            @php
                                $currentStatus = request('status', 'all');
                                $baseUrl = ($isRecentView ?? false) ? route('seller.dashboard') : route('seller.listings');
                            @endphp
                            <a href="{{ $baseUrl }}?status=all{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="filter-tab-btn {{ $currentStatus === 'all' || !$currentStatus ? 'active' : '' }}">
                                All
                            </a>
                            <a href="{{ $baseUrl }}?status=available{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="filter-tab-btn {{ $currentStatus === 'available' ? 'active' : '' }}">
                                Available
                            </a>
                            <a href="{{ $baseUrl }}?status=matched{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="filter-tab-btn {{ $currentStatus === 'matched' ? 'active' : '' }}">
                                Matched
                            </a>
                            <a href="{{ $baseUrl }}?status=processed{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}" 
                               class="filter-tab-btn {{ $currentStatus === 'processed' ? 'active' : '' }}">
                                Processed
                            </a>
                        </div>

                        <!-- Keyword Search Input -->
                        <form action="{{ $baseUrl }}" method="GET" class="d-flex align-items-center m-0">
                            @if(request('status') && request('status') !== 'all')
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="search-input-group">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search device..." class="search-input-control" autocomplete="off">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Listings Table -->
                @if($listings->count() > 0)
                    <div class="table-responsive-wrapper">
                        <table class="seller-table">
                            <thead>
                                <tr>
                                    <th>Item & Category</th>
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
                                        <!-- Item & Category -->
                                        <td>
                                            <div class="item-cell-wrap">
                                                <div class="item-thumb-box">
                                                    @if($primaryPhoto)
                                                        <img src="{{ $primaryPhoto }}" alt="{{ $categoryName }}" class="item-thumb-img" loading="lazy">
                                                    @else
                                                        <i class="fas fa-laptop item-thumb-icon"></i>
                                                    @endif
                                                </div>
                                                <div class="item-details-wrap">
                                                    <a href="{{ route('listings.show', $listing) }}" class="item-title">
                                                        {{ $categoryName }}
                                                        @if($brandName)
                                                            <span style="font-weight: 500; color: var(--seller-text-muted);">• {{ $brandName }}</span>
                                                        @endif
                                                    </a>
                                                    <div class="item-sub-tags">
                                                        <span class="badge-condition">
                                                            {{ str_replace('_', ' ', $listing->condition) }}
                                                        </span>
                                                        @if($listing->estimated_weight)
                                                            <span style="font-size: 0.72rem; color: #94a3b8;">
                                                                {{ number_format($listing->estimated_weight, 1) }} kg
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status Badge -->
                                        <td>
                                            @if($listing->status === 'available')
                                                <span class="badge-status badge-status-available">
                                                    <i class="fas fa-circle-check"></i> Available
                                                </span>
                                            @elseif($listing->status === 'matched')
                                                <span class="badge-status badge-status-matched">
                                                    <i class="fas fa-handshake"></i> Matched
                                                </span>
                                            @elseif($listing->status === 'processed')
                                                <span class="badge-status badge-status-processed">
                                                    <i class="fas fa-box-archive"></i> Processed
                                                </span>
                                            @else
                                                <span class="badge-status badge-status-pending">
                                                    <i class="fas fa-hourglass-half"></i> {{ ucfirst($listing->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Suggested Price -->
                                        <td>
                                            <span class="price-value">₱{{ number_format($listing->suggested_price, 2) }}</span>
                                        </td>

                                        <!-- Offers -->
                                        <td>
                                            @if($pendingOffers > 0)
                                                <a href="{{ route('listings.offers', $listing) }}" class="offers-pill has-pending" title="View pending offers">
                                                    <i class="fas fa-bell"></i> {{ $pendingOffers }} Pending
                                                </a>
                                            @elseif($totalOffers > 0)
                                                <a href="{{ route('listings.offers', $listing) }}" class="offers-pill" style="background: #f1f5f9; color: #475569;" title="View all offers">
                                                    <i class="fas fa-comments"></i> {{ $totalOffers }} Offers
                                                </a>
                                            @else
                                                <span class="offers-pill no-offers">—</span>
                                            @endif
                                        </td>

                                        <!-- Listed Date -->
                                        <td>
                                            <div style="font-weight: 600; color: #334155; font-size: 0.84rem;">
                                                {{ $listing->created_at->format('M d, Y') }}
                                            </div>
                                            <small style="color: #94a3b8; font-size: 0.74rem;">
                                                {{ $listing->created_at->diffForHumans() }}
                                            </small>
                                        </td>

                                        <!-- Action Buttons -->
                                        <td>
                                            <div class="action-group justify-content-end">
                                                <a href="{{ route('listings.show', $listing) }}" class="btn-action-icon" title="View Listing Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($listing->isAvailable())
                                                    <a href="{{ route('listings.edit', $listing) }}" class="btn-action-icon btn-action-edit" title="Edit Listing">
                                                        <i class="fas fa-pen-to-square"></i>
                                                    </a>
                                                @endif
                                                @if($totalOffers > 0)
                                                    <a href="{{ route('listings.offers', $listing) }}" class="btn-action-icon btn-action-offers" title="Manage Offers">
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
                        <div class="panel-footer-pagination">
                            <div style="font-size: 0.82rem; color: #64748b;">
                                Showing {{ $listings->firstItem() }} to {{ $listings->lastItem() }} of {{ $listings->total() }} items
                            </div>
                            <div>
                                {{ $listings->links('pagination.custom') }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="empty-state-wrap">
                        <div class="empty-icon-circle">
                            <i class="fas fa-box-open"></i>
                        </div>
                        @if(request('search') || (request('status') && request('status') !== 'all'))
                            <h3 class="empty-state-title">No Matching Listings Found</h3>
                            <p class="empty-state-desc">
                                We couldn't find any listings matching your current filter criteria. Try resetting your search or filters.
                            </p>
                            <a href="{{ ($isRecentView ?? false) ? route('seller.dashboard') : route('seller.listings') }}" class="btn-create-listing">
                                <i class="fas fa-rotate-left"></i> Reset Filters
                            </a>
                        @elseif($isRecentView ?? false)
                            <h3 class="empty-state-title">No Recent Listings</h3>
                            <p class="empty-state-desc">
                                You haven't created any listings in the last 24 hours. Explore your complete inventory history or publish a new device.
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('seller.listings') }}" class="btn-action-icon" style="width: auto; padding: 0.6rem 1.2rem; font-weight: 700;">
                                    <i class="fas fa-boxes-stacked me-1"></i> View All Listings
                                </a>
                                <a href="{{ route('listings.create') }}" class="btn-create-listing">
                                    <i class="fas fa-plus"></i> List New Device
                                </a>
                            </div>
                        @else
                            <h3 class="empty-state-title">Your Inventory is Empty</h3>
                            <p class="empty-state-desc">
                                Start listing your electronic waste items to connect with verified buyers and divert e-waste responsibly.
                            </p>
                            <a href="{{ route('listings.create') }}" class="btn-create-listing">
                                <i class="fas fa-plus"></i> Create First Listing
                            </a>
                        @endif
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
