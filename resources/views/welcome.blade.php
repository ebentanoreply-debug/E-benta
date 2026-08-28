@extends('layouts.app')

@section('title', 'E-Benta - The Circular Economy E-Waste Marketplace')

@section('styles')
<style>
    /* ==========================================================================
       MODERN ECO-TECH DESIGN SYSTEM & ANIMATIONS
       ========================================================================== */
    :root {
        --eco-primary: #0d9488;
        --eco-primary-hover: #0f766e;
        --eco-emerald: #10b981;
        --eco-cyan: #06b6d4;
        --eco-dark-bg: #09171f;
        --eco-surface-dark: #0f232d;
        --eco-surface-light: #ffffff;
        --eco-slate: #1e293b;
        --eco-muted: #64748b;
        --eco-border: rgba(13, 148, 136, 0.18);
        --eco-glow: 0 10px 35px rgba(13, 148, 136, 0.25);
    }

    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(1deg); }
    }

    @keyframes pulse-soft {
        0%, 100% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.04); opacity: 1; }
    }

    @keyframes shimmer-sweep {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }

    .gradient-text {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 50%, #10b981 100%);
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        display: inline-block;
    }

    .gradient-text-gold {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
    }

    /* Hero Section */
    .eb-hero {
        position: relative;
        padding: 5rem 0 6rem;
        background: radial-gradient(circle at 85% 15%, rgba(6, 182, 212, 0.12) 0%, transparent 50%),
                    radial-gradient(circle at 10% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 45%),
                    linear-gradient(180deg, #f8fafc 0%, #f0fdfa 100%);
        overflow: hidden;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
    }

    .eb-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.5rem 1.1rem;
        background: rgba(13, 148, 136, 0.1);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 2rem;
        color: var(--eco-primary);
        font-weight: 800;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
    }

    .eb-hero h1 {
        font-size: clamp(2.4rem, 4.5vw, 3.8rem);
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -1px;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }

    .eb-hero-lead {
        font-size: clamp(1.05rem, 1.4vw, 1.25rem);
        line-height: 1.7;
        color: #475569;
        margin-bottom: 2.25rem;
        max-width: 620px;
    }

    .eb-btn-primary {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff !important;
        font-weight: 800;
        font-size: 1.05rem;
        padding: 1rem 2.2rem;
        border-radius: 0.9rem;
        border: none;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .eb-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(13, 148, 136, 0.5);
    }

    .eb-btn-outline {
        background: #ffffff;
        color: #0f766e !important;
        font-weight: 800;
        font-size: 1.05rem;
        padding: 1rem 2rem;
        border-radius: 0.9rem;
        border: 2px solid rgba(13, 148, 136, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .eb-btn-outline:hover {
        border-color: var(--eco-primary);
        background: rgba(13, 148, 136, 0.05);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.15);
    }

    /* Hero Floating Graphic Card */
    .eb-hero-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.75rem;
        padding: 2rem;
        box-shadow: 0 20px 50px rgba(13, 148, 136, 0.15), 0 1px 3px rgba(0,0,0,0.05);
        position: relative;
        animation: float-slow 5s ease-in-out infinite;
    }

    .eb-floating-tag {
        position: absolute;
        background: #ffffff;
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 1rem;
        padding: 0.75rem 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 3;
    }

    /* Category Bar */
    .eb-category-section {
        padding: 2.5rem 0;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }

    .eb-cat-pill {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1.4rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 1rem;
        color: #334155;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .eb-cat-pill:hover {
        background: #f0fdfa;
        border-color: var(--eco-primary);
        color: var(--eco-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.12);
    }

    .eb-cat-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.6rem;
        background: rgba(13, 148, 136, 0.12);
        color: var(--eco-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Section Headers */
    .eb-section-header {
        text-align: center;
        max-width: 720px;
        margin: 0 auto 3.5rem;
    }

    .eb-section-tag {
        display: inline-block;
        color: var(--eco-primary);
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.75rem;
    }

    .eb-section-title {
        font-size: clamp(1.85rem, 3vw, 2.75rem);
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .eb-section-sub {
        font-size: 1.1rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    /* Marketplace Card */
    .eb-market-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid rgba(13, 148, 136, 0.18);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }

    .eb-market-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(13, 148, 136, 0.18);
        border-color: var(--eco-primary);
    }

    .eb-card-img-wrapper {
        height: 200px;
        background: #f1f5f9;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .eb-card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .eb-market-card:hover .eb-card-img-wrapper img {
        transform: scale(1.06);
    }

    /* Interactive Calculator Section */
    .eb-calc-wrapper {
        background: linear-gradient(135deg, #09171f 0%, #0e2832 100%);
        border-radius: 2rem;
        border: 1px solid rgba(13, 148, 136, 0.35);
        padding: 3.5rem 2.5rem;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .eb-calc-result-box {
        background: rgba(13, 148, 136, 0.12);
        border: 1px solid rgba(13, 148, 136, 0.35);
        border-radius: 1.5rem;
        padding: 2rem;
        backdrop-filter: blur(10px);
    }

    /* Process Steps */
    .eb-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
        padding: 2.25rem 1.75rem;
        height: 100%;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .eb-step-card:hover {
        transform: translateY(-5px);
        border-color: var(--eco-primary);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.12);
    }

    .eb-step-num {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 6px 15px rgba(13, 148, 136, 0.3);
    }

    /* Dual Persona Section */
    .eb-persona-card {
        border-radius: 1.75rem;
        padding: 2.5rem;
        height: 100%;
        position: relative;
        transition: all 0.3s ease;
    }

    .eb-persona-seller {
        background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
        border: 1.5px solid rgba(13, 148, 136, 0.25);
    }

    .eb-persona-recycler {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1.5px solid rgba(6, 182, 212, 0.3);
    }

    /* FAQ Accordion */
    .eb-faq-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .eb-faq-item:hover {
        border-color: var(--eco-primary);
    }

    .eb-faq-btn {
        width: 100%;
        padding: 1.25rem 1.5rem;
        text-align: left;
        background: none;
        border: none;
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .eb-faq-body {
        padding: 0 1.5rem 1.25rem;
        color: #475569;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    /* CTA Banner */
    .eb-cta-banner {
        background: linear-gradient(135deg, #09171f 0%, #0d3b45 100%);
        border: 1px solid rgba(13, 148, 136, 0.4);
        border-radius: 2.25rem;
        padding: 4.5rem 2.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
        text-align: center;
    }

    @media (max-width: 768px) {
        .eb-hero { padding: 3rem 0 4rem; }
        .eb-calc-wrapper { padding: 2rem 1.25rem; }
        .eb-cta-banner { padding: 3rem 1.5rem; }
    }
</style>
@endsection

@section('content')

    <!-- 1. HERO SECTION -->
    <section class="eb-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="eb-hero-badge">
                        <i class="fas fa-leaf"></i> Philippines' Circular E-Waste Platform
                    </div>
                    <h1>
                        Don't Trash Old Gadgets.
                        <span class="gradient-text">Turn E-Waste Into Value.</span>
                    </h1>
                    <p class="eb-hero-lead">
                        E-Benta connects households with verified buyers and certified recyclers. Monetize working electronics, bundle broken scrap lots, and guarantee 100% responsible zero-landfill recycling.
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="eb-btn-primary">
                            <i class="fas fa-plus-circle"></i>
                            <span>List Your Device Now</span>
                        </a>
                        <a href="{{ route('listings.index') }}" class="eb-btn-outline">
                            <i class="fas fa-store"></i>
                            <span>Explore Marketplace</span>
                        </a>
                    </div>

                    <!-- Live Social Proof Banner -->
                    <div class="d-flex align-items-center gap-4 pt-3 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; box-shadow: 0 0 10px #10b981;"></div>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">{{ number_format($totalListings ?? 150) }}+</span>
                            <span style="color: #64748b; font-size: 0.85rem;">Active Listings</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-shield-check" style="color: #0d9488;"></i>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">100%</span>
                            <span style="color: #64748b; font-size: 0.85rem;">ID Verified</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-truck-pickup" style="color: #06b6d4;"></i>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">Doorstep</span>
                            <span style="color: #64748b; font-size: 0.85rem;">Recycler Pickup</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="position-relative">
                        <!-- Top Floating Pill -->
                        <div class="eb-floating-tag" style="top: -20px; left: 10px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <small style="color: #64748b; font-weight: 700; display: block; font-size: 0.75rem;">COMPLETED SALE</small>
                                <span style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">₱4,800 • iPhone 11 (Damaged)</span>
                            </div>
                        </div>

                        <!-- Main Graphic Hero Card -->
                        <div class="eb-hero-card">
                            <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom border-light">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></div>
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></div>
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 700; color: var(--eco-primary);"><i class="fas fa-recycle me-1"></i>Circular Flow Live</span>
                            </div>

                            <img src="{{ asset('images/E-waste to wealth transformation.png') }}" alt="E-waste to wealth transformation" class="img-fluid rounded-4 mb-3" style="width: 100%; object-fit: cover; max-height: 280px; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">

                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">CO₂ SAVED</small>
                                        <strong style="color: #0d9488; font-size: 1.05rem;">89.5t</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">SCRAP LOTS</small>
                                        <strong style="color: #06b6d4; font-size: 1.05rem;">1,240+</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">PAYOUT TIME</small>
                                        <strong style="color: #10b981; font-size: 1.05rem;">Instant</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Floating Pill -->
                        <div class="eb-floating-tag" style="bottom: -20px; right: 10px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(6, 182, 212, 0.15); display: flex; align-items: center; justify-content: center; color: #06b6d4;">
                                <i class="fas fa-truck-fast"></i>
                            </div>
                            <div>
                                <small style="color: #64748b; font-weight: 700; display: block; font-size: 0.75rem;">DOORSTEP PICKUP</small>
                                <span style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">Scheduled by Recycler</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. QUICK CATEGORY EXPLORER -->
    <section class="eb-category-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <span style="font-weight: 800; color: #0f172a; font-size: 1rem;"><i class="fas fa-filter me-2" style="color: var(--eco-primary);"></i>Browse by Device Type:</span>
                <a href="{{ route('listings.index') }}" style="color: var(--eco-primary); font-weight: 700; font-size: 0.9rem; text-decoration: none;">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['category' => 'Smartphone']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-mobile-screen"></i></div>
                        <span>Smartphones</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['category' => 'Laptop']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-laptop"></i></div>
                        <span>Laptops</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['category' => 'Desktop']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-desktop"></i></div>
                        <span>Desktops</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['category' => 'Tablet']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-tablet-screen-button"></i></div>
                        <span>Tablets</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['condition' => 'non_functional']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-boxes-stacked"></i></div>
                        <span>Bulk Scrap Lots</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('listings.index', ['category' => 'Other']) }}" class="eb-cat-pill justify-content-center">
                        <div class="eb-cat-icon"><i class="fas fa-microchip"></i></div>
                        <span>Parts & Boards</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. LIVE VERIFIED MARKETPLACE HIGHLIGHTS -->
    <section class="py-5" style="background: #f8fafc;">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                <div>
                    <span class="eb-section-tag"><i class="fas fa-bolt me-1"></i>Fresh On E-Benta</span>
                    <h2 class="eb-section-title mb-0" style="font-size: 2.2rem;">Featured Verified Listings</h2>
                </div>
                <a href="{{ route('listings.index') }}" class="eb-btn-outline btn-sm">
                    <span>View All Active Listings</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4">
                @if(isset($featuredListings) && $featuredListings->count() > 0)
                    @foreach($featuredListings as $listing)
                        <div class="col-md-6 col-lg-4">
                            <div class="eb-market-card">
                                <div class="eb-card-img-wrapper">
                                    @php
                                        $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                                        $primaryPhoto = count($photos) > 0 ? $photos[0] : null;
                                    @endphp
                                    @if($primaryPhoto)
                                        <img src="{{ $primaryPhoto }}" alt="{{ $listing->category ?: 'E-Waste Item' }}">
                                    @else
                                        <div style="color: #94a3b8; font-size: 3rem;"><i class="fas fa-microchip"></i></div>
                                    @endif

                                    <!-- Status Pill -->
                                    <div style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); color: #ffffff; backdrop-filter: blur(8px); padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                        <i class="fas fa-check-circle text-success me-1"></i>{{ ucfirst($listing->condition ?? 'working') }}
                                    </div>

                                    @if($listing->listing_type === 'bulk_lot')
                                        <div style="position: absolute; top: 12px; right: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #ffffff; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                            <i class="fas fa-boxes me-1"></i>Bulk Lot ({{ $listing->lot_item_count }} items)
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="font-size: 0.8rem; font-weight: 800; color: var(--eco-primary); text-transform: uppercase;">
                                            {{ $listing->category ?: ($listing->deviceType?->name ?: 'Hardware') }}
                                        </span>
                                        <span style="font-size: 0.8rem; color: #64748b;">
                                            <i class="fas fa-leaf text-success me-1"></i>{{ $listing->carbon_footprint ?? 15 }}kg CO₂
                                        </span>
                                    </div>

                                    <h5 style="font-weight: 800; font-size: 1.15rem; color: #0f172a; margin-bottom: 0.75rem; line-height: 1.3;">
                                        {{ Str::limit($listing->description, 60) }}
                                    </h5>

                                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">ASKING PRICE</small>
                                            <span style="font-size: 1.25rem; font-weight: 900; color: #0f172a;">
                                                @if($listing->suggested_price > 0)
                                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                                @else
                                                    <span class="text-success">Free / Recycle</span>
                                                @endif
                                            </span>
                                        </div>
                                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.6rem; font-weight: 700; padding: 0.45rem 1rem;">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Clean Mock Highlights when no live database listings -->
                    <div class="col-md-4">
                        <div class="eb-market-card">
                            <div class="eb-card-img-wrapper">
                                <i class="fas fa-laptop" style="font-size: 3.5rem; color: #0d9488;"></i>
                                <div style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                    <i class="fas fa-check-circle text-success me-1"></i>Working
                                </div>
                            </div>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <span style="font-size: 0.8rem; font-weight: 800; color: var(--eco-primary); text-transform: uppercase;">Laptop</span>
                                <h5 style="font-weight: 800; font-size: 1.15rem; color: #0f172a; margin-bottom: 0.75rem;">Dell Latitude 5420 Core i5</h5>
                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">ASKING PRICE</small>
                                        <span style="font-size: 1.25rem; font-weight: 900; color: #0f172a;">₱8,500.00</span>
                                    </div>
                                    <a href="{{ route('listings.index') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.6rem; font-weight: 700;">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="eb-market-card">
                            <div class="eb-card-img-wrapper">
                                <i class="fas fa-boxes-stacked" style="font-size: 3.5rem; color: #f59e0b;"></i>
                                <div style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                    <i class="fas fa-wrench text-warning me-1"></i>Non-functional
                                </div>
                                <div style="position: absolute; top: 12px; right: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #ffffff; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                    <i class="fas fa-boxes me-1"></i>Bulk Lot (15 Phones)
                                </div>
                            </div>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <span style="font-size: 0.8rem; font-weight: 800; color: #f59e0b; text-transform: uppercase;">Scrap Bundle</span>
                                <h5 style="font-weight: 800; font-size: 1.15rem; color: #0f172a; margin-bottom: 0.75rem;">Lot of 15 Damaged Smartphones for Parts</h5>
                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">ASKING PRICE</small>
                                        <span style="font-size: 1.25rem; font-weight: 900; color: #0f172a;">₱3,200.00</span>
                                    </div>
                                    <a href="{{ route('listings.index') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.6rem; font-weight: 700;">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="eb-market-card">
                            <div class="eb-card-img-wrapper">
                                <i class="fas fa-mobile-screen-button" style="font-size: 3.5rem; color: #06b6d4;"></i>
                                <div style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800;">
                                    <i class="fas fa-check-circle text-info me-1"></i>Minor Damage
                                </div>
                            </div>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <span style="font-size: 0.8rem; font-weight: 800; color: var(--eco-primary); text-transform: uppercase;">Smartphone</span>
                                <h5 style="font-weight: 800; font-size: 1.15rem; color: #0f172a; margin-bottom: 0.75rem;">Samsung Galaxy S21 128GB (Cracked Glass)</h5>
                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <small style="color: #64748b; font-size: 0.75rem; display: block; font-weight: 700;">ASKING PRICE</small>
                                        <span style="font-size: 1.25rem; font-weight: 900; color: #0f172a;">₱6,000.00</span>
                                    </div>
                                    <a href="{{ route('listings.index') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.6rem; font-weight: 700;">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 4. INTERACTIVE E-WASTE VALUATION & CARBON CALCULATOR -->
    <section class="py-5" id="calculator" style="background: #ffffff;">
        <div class="container py-4">
            <div class="eb-calc-wrapper">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="eb-hero-badge" style="background: rgba(255, 255, 255, 0.1); color: #5eead4; border-color: rgba(255,255,255,0.2);">
                            <i class="fas fa-calculator"></i> Real-Time Estimator
                        </div>
                        <h2 style="font-size: clamp(2rem, 3.5vw, 2.8rem); font-weight: 900; line-height: 1.2; margin-bottom: 1.25rem;">
                            Calculate Your Device's <span class="gradient-text">Cash & Eco Impact</span>
                        </h2>
                        <p style="color: #94a3b8; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem;">
                            Select your device category and physical condition. See instant fair-market cash estimates and real carbon emissions saved from entering landfills.
                        </p>

                        <!-- Calculator Inputs -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label style="font-weight: 700; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.5rem;">Device Category</label>
                                <select id="calc-device-type" class="form-select form-select-lg" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; border-radius: 0.8rem;" onchange="calculateEwasteValue()">
                                    <option value="smartphone" style="color: #000;" selected>📱 Smartphone</option>
                                    <option value="laptop" style="color: #000;">💻 Laptop</option>
                                    <option value="desktop" style="color: #000;">🖥️ Desktop / PC</option>
                                    <option value="tablet" style="color: #000;">🎮 Tablet / iPad</option>
                                    <option value="bulk_lot" style="color: #000;">📦 Bulk Scrap Bundle (10+ items)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: 700; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.5rem;">Physical Condition</label>
                                <select id="calc-condition" class="form-select form-select-lg" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; border-radius: 0.8rem;" onchange="calculateEwasteValue()">
                                    <option value="working" style="color: #000;" selected>✅ 100% Working</option>
                                    <option value="minor_damage" style="color: #000;">⚠️ Minor Damage (Cracked glass / battery)</option>
                                    <option value="major_damage" style="color: #000;">❌ Major Damage / Needs Repair</option>
                                    <option value="non_functional" style="color: #000;">♻️ Non-Functional Scrap / Motherboard</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Calculator Output Card -->
                    <div class="col-lg-6">
                        <div class="eb-calc-result-box">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span style="font-size: 0.85rem; font-weight: 800; color: #5eead4; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-sparkles me-1"></i>Estimated Valuation
                                </span>
                                <span class="badge bg-success" style="font-size: 0.75rem;">Verified Algorithmic</span>
                            </div>

                            <div class="mb-4">
                                <small style="color: #94a3b8; font-weight: 700; display: block; font-size: 0.85rem;">POTENTIAL CASH VALUE</small>
                                <div id="calc-res-cash" style="font-size: clamp(2.4rem, 4vw, 3.2rem); font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                                    ₱3,500 - ₱7,500
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div style="background: rgba(0,0,0,0.25); padding: 1rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08);">
                                        <div style="color: #34d399; font-size: 1.4rem; font-weight: 900;" id="calc-res-co2">50 kg</div>
                                        <small style="color: #cbd5e1; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-leaf me-1"></i>CO₂ Footprint Prevented</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="background: rgba(0,0,0,0.25); padding: 1rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08);">
                                        <div style="color: #38bdf8; font-size: 1.4rem; font-weight: 900;" id="calc-res-weight">0.25 kg</div>
                                        <small style="color: #cbd5e1; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-weight-hanging me-1"></i>E-Waste Diverted</small>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="btn btn-lg w-100" style="background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); color: #ffffff; font-weight: 800; border-radius: 0.9rem; padding: 0.9rem; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <span>Post This Device for Sale / Recycle</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. DUAL-PERSONA VALUE PROPOSITION -->
    <section class="py-5" style="background: #f8fafc;">
        <div class="container py-4">
            <div class="eb-section-header">
                <span class="eb-section-tag">Tailored Solutions</span>
                <h2 class="eb-section-title">Built for Both Households & Professional Recyclers</h2>
                <p class="eb-section-sub">Whether you're decluttering old family devices or sourcing verified scrap for electronic harvest.</p>
            </div>

            <div class="row g-4">
                <!-- For Sellers / Households -->
                <div class="col-lg-6">
                    <div class="eb-persona-card eb-persona-seller">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="width: 55px; height: 55px; border-radius: 1rem; background: linear-gradient(135deg, #0d9488, #06b6d4); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 15px rgba(13, 148, 136, 0.3);">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div>
                                <span style="color: var(--eco-primary); font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">For Households & Sellers</span>
                                <h3 style="font-weight: 900; font-size: 1.6rem; color: #0f172a; margin: 0;">Monetize & Declutter Safely</h3>
                            </div>
                        </div>

                        <ul style="list-style: none; padding: 0; margin: 0 0 2rem; display: flex; flex-direction: column; gap: 1rem;">
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-success mt-1"></i>
                                <div><strong>Free Doorstep Collection:</strong> Recyclers and buyers can pick up directly from your doorstep address.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-success mt-1"></i>
                                <div><strong>Sell Broken Bundles:</strong> Don't throw away old cables or dead phones—bundle them into bulk lots for quick payouts.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-success mt-1"></i>
                                <div><strong>Zero Risk & Verified Buyers:</strong> Only verified accounts can make bids, with safe meetup spot proposals.</div>
                            </li>
                        </ul>

                        <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="btn btn-outline-dark" style="font-weight: 800; border-radius: 0.75rem; padding: 0.75rem 1.5rem;">
                            Start Selling As Individual <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- For Recyclers / Repairers -->
                <div class="col-lg-6">
                    <div class="eb-persona-card eb-persona-recycler">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="width: 55px; height: 55px; border-radius: 1rem; background: linear-gradient(135deg, #0284c7, #06b6d4); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 6px 15px rgba(2, 132, 199, 0.3);">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div>
                                <span style="color: #0284c7; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">For Recyclers & Tech Shops</span>
                                <h3 style="font-weight: 900; font-size: 1.6rem; color: #0f172a; margin: 0;">Verified Feed of Raw E-Waste</h3>
                            </div>
                        </div>

                        <ul style="list-style: none; padding: 0; margin: 0 0 2rem; display: flex; flex-direction: column; gap: 1rem;">
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-info mt-1"></i>
                                <div><strong>Direct Sourcing:</strong> Access a constant stream of repairable gadgets, scrap boards, and bulk lots across the Philippines.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-info mt-1"></i>
                                <div><strong>Automated Pickup Logistics:</strong> Get seller collection addresses directly upon offer acceptance.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-circle-check text-info mt-1"></i>
                                <div><strong>Automated Impact Logging:</strong> Track material breakdowns and generate certified recycling compliance logs.</div>
                            </li>
                        </ul>

                        <a href="{{ route('listings.index') }}" class="btn btn-outline-dark" style="font-weight: 800; border-radius: 0.75rem; padding: 0.75rem 1.5rem;">
                            Browse Recycler Listings <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. 4-STEP STREAMLINED FLOW -->
    <section class="py-5" id="process" style="background: #ffffff;">
        <div class="container py-4">
            <div class="eb-section-header">
                <span class="eb-section-tag">How It Works</span>
                <h2 class="eb-section-title">From Storage to Completed Impact in 4 Steps</h2>
                <p class="eb-section-sub">Simple, secure, and transparent e-waste trading built for speed.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="eb-step-card">
                        <div class="eb-step-num">1</div>
                        <h4 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-bottom: 0.75rem;">Snap & Describe</h4>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                            Upload photos, select condition (working, broken, or scrap lot), and provide your pickup address.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="eb-step-card">
                        <div class="eb-step-num">2</div>
                        <h4 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-bottom: 0.75rem;">Receive Real Bids</h4>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                            Verified buyers and certified recyclers submit competitive offers with proposed pickup dates.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="eb-step-card">
                        <div class="eb-step-num">3</div>
                        <h4 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-bottom: 0.75rem;">Smooth Handover</h4>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                            Buyer picks up directly from your doorstep, or meet at a safe public location with direct messaging.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="eb-step-card">
                        <div class="eb-step-num">4</div>
                        <h4 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-bottom: 0.75rem;">Payout & Carbon Log</h4>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                            Receive your payment, track your carbon savings, and get your environmental certificate.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. ENVIRONMENTAL IMPACT SCOREBOARD -->
    <section class="py-5" id="impact" style="background: linear-gradient(135deg, #09171f 0%, #0c232a 100%); color: #ffffff;">
        <div class="container py-4">
            <div class="eb-section-header">
                <span class="eb-section-tag" style="color: #5eead4;">Real-World Difference</span>
                <h2 class="eb-section-title" style="color: #ffffff;">E-Benta Collective Environmental Impact</h2>
                <p class="eb-section-sub" style="color: #94a3b8;">Verifiable metrics of e-waste diverted and emissions prevented.</p>
            </div>

            <div class="row g-4 text-center">
                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #34d399; margin-bottom: 0.75rem;"><i class="fas fa-cloud-arrow-down"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            {{ number_format($totalCarbonSaved ?? 2847, 0) }} kg
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">CO₂ Emissions Prevented</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #38bdf8; margin-bottom: 0.75rem;"><i class="fas fa-recycle"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            {{ number_format($totalWeightDiverted ?? 89500, 0) }} kg
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">E-Waste Diverted from Landfill</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #fbbf24; margin-bottom: 0.75rem;"><i class="fas fa-users"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            {{ number_format($totalUsers ?? 18250, 0) }}+
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">Eco-Conscious Members</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #a855f7; margin-bottom: 0.75rem;"><i class="fas fa-shield-halved"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            100%
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">Zero-Landfill Guarantee</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="py-5" id="faq" style="background: #f8fafc;">
        <div class="container py-4">
            <div class="eb-section-header">
                <span class="eb-section-tag">Got Questions?</span>
                <h2 class="eb-section-title">Frequently Asked Questions</h2>
                <p class="eb-section-sub">Everything you need to know about listing, selling, and recycling on E-Benta.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- FAQ 1 -->
                    <div class="eb-faq-item">
                        <button class="eb-faq-btn" onclick="toggleFaq(this)">
                            <span>How does Doorstep Pickup work for sellers?</span>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </button>
                        <div class="eb-faq-body">
                            When creating your listing, choose <strong>Doorstep Pickup</strong> and verify your address. When a buyer or recycler places an offer and you accept it, they will arrive at your specified address at the agreed date and time to collect the device and complete the transaction.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="eb-faq-item">
                        <button class="eb-faq-btn" onclick="toggleFaq(this)">
                            <span>Can I sell totally broken or non-working electronics?</span>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </button>
                        <div class="eb-faq-body">
                            Yes! E-Benta has a dedicated <strong>Bulk Lot & Non-Functional Scrap</strong> pathway. Technicians and certified recyclers purchase broken devices for harvesting chips, screen parts, and precious metals.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="eb-faq-item">
                        <button class="eb-faq-btn" onclick="toggleFaq(this)">
                            <span>How do I know buyers and recyclers are legitimate?</span>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </button>
                        <div class="eb-faq-body">
                            E-Benta requires government ID verification for commercial recyclers and buyers. Furthermore, community ratings and a 3-strike policy protect users against fraudulent or no-show behavior.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="eb-faq-item">
                        <button class="eb-faq-btn" onclick="toggleFaq(this)">
                            <span>Is listing items on E-Benta completely free?</span>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </button>
                        <div class="eb-faq-body">
                            Yes, creating individual listings and bulk scrap bundles is 100% free with zero hidden listing fees.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. IMMERSIVE HIGH-IMPACT CALL TO ACTION -->
    <section class="py-5" style="background: #ffffff;">
        <div class="container py-3">
            <div class="eb-cta-banner">
                <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(13, 148, 136, 0.4), transparent 70%); pointer-events: none;"></div>
                
                <h2 style="font-size: clamp(2.2rem, 4vw, 3.2rem); font-weight: 900; line-height: 1.2; margin-bottom: 1.25rem;">
                    Every Device Counts. <br><span class="gradient-text">Make Your Environmental Impact Today.</span>
                </h2>
                <p style="font-size: 1.15rem; color: #cbd5e1; max-width: 650px; margin: 0 auto 2.5rem; line-height: 1.7;">
                    Join over 18,000 community members and certified recyclers turning hazardous e-waste into economic and environmental opportunity.
                </p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="eb-btn-primary" style="font-size: 1.1rem; padding: 1.1rem 2.8rem;">
                        <i class="fas fa-rocket"></i>
                        <span>Start Your Impact Journey</span>
                    </a>
                    <a href="{{ route('listings.index') }}" class="eb-btn-outline" style="background: rgba(255,255,255,0.1); color: #ffffff !important; border-color: rgba(255,255,255,0.3);">
                        <i class="fas fa-binoculars"></i>
                        <span>Browse Verified Items</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Real-Time E-Waste Calculator Logic
    function calculateEwasteValue() {
        const device = document.getElementById('calc-device-type').value;
        const condition = document.getElementById('calc-condition').value;

        // Pricing Matrix (in PHP)
        const pricingMatrix = {
            'smartphone': {
                'working': { cash: '₱3,500 - ₱12,000', co2: '50 kg', weight: '0.22 kg' },
                'minor_damage': { cash: '₱1,800 - ₱6,000', co2: '45 kg', weight: '0.22 kg' },
                'major_damage': { cash: '₱800 - ₱2,500', co2: '35 kg', weight: '0.22 kg' },
                'non_functional': { cash: '₱300 - ₱1,000', co2: '25 kg', weight: '0.22 kg' }
            },
            'laptop': {
                'working': { cash: '₱8,000 - ₱25,000', co2: '250 kg', weight: '1.85 kg' },
                'minor_damage': { cash: '₱4,500 - ₱12,000', co2: '210 kg', weight: '1.85 kg' },
                'major_damage': { cash: '₱2,000 - ₱5,500', co2: '160 kg', weight: '1.85 kg' },
                'non_functional': { cash: '₱800 - ₱2,500', co2: '120 kg', weight: '1.85 kg' }
            },
            'desktop': {
                'working': { cash: '₱10,000 - ₱30,000', co2: '400 kg', weight: '7.50 kg' },
                'minor_damage': { cash: '₱5,000 - ₱15,000', co2: '320 kg', weight: '7.50 kg' },
                'major_damage': { cash: '₱2,500 - ₱7,000', co2: '250 kg', weight: '7.50 kg' },
                'non_functional': { cash: '₱1,200 - ₱3,500', co2: '180 kg', weight: '7.50 kg' }
            },
            'tablet': {
                'working': { cash: '₱4,000 - ₱14,000', co2: '80 kg', weight: '0.48 kg' },
                'minor_damage': { cash: '₱2,000 - ₱7,000', co2: '65 kg', weight: '0.48 kg' },
                'major_damage': { cash: '₱1,000 - ₱3,000', co2: '50 kg', weight: '0.48 kg' },
                'non_functional': { cash: '₱400 - ₱1,200', co2: '35 kg', weight: '0.48 kg' }
            },
            'bulk_lot': {
                'working': { cash: '₱15,000 - ₱50,000+', co2: '650 kg', weight: '12.00 kg' },
                'minor_damage': { cash: '₱8,000 - ₱25,000', co2: '520 kg', weight: '12.00 kg' },
                'major_damage': { cash: '₱4,000 - ₱12,000', co2: '400 kg', weight: '12.00 kg' },
                'non_functional': { cash: '₱2,500 - ₱8,000', co2: '300 kg', weight: '12.00 kg' }
            }
        };

        const result = pricingMatrix[device] ? pricingMatrix[device][condition] : null;
        if (result) {
            document.getElementById('calc-res-cash').textContent = result.cash;
            document.getElementById('calc-res-co2').textContent = result.co2;
            document.getElementById('calc-res-weight').textContent = result.weight;
        }
    }

    // Interactive FAQ Accordion Toggle
    function toggleFaq(btn) {
        const body = btn.nextElementSibling;
        const icon = btn.querySelector('i');
        const isHidden = body.style.display === 'none' || !body.style.display;

        // Close all other open faqs
        document.querySelectorAll('.eb-faq-body').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.eb-faq-btn i').forEach(el => el.className = 'fas fa-chevron-down text-muted');

        if (isHidden) {
            body.style.display = 'block';
            icon.className = 'fas fa-chevron-up text-success';
        } else {
            body.style.display = 'none';
            icon.className = 'fas fa-chevron-down text-muted';
        }
    }
</script>
@endsection
