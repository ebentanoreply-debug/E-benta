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

    /* E-Commerce Circular Category Explorer */
    .eb-circle-cat-section {
        background: #ffffff;
        padding: 2.2rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .eb-circle-cat-list {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        overflow-x: auto;
        padding: 0.5rem 0.25rem;
        scrollbar-width: none;
    }
    .eb-circle-cat-list::-webkit-scrollbar {
        display: none;
    }
    .eb-circle-cat-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        flex-shrink: 0;
        width: 100px;
        transition: transform 0.25s ease;
    }
    .eb-circle-cat-card:hover {
        transform: translateY(-4px);
    }
    .eb-circle-bubble {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 100%);
        border: 2px solid rgba(13, 148, 136, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        color: var(--eco-primary);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin-bottom: 0.55rem;
        position: relative;
    }
    .eb-circle-cat-card:hover .eb-circle-bubble {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.4);
        transform: scale(1.08);
    }
    .eb-circle-name {
        font-size: 0.82rem;
        font-weight: 800;
        color: #1e293b;
        text-align: center;
        line-height: 1.25;
    }

    /* Flash Deals & Offers Ribbon */
    .eb-flash-banner {
        background: linear-gradient(135deg, #09171f 0%, #172554 50%, #0c4a6e 100%);
        border-radius: 1.5rem;
        border: 1px solid rgba(6, 182, 212, 0.35);
        padding: 2rem;
        color: #ffffff;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .eb-flash-banner::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; width: 300px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }
    .eb-flash-badge {
        background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        color: #ffffff;
        font-weight: 900;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    }
    .eb-timer-ticker {
        background: rgba(0, 0, 0, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 0.6rem;
        padding: 0.3rem 0.75rem;
        font-family: monospace;
        font-weight: 800;
        font-size: 0.95rem;
        color: #38bdf8;
        letter-spacing: 1px;
    }

    /* Modern E-Commerce Product Card V2 */
    .eb-pcard {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        position: relative;
    }
    .eb-pcard:hover {
        transform: translateY(-6px);
        border-color: #0d9488;
        box-shadow: 0 16px 36px rgba(13, 148, 136, 0.16);
    }
    .eb-pcard-media {
        height: 210px;
        background: #f8fafc;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .eb-pcard-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .eb-pcard:hover .eb-pcard-media img {
        transform: scale(1.08);
    }
    .eb-pcard-wishlist {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 5;
    }
    .eb-pcard-wishlist:hover, .eb-pcard-wishlist.active {
        color: #f43f5e;
        transform: scale(1.12);
        background: #ffffff;
    }
    .eb-pcard-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.25rem 0.65rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        backdrop-filter: blur(8px);
        z-index: 2;
    }
    .eb-pcard-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .eb-pcard-price {
        font-size: 1.3rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
    }

    /* Tab Switcher */
    .eb-market-tabs .nav-link {
        color: #64748b !important;
        font-weight: 800;
        font-size: 0.95rem;
        padding: 0.65rem 1.4rem;
        border-radius: 2rem;
        border: 1.5px solid transparent;
        transition: all 0.2s ease;
    }
    .eb-market-tabs .nav-link.active {
        background: #0f172a;
        color: #ffffff !important;
        border-color: #0f172a;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
    }
    .eb-market-tabs .nav-link:hover:not(.active) {
        border-color: #cbd5e1;
        color: #0f172a !important;
    }

    /* Trust Guarantee Pillars */
    .eb-trust-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%);
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 2.5rem 0;
    }
    .eb-trust-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .eb-trust-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.85rem;
        background: rgba(13, 148, 136, 0.12);
        color: var(--eco-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .eb-hero { padding: 3rem 0 4rem; }
        .eb-calc-wrapper { padding: 2rem 1.25rem; }
        .eb-cta-banner { padding: 3rem 1.5rem; }
    }
</style>
@endsection

@section('content')

    <!-- 1. HERO SECTION & MARKETPLACE SHOWCASE -->
    <section class="eb-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="eb-hero-badge">
                        <i class="fas fa-bolt text-warning me-1"></i> Philippines' #1 Circular Tech Marketplace
                    </div>
                    <h1>
                        Buy Refurbished Tech.
                        <span class="gradient-text">Recycle E-Waste for Cash.</span>
                    </h1>
                    <p class="eb-hero-lead">
                        Discover certified refurbished electronics at up to 70% off retail, or monetize old hardware and bulk salvage lots with verified local recyclers.
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('listings.index') }}" class="eb-btn-primary">
                            <i class="fas fa-store"></i>
                            <span>Explore Tech Deals</span>
                        </a>
                        <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="eb-btn-outline">
                            <i class="fas fa-recycle text-success"></i>
                            <span>Sell / Recycle a Device</span>
                        </a>
                    </div>

                    <!-- Search Shortcuts / Trending Keywords -->
                    @php
                        $trendingBrands = \App\Models\DeviceBrand::take(4)->get();
                    @endphp
                    @if($trendingBrands->count() > 0)
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-4" style="font-size: 0.85rem;">
                            <span style="color: #64748b; font-weight: 700;"><i class="fas fa-arrow-trend-up me-1 text-teal-600" style="color: #0d9488;"></i>Trending Brands:</span>
                            @foreach($trendingBrands as $tBrand)
                                <a href="{{ route('listings.index', ['brand' => $tBrand->name]) }}" class="badge rounded-pill bg-white text-dark text-decoration-none border shadow-sm px-3 py-2">{{ $tBrand->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Live Social Proof Banner -->
                    <div class="d-flex align-items-center gap-4 pt-2 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; box-shadow: 0 0 10px #10b981;"></div>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">{{ number_format($totalListings) }}</span>
                            <span style="color: #64748b; font-size: 0.85rem;">Active Deals</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-shield-check" style="color: #0d9488;"></i>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">100%</span>
                            <span style="color: #64748b; font-size: 0.85rem;">Escrow Protected</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-truck-pickup" style="color: #06b6d4;"></i>
                            <span style="font-weight: 800; font-size: 0.95rem; color: #0f172a;">Doorstep</span>
                            <span style="color: #64748b; font-size: 0.85rem;">Pickup Available</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="position-relative">
                        @php
                            $heroListing = $featuredListings->first() ?? $flashDeals->first();
                        @endphp

                        @if($heroListing)
                            <!-- Top Floating Pill -->
                            <div class="eb-floating-tag" style="top: -20px; left: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981;">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div>
                                    <small style="color: #64748b; font-weight: 700; display: block; font-size: 0.72rem;">ACTIVE HARDWARE</small>
                                    <span style="font-weight: 800; color: #0f172a; font-size: 0.92rem;">
                                        @if($heroListing->suggested_price > 0)
                                            ₱{{ number_format($heroListing->suggested_price, 2) }}
                                        @else
                                            FREE
                                        @endif
                                        • {{ $heroListing->deviceBrand?->name ? $heroListing->deviceBrand->name . ' ' : '' }}{{ $heroListing->deviceModel?->model_name ?: ($heroListing->category ?: ($heroListing->deviceType?->name ?: 'Item')) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Main Graphic Hero Card -->
                        <div class="eb-hero-card">
                            <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom border-light">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></div>
                                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></div>
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 800; color: var(--eco-primary);"><i class="fas fa-recycle me-1"></i>Circular Flow Live</span>
                            </div>

                            <img src="{{ asset('images/E-waste to wealth transformation.png') }}" alt="E-waste to wealth transformation" class="img-fluid rounded-4 mb-3" style="width: 100%; object-fit: cover; max-height: 280px; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">

                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.72rem; display: block; font-weight: 700;">CO₂ SAVED</small>
                                        <strong style="color: #0d9488; font-size: 1.05rem;">{{ number_format($totalCarbonSaved, 1) }} kg</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.72rem; display: block; font-weight: 700;">ACTIVE SELLERS</small>
                                        <strong style="color: #06b6d4; font-size: 1.05rem;">{{ number_format($totalUsers) }}</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                        <small style="color: #64748b; font-size: 0.72rem; display: block; font-weight: 700;">LANDFILL DIVERTED</small>
                                        <strong style="color: #10b981; font-size: 1.05rem;">{{ number_format($totalWeightDiverted, 1) }} kg</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($heroListing && $heroListing->pickup_address)
                            <!-- Bottom Floating Pill -->
                            <div class="eb-floating-tag" style="bottom: -20px; right: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(6, 182, 212, 0.15); display: flex; align-items: center; justify-content: center; color: #06b6d4;">
                                    <i class="fas fa-truck-fast"></i>
                                </div>
                                <div>
                                    <small style="color: #64748b; font-weight: 700; display: block; font-size: 0.72rem;">DOORSTEP PICKUP</small>
                                    <span style="font-weight: 800; color: #0f172a; font-size: 0.92rem;">{{ Str::limit($heroListing->pickup_address, 26) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. CIRCULAR CATEGORY EXPLORER (Shopee/Lazada Marketplace Style) -->
    <section class="eb-circle-cat-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="font-weight: 800; color: #0f172a; font-size: 1.05rem; margin: 0;">
                    <i class="fas fa-grid-2 me-2" style="color: var(--eco-primary);"></i>Browse Categories
                </h6>
                <a href="{{ route('listings.index') }}" style="color: var(--eco-primary); font-weight: 700; font-size: 0.88rem; text-decoration: none;">
                    All Categories <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            @php
                $welcomeCategories = \App\Models\DeviceType::orderBy('name')->take(8)->get();
            @endphp
            <div class="eb-circle-cat-list">
                @foreach($welcomeCategories as $wCat)
                    <a href="{{ route('listings.index', ['category' => $wCat->name]) }}" class="eb-circle-cat-card">
                        <div class="eb-circle-bubble">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <span class="eb-circle-name">{{ $wCat->name }}</span>
                    </a>
                @endforeach
                <a href="{{ route('listings.index', ['condition' => 'functional']) }}" class="eb-circle-cat-card">
                    <div class="eb-circle-bubble">
                        <i class="fas fa-certificate" style="color: #10b981;"></i>
                    </div>
                    <span class="eb-circle-name">Certified Working</span>
                </a>
                <a href="{{ route('listings.index', ['condition' => 'repairable']) }}" class="eb-circle-cat-card">
                    <div class="eb-circle-bubble">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <span class="eb-circle-name">Repairable</span>
                </a>
                <a href="{{ route('listings.index', ['condition' => 'for_parts']) }}" class="eb-circle-cat-card">
                    <div class="eb-circle-bubble">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <span class="eb-circle-name">Scrap & Parts</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. FLASH DEALS & LIMITED-TIME OFFERS RIBBON -->
    @if(isset($flashDeals) && $flashDeals->count() > 0)
        <section class="py-4" style="background: #ffffff;">
            <div class="container">
                <div class="eb-flash-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="eb-flash-badge"><i class="fas fa-bolt"></i> FLASH DEALS</span>
                            <h4 class="mb-0 fw-bold text-white d-none d-md-inline">Limited-Time Tech & Salvage Deals</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size: 0.85rem; color: #cbd5e1; font-weight: 600;">Ends in:</span>
                            <div class="eb-timer-ticker" id="flash-countdown">04:18:29</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        @foreach($flashDeals as $deal)
                            @php
                                $photos = is_array($deal->photos) ? $deal->photos : json_decode($deal->photos, true) ?? [];
                                $photo = count($photos) > 0 ? $photos[0] : null;
                                $isSaved = isset($savedListingIds) && $savedListingIds->contains($deal->id);
                            @endphp
                            <div class="col-6 col-md-3">
                                <div class="eb-pcard bg-white text-dark h-100">
                                    <div class="eb-pcard-media" style="height: 160px;">
                                        @if($photo)
                                            <img src="{{ $photo }}" alt="{{ $deal->category }}">
                                        @else
                                            <i class="fas fa-microchip text-teal-600" style="font-size: 2.5rem; color: #0d9488;"></i>
                                        @endif
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fw-bold" style="font-size: 0.68rem;">
                                            HOT DEAL
                                        </span>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <span style="font-size: 0.72rem; font-weight: 800; color: #0d9488; text-transform: uppercase;">
                                            {{ $deal->category ?: ($deal->deviceType?->name ?: 'Hardware') }}
                                        </span>
                                        <a href="{{ route('listings.show', $deal) }}" class="text-decoration-none text-dark fw-bold mb-2" style="font-size: 0.9rem; line-height: 1.3; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $deal->device_details ?: ($deal->description ? Str::limit($deal->description, 45) : 'Tech Listing') }}
                                        </a>
                                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                            <div>
                                                <span class="eb-pcard-price" style="font-size: 1.15rem; color: #ea580c;">
                                                    ₱{{ number_format($deal->suggested_price, 2) }}
                                                </span>
                                            </div>
                                            <a href="{{ route('listings.show', $deal) }}" class="btn btn-sm btn-dark px-2 py-1" style="font-size: 0.78rem; font-weight: 700; border-radius: 0.5rem;">
                                                Buy
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 4. CURATED MARKETPLACE CATALOG SHOWCASE WITH TABS -->
    <section class="py-5" style="background: #f8fafc;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                <div>
                    <span class="eb-section-tag"><i class="fas fa-sparkles me-1"></i>Curated Catalog</span>
                    <h2 class="eb-section-title mb-0" style="font-size: 2.1rem;">Explore E-Benta Marketplace</h2>
                </div>
                <!-- Catalog Tabs -->
                <ul class="nav eb-market-tabs gap-2" id="marketplaceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured-pane" type="button" role="tab">
                            🔥 Trending Finds
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="salvage-tab" data-bs-toggle="tab" data-bs-target="#salvage-pane" type="button" role="tab">
                            🛠️ Salvage & Scrap Lots
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content Panes -->
            <div class="tab-content" id="marketplaceTabContent">
                <!-- Pane 1: Featured Trending Tech -->
                <div class="tab-pane fade show active" id="featured-pane" role="tabpanel" tabindex="0">
                    <div class="row g-4">
                        @if(isset($featuredListings) && $featuredListings->count() > 0)
                            @foreach($featuredListings as $listing)
                                @php
                                    $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                                    $primaryPhoto = count($photos) > 0 ? $photos[0] : null;
                                    $isSaved = isset($savedListingIds) && $savedListingIds->contains($listing->id);
                                @endphp
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="eb-pcard">
                                        <div class="eb-pcard-media">
                                            @if($primaryPhoto)
                                                <img src="{{ $primaryPhoto }}" alt="{{ $listing->category ?: 'Item' }}">
                                            @else
                                                <div style="color: #94a3b8; font-size: 3rem;"><i class="fas fa-microchip"></i></div>
                                            @endif

                                            <!-- Condition Pill -->
                                            <span class="eb-pcard-badge {{ $listing->condition === 'functional' ? 'eb-condition-functional' : ($listing->condition === 'repairable' ? 'eb-condition-repairable' : 'eb-condition-for_parts') }}">
                                                {{ str_replace('_', ' ', ucfirst($listing->condition ?? 'working')) }}
                                            </span>

                                            <!-- Wishlist Button -->
                                            @auth
                                                @if(auth()->user()->isBuyer())
                                                    <form method="POST" action="{{ $isSaved ? route('buyer.saved-items.destroy', $listing) : route('buyer.saved-items.store', $listing) }}" style="display: inline;">
                                                        @csrf
                                                        @if($isSaved)
                                                            @method('DELETE')
                                                        @endif
                                                        <button type="submit" class="eb-pcard-wishlist {{ $isSaved ? 'active' : '' }}" title="{{ $isSaved ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                                            <i class="fas fa-heart"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="eb-pcard-wishlist" title="Log in to save">
                                                    <i class="far fa-heart"></i>
                                                </a>
                                            @endauth
                                        </div>

                                        <div class="eb-pcard-body">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span style="font-size: 0.75rem; font-weight: 800; color: var(--eco-primary); text-transform: uppercase;">
                                                    {{ $listing->category ?: ($listing->deviceType?->name ?: 'Device') }}
                                                </span>
                                                @if($listing->carbon_footprint)
                                                    <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">
                                                        <i class="fas fa-leaf me-1"></i>-{{ $listing->carbon_footprint }}kg CO₂
                                                    </span>
                                                @endif
                                            </div>

                                            <h6 style="font-weight: 800; font-size: 0.98rem; color: #0f172a; margin-bottom: 0.5rem; line-height: 1.35; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                <a href="{{ route('listings.show', $listing) }}" class="text-decoration-none text-dark">
                                                    {{ $listing->device_details ?: ($listing->description ? Str::limit($listing->description, 55) : 'E-Waste Item') }}
                                                </a>
                                            </h6>

                                            <!-- Seller Tag -->
                                            <div class="d-flex align-items-center gap-1 mb-3" style="font-size: 0.78rem; color: #64748b;">
                                                <i class="fas fa-circle-check text-teal-600" style="color: #0d9488;"></i>
                                                <span class="text-truncate">{{ $listing->seller?->name ?? 'Verified Seller' }}</span>
                                            </div>

                                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small style="color: #64748b; font-size: 0.7rem; display: block; font-weight: 700;">ASKING</small>
                                                    <span class="eb-pcard-price">
                                                        @if($listing->suggested_price > 0)
                                                            ₱{{ number_format($listing->suggested_price, 2) }}
                                                        @else
                                                            <span class="text-success" style="font-size: 0.95rem;">Free / Scrap</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); border: none; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 0.6rem;">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-boxes-stacked" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                                <h5 class="fw-bold text-dark">No live listings yet</h5>
                                <p class="text-muted">Be the first to list an electronic device!</p>
                                <a href="{{ route('listings.create') }}" class="btn btn-primary fw-bold">List Tech Device</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pane 2: Salvage & Scrap Lots -->
                <div class="tab-pane fade" id="salvage-pane" role="tabpanel" tabindex="0">
                    <div class="row g-4">
                        @if(isset($salvageLots) && $salvageLots->count() > 0)
                            @foreach($salvageLots as $lot)
                                @php
                                    $photos = is_array($lot->photos) ? $lot->photos : json_decode($lot->photos, true) ?? [];
                                    $primaryPhoto = count($photos) > 0 ? $photos[0] : null;
                                    $isSaved = isset($savedListingIds) && $savedListingIds->contains($lot->id);
                                @endphp
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="eb-pcard">
                                        <div class="eb-pcard-media">
                                            @if($primaryPhoto)
                                                <img src="{{ $primaryPhoto }}" alt="{{ $lot->category ?: 'Salvage Lot' }}">
                                            @else
                                                <div style="color: #94a3b8; font-size: 3rem;"><i class="fas fa-boxes-stacked"></i></div>
                                            @endif
                                            <span class="eb-pcard-badge eb-condition-for_parts">
                                                {{ $lot->condition === 'repairable' ? 'Repairable' : 'For Parts / Scrap' }}
                                            </span>
                                        </div>

                                        <div class="eb-pcard-body">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span style="font-size: 0.75rem; font-weight: 800; color: #f59e0b; text-transform: uppercase;">
                                                    {{ $lot->listing_type === 'bulk_lot' ? 'Bulk Lot ('.$lot->lot_item_count.' pcs)' : ($lot->category ?: 'Hardware') }}
                                                </span>
                                                @if($lot->estimated_weight)
                                                    <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">
                                                        <i class="fas fa-weight-hanging me-1"></i>{{ $lot->estimated_weight }}kg
                                                    </span>
                                                @endif
                                            </div>

                                            <h6 style="font-weight: 800; font-size: 0.98rem; color: #0f172a; margin-bottom: 0.5rem; line-height: 1.35; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                <a href="{{ route('listings.show', $lot) }}" class="text-decoration-none text-dark">
                                                    {{ $lot->device_details ?: ($lot->description ? Str::limit($lot->description, 55) : 'Salvage Lot') }}
                                                </a>
                                            </h6>

                                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small style="color: #64748b; font-size: 0.7rem; display: block; font-weight: 700;">SALVAGE VALUE</small>
                                                    <span class="eb-pcard-price">₱{{ number_format($lot->suggested_price, 2) }}</span>
                                                </div>
                                                <a href="{{ route('listings.show', $lot) }}" class="btn btn-sm btn-outline-dark" style="font-weight: 800; border-radius: 0.6rem;">
                                                    Offer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">No salvage lots currently available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- View All Marketplace Catalog CTA -->
            <div class="text-center mt-5">
                <a href="{{ route('listings.index') }}" class="btn btn-lg px-5 py-3 fw-bold" style="background: #0f172a; color: #ffffff; border-radius: 1rem; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.25);">
                    <i class="fas fa-store me-2" style="color: #2dd4bf;"></i>Browse All 100+ Catalog Products
                </a>
            </div>
        </div>
    </section>

    <!-- 5. E-COMMERCE 4-PILLAR TRUST GUARANTEE -->
    <section class="eb-trust-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="eb-trust-item">
                        <div class="eb-trust-icon">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 0.95rem;">Escrow Protection</h6>
                            <small style="color: #64748b; font-size: 0.8rem;">Funds secured until pickup verification</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="eb-trust-item">
                        <div class="eb-trust-icon">
                            <i class="fas fa-truck-ramp-box"></i>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 0.95rem;">Doorstep Recycler Pickup</h6>
                            <small style="color: #64748b; font-size: 0.8rem;">Schedule hassle-free collection</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="eb-trust-item">
                        <div class="eb-trust-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 0.95rem;">Eco-Impact Certificate</h6>
                            <small style="color: #64748b; font-size: 0.8rem;">Official CO₂ & landfill diversion proof</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="eb-trust-item">
                        <div class="eb-trust-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h6 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 0.95rem;">Dedicated Support</h6>
                            <small style="color: #64748b; font-size: 0.8rem;">Active dispute mediation team</small>
                        </div>
                    </div>
                </div>
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
                                    @foreach(\App\Models\DeviceType::orderBy('name')->get() as $cIdx => $cType)
                                        <option value="{{ strtolower($cType->name) }}" style="color: #000;" {{ $cIdx === 0 ? 'selected' : '' }}>{{ $cType->name }}</option>
                                    @endforeach
                                    <option value="bulk_lot" style="color: #000;">Bulk Scrap Bundle</option>
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
                            {{ number_format($totalCarbonSaved, 0) }} kg
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">CO₂ Emissions Prevented</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #38bdf8; margin-bottom: 0.75rem;"><i class="fas fa-recycle"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            {{ number_format($totalWeightDiverted, 0) }} kg
                        </div>
                        <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">E-Waste Diverted from Landfill</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 1.5rem; padding: 2.25rem 1.5rem; backdrop-filter: blur(10px);">
                        <div style="font-size: 2.5rem; color: #fbbf24; margin-bottom: 0.75rem;"><i class="fas fa-users"></i></div>
                        <div style="font-size: 2.4rem; font-weight: 900; color: #ffffff; font-family: 'Outfit', sans-serif;">
                            {{ number_format($totalUsers, 0) }}
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
                    Join {{ $totalUsers > 0 ? number_format($totalUsers) . ' ' : '' }}community members and certified recyclers turning hazardous e-waste into economic and environmental opportunity.
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

    // Flash Deal Countdown Timer
    function startFlashTimer() {
        let totalSeconds = 4 * 3600 + 18 * 60 + 29;
        const timerEl = document.getElementById('flash-countdown');
        if (!timerEl) return;
        
        setInterval(() => {
            if (totalSeconds <= 0) totalSeconds = 12 * 3600;
            totalSeconds--;
            const h = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const s = String(totalSeconds % 60).padStart(2, '0');
            timerEl.textContent = `${h}:${m}:${s}`;
        }, 1000);
    }
    document.addEventListener('DOMContentLoaded', startFlashTimer);

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
