@extends('layouts.app')

@section('title', 'Browse E-Waste Listings - E-Benta')

@section('content')
<style>
    /* === LISTINGS WRAPPER === */
    .ls-wrapper {
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 30%, #f0f9ff 70%, #f5f3ff 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
    }

    .ls-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse 800px 600px at 10% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse 600px 500px at 90% 80%, rgba(8, 145, 178, 0.08) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    /* === HEADER === */
    .ls-header {
        background: linear-gradient(135deg, #10b981 0%, #14b8a6 25%, #06b6d4 50%, #0891b2 100%);
        color: white;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid rgba(255, 255, 255, 0.2);
    }

    .ls-header::before {
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

    .ls-header::after {
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

    .ls-header-content {
        position: relative;
        z-index: 1;
    }

    .ls-header h1 {
        font-size: 2.8rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .ls-header p {
        opacity: 0.98;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* === FILTER SECTION === */
    .ls-filter-wrapper {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(6, 182, 212, 0.12) 100%);
        border: 2px solid rgba(16, 185, 129, 0.25);
        border-radius: 1.2rem;
        padding: 2.2rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        position: relative;
        overflow: hidden;
    }

    .ls-filter-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .ls-filter-title {
        color: #065f46;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 1.8rem;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .ls-filter-title i {
        color: #10b981;
    }

    .ls-filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: flex-end;
    }

    .ls-filter-group {
        display: flex;
        flex-direction: column;
    }

    .ls-filter-label {
        color: #065f46;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-size: 0.8rem;
        display: block;
        margin-bottom: 0.75rem;
    }

    .ls-filter-select {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        color: #065f46;
        border: 2px solid rgba(16, 185, 129, 0.3);
        padding: 0.85rem 1rem;
        border-radius: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .ls-filter-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1), 0 0 20px rgba(16, 185, 129, 0.25);
        background: #ffffff;
    }

    .ls-filter-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.85rem 2.2rem;
        font-weight: 800;
        border-radius: 0.7rem;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .ls-filter-btn:hover {
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        transform: translateY(-3px);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .ls-filter-btn:active {
        transform: translateY(-1px);
    }

    /* === STATS GRID === */
    .ls-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.8rem;
        margin-bottom: 2.5rem;
    }

    .ls-stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 2px solid;
        border-top-width: 5px;
        padding: 2rem 1.75rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .ls-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(ellipse 400px 300px at 50% 0%, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .ls-stat-card:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        transform: translateY(-6px);
    }

    .ls-stat-card.stat-total {
        border-top-color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }

    .ls-stat-card.stat-carbon {
        border-top-color: #06b6d4;
        border-color: rgba(6, 182, 212, 0.2);
    }

    .ls-stat-card.stat-available {
        border-top-color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
    }

    .ls-stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .ls-stat-card.stat-total .ls-stat-value {
        color: #10b981;
    }

    .ls-stat-card.stat-carbon .ls-stat-value {
        color: #06b6d4;
    }

    .ls-stat-card.stat-available .ls-stat-value {
        color: #8b5cf6;
    }

    .ls-stat-label {
        color: #4b5563;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        position: relative;
        z-index: 1;
    }

    /* === LISTINGS GRID === */
    .ls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .ls-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 1px solid rgb(200, 230, 201);
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .ls-card:hover {
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        transform: translateY(-3px);
        border-color: rgba(16, 185, 129, 0.4);
    }

    .ls-card-image {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(6, 182, 212, 0.1));
    }

    .ls-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .ls-card:hover .ls-card-image img {
        transform: scale(1.03);
    }

    .ls-card-no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
    }

    .ls-card-no-image i {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.6;
    }

    .ls-status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: inline-block;
        padding: 0.5rem 0.9rem;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        backdrop-filter: blur(4px);
    }

    .ls-status-available {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .ls-status-unavailable {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.95) 0%, rgba(126, 34, 206, 0.95) 100%);
        color: white;
    }

    .ls-card-body {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .ls-card-title {
        color: #065f46;
        font-weight: 800;
        margin-bottom: 0.75rem;
        font-size: 1.15rem;
        letter-spacing: -0.2px;
    }

    .ls-card-title i {
        color: #10b981;
        margin-right: 0.4rem;
    }

    .ls-card-description {
        color: #4b5563;
        font-size: 0.85rem;
        margin-bottom: 1rem;
        line-height: 1.5;
        font-weight: 500;
    }

    .ls-card-badges {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }

    .ls-badge {
        display: inline-block;
        padding: 0.4rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.7rem;
        border: 1px solid;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .ls-badge-condition {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.1) 100%);
        color: #065f46;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .ls-badge-action {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.2) 0%, rgba(6, 182, 212, 0.1) 100%);
        color: #0c4a6e;
        border-color: rgba(6, 182, 212, 0.3);
    }

    .ls-price-box {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%);
        border-left: 3px solid #10b981;
        padding: 0.85rem;
        border-radius: 0.6rem;
        margin-bottom: 0.85rem;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .ls-price-label {
        color: #4b5563;
        display: block;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.7rem;
        margin-bottom: 0.4rem;
    }

    .ls-price-value {
        color: #10b981;
        font-weight: 800;
        margin: 0;
        font-size: 1.25rem;
    }

    .ls-carbon-box {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
        border-left: 3px solid #06b6d4;
        padding: 0.85rem;
        border-radius: 0.6rem;
        margin-bottom: 0.85rem;
        border: 1px solid rgba(6, 182, 212, 0.2);
    }

    .ls-carbon-label {
        color: #4b5563;
        display: block;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.7rem;
        margin-bottom: 0.4rem;
    }

    .ls-carbon-value {
        color: #06b6d4;
        font-weight: 800;
        margin: 0;
        font-size: 1.15rem;
    }

    .ls-card-actions {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 0.5rem;
        margin-top: auto;
        flex-wrap: wrap;
    }

    .ls-action-form {
        margin: 0;
        display: flex;
        flex: 0 0 auto;
    }

    .ls-action-btn {
        flex: 1;
        padding: 0.65rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        position: relative;
        overflow: hidden;
    }

    .ls-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }

    .ls-action-btn:hover::before {
        left: 100%;
    }

    .ls-action-view {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
    }

    .ls-action-view:hover {
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
        transform: translateY(-2px);
    }

    .ls-action-offer {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .ls-action-offer:hover {
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        transform: translateY(-2px);
    }

    .ls-action-save {
        flex: 0 0 auto;
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.25);
        padding-inline: 0.85rem;
    }

    .ls-action-save:hover {
        box-shadow: 0 8px 22px rgba(236, 72, 153, 0.35);
        transform: translateY(-2px);
    }

    .ls-action-unsave {
        flex: 0 0 auto;
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(244, 63, 94, 0.25);
        padding-inline: 0.85rem;
    }

    .ls-action-unsave:hover {
        box-shadow: 0 8px 22px rgba(244, 63, 94, 0.35);
        transform: translateY(-2px);
    }

    .ls-card-footer {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
        border-top: 2px solid rgba(16, 185, 129, 0.15);
        padding: 1.2rem 1.8rem;
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .ls-card-footer i {
        color: #10b981;
        font-size: 1.4rem;
    }

    .ls-seller-info small {
        display: block;
    }

    .ls-seller-name {
        color: #065f46;
        font-weight: 800;
    }

    .ls-seller-date {
        color: #6b7280;
        font-size: 0.8rem;
    }

    /* === EMPTY STATE === */
    .ls-empty-state {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        border: 2px solid rgba(16, 185, 129, 0.25);
        color: #065f46;
        padding: 4.5rem 2rem;
        border-radius: 1.3rem;
        text-align: center;
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.15);
    }

    .ls-empty-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(6, 182, 212, 0.15) 100%);
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #10b981;
    }

    .ls-empty-title {
        color: #065f46;
        margin-bottom: 0.9rem;
        font-weight: 900;
        font-size: 1.5rem;
    }

    .ls-empty-text {
        color: #4b5563;
        margin: 0.9rem 0 2rem 0;
        font-size: 0.95rem;
    }

    .ls-empty-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        font-weight: 800;
        padding: 0.9rem 2rem;
        border-radius: 0.7rem;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .ls-empty-btn:hover {
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        transform: translateY(-3px);
    }

    /* === PAGINATION === */
    .ls-pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 3.5rem;
    }

    .ls-pagination-wrapper .pagination {
        gap: 0.4rem !important;
        margin-bottom: 0 !important;
    }

    .ls-pagination-wrapper .page-item {
        margin: 0 !important;
    }

    .ls-pagination-wrapper .page-link {
        padding: 0.6rem 0.9rem !important;
        font-size: 0.9rem !important;
        color: #10b981 !important;
        border: 2px solid rgba(16, 185, 129, 0.3) !important;
        border-radius: 0.6rem !important;
        background: white !important;
        transition: all 0.3s ease !important;
        font-weight: 700 !important;
    }

    .ls-pagination-wrapper .page-link:hover {
        background: rgba(16, 185, 129, 0.1) !important;
        color: #059669 !important;
        border-color: rgba(16, 185, 129, 0.5) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2) !important;
    }

    .ls-pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        border-color: #10b981 !important;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35) !important;
    }

    .ls-pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1 !important;
        background: #f1f5f9 !important;
        border-color: rgba(16, 185, 129, 0.15) !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }

    /* === DARK MODE === */
    body.dark-mode .ls-wrapper {
        background: linear-gradient(135deg, #1a3a2a 0%, #1a2a2a 30%, #1a2a3a 70%, #2a1a3a 100%);
    }

    body.dark-mode .ls-header {
        background: linear-gradient(135deg, #059669 0%, #0d9488 25%, #0891b2 50%, #0570a9 100%);
    }

    body.dark-mode .ls-filter-wrapper {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.3);
    }

    body.dark-mode .ls-filter-title {
        color: #2dd4bf;
    }

    body.dark-mode .ls-filter-label {
        color: #94a3b8;
    }

    body.dark-mode .ls-filter-select {
        background: #1e293b;
        border-color: rgba(13, 148, 136, 0.4);
        color: #f1f5f9;
    }

    body.dark-mode .ls-filter-select:focus {
        background: #0f172a;
        color: #ffffff;
    }

    body.dark-mode .ls-stat-card,
    body.dark-mode .ls-card {
        background: #2a2a2a;
        border-color: rgba(16, 185, 129, 0.2);
    }

    body.dark-mode .ls-card-title,
    body.dark-mode .ls-empty-title,
    body.dark-mode .ls-card-description {
        color: #e0e0e0;
    }

    body.dark-mode .ls-empty-state {
        background: #2a2a2a;
        border-color: rgba(16, 185, 129, 0.25);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .ls-header h1 {
            font-size: 2rem;
        }

        .ls-header p {
            font-size: 0.95rem;
        }

        .ls-stat-value {
            font-size: 2rem;
        }

        .ls-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .ls-filter-form {
            grid-template-columns: 1fr;
        }

        .ls-card-image {
            height: 240px;
        }

        .ls-price-value {
            font-size: 1.3rem;
        }

        .ls-filter-wrapper {
            padding: 1.5rem;
        }

        .ls-card-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .ls-header h1 {
            font-size: 1.5rem;
        }

        .ls-grid {
            grid-template-columns: 1fr;
            gap: 1.2rem;
        }

        .ls-stats-grid {
            gap: 1rem;
        }

        .ls-stat-value {
            font-size: 1.6rem;
        }

        .ls-card-image {
            height: 200px;
        }

        .ls-action-btn {
            font-size: 0.75rem;
            padding: 0.65rem;
        }
    }
</style>

<div class="ls-wrapper">
    <!-- Header -->
    <div class="ls-header">
        <div class="container-fluid">
            <div class="ls-header-content">
                <h1><i class="fas fa-search me-2"></i>Browse Listings</h1>
                <p>Discover e-waste items from responsible sellers and make a positive environmental impact</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid" style="padding: 0 2rem;">
        <!-- Filter Section -->
        <div class="ls-filter-wrapper">
            <h6 class="ls-filter-title"><i class="fas fa-sliders-h me-2"></i>Filter Options</h6>
            <form method="GET" action="{{ route('listings.index') }}" class="ls-filter-form">
                @if(request('seller_id'))
                    <input type="hidden" name="seller_id" value="{{ request('seller_id') }}">
                @endif
                <!-- Category Filter -->
                <div class="ls-filter-group">
                    <label class="ls-filter-label"><i class="fas fa-tags me-1"></i>Category</label>
                    <select name="category" class="ls-filter-select">
                        <option value="">All Categories</option>
                        <option value="Laptop" {{ request('category') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="Desktop" {{ request('category') == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="Smartphone" {{ request('category') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                        <option value="Tablet" {{ request('category') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="Monitor" {{ request('category') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                        <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Condition Filter -->
                <div class="ls-filter-group">
                    <label class="ls-filter-label"><i class="fas fa-circle-check me-1"></i>Condition</label>
                    <select name="condition" class="ls-filter-select">
                        <option value="">All Conditions</option>
                        <option value="working" {{ request('condition') == 'working' ? 'selected' : '' }}>Working</option>
                        <option value="minor_damage" {{ request('condition') == 'minor_damage' ? 'selected' : '' }}>Minor Damage</option>
                        <option value="major_damage" {{ request('condition') == 'major_damage' ? 'selected' : '' }}>Major Damage</option>
                        <option value="non_functional" {{ request('condition') == 'non_functional' ? 'selected' : '' }}>Non-functional</option>
                    </select>
                </div>

                <!-- Sort By Filter -->
                <div class="ls-filter-group">
                    <label class="ls-filter-label"><i class="fas fa-sort-amount-down me-1"></i>Sort By</label>
                    <select name="sort" class="ls-filter-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price (High to Low)</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div style="align-self: flex-end; width: 100%;">
                    <button type="submit" class="ls-filter-btn w-100"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                </div>
            </form>
        </div>

        @if(request('seller_id') && isset($filteredSeller) && $filteredSeller)
            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%); border: 1px solid rgba(16, 185, 129, 0.3); border-left: 4px solid #10b981; padding: 1rem 1.5rem; border-radius: 0.8rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-store" style="color: #10b981; font-size: 1.25rem;"></i>
                    <div>
                        <span style="color: #065f46; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Seller Filter Active</span>
                        <span style="color: #1f2937; font-weight: 800; font-size: 1.05rem;">Showing listings posted by <strong>{{ $filteredSeller->name }}</strong></span>
                    </div>
                </div>
                <a href="{{ route('listings.index') }}" class="btn btn-sm" style="background: white; color: #dc2626; border: 1px solid rgba(220, 38, 38, 0.3); font-weight: 700; padding: 0.45rem 1rem; border-radius: 0.5rem; text-decoration: none;">
                    <i class="fas fa-times me-1"></i>Clear Seller Filter
                </a>
            </div>
        @endif

        <!-- Inline Results Header Bar (Clean & Compact) -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 px-1">
            <div class="d-flex align-items-center gap-2">
                <h5 style="font-weight: 900; font-size: 1.25rem; margin: 0; color: #0f172a; font-family: 'Outfit', sans-serif;">
                    Available Devices
                </h5>
                <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 800; font-size: 0.82rem; border-radius: 2rem; padding: 0.4rem 0.85rem;">
                    {{ $listings->total() }} {{ Str::plural('Listing', $listings->total()) }}
                </span>
            </div>

            <div class="d-flex align-items-center gap-2" style="font-size: 0.85rem; font-weight: 700; color: #0d9488;">
                <i class="fas fa-leaf"></i>
                <span>Direct Verified Recycler & Seller Exchange</span>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="ls-grid">
            @forelse($listings as $listing)
                <div class="ls-card">
                    <!-- Image -->
                    <div class="ls-card-image">
                        @if($listing->photos && count(is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? []) > 0)
                            @php
                                $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                            @endphp
                            <img src="{{ $photos[0] }}" alt="Device">
                        @else
                            <div class="ls-card-no-image">
                                <i class="fas fa-image"></i>
                                <span>No Image</span>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        @if($listing->status == 'available')
                            <div class="ls-status-badge ls-status-available">
                                <i class="fas fa-check-circle me-1"></i>Available
                            </div>
                        @else
                            <div class="ls-status-badge ls-status-unavailable">
                                <i class="fas fa-lock me-1"></i>{{ ucfirst($listing->status) }}
                            </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="ls-card-body">
                        <!-- Title -->
                        <h5 class="ls-card-title">
                            <i class="fas fa-microchip me-2"></i>{{ $listing->category ?: ($listing->deviceType?->name ?: 'Uncategorized') }}
                        </h5>

                        <!-- Description -->
                        <p class="ls-card-description">{{ Str::limit($listing->description, 75) }}</p>

                        <!-- Badges -->
                        <div class="ls-card-badges">
                            <span class="ls-badge ls-badge-condition">
                                <i class="fas fa-check-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                            </span>
                            <span class="ls-badge ls-badge-action">
                                <i class="fas fa-target me-1"></i>{{ ucfirst(str_replace('_', ' ', $listing->intended_action)) }}
                            </span>
                        </div>

                        <!-- Price Box -->
                        <div class="ls-price-box">
                            <small class="ls-price-label">Price</small>
                            <p class="ls-price-value">
                                @if($listing->suggested_price > 0)
                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                @else
                                    <i class="fas fa-gift me-1"></i>Free
                                @endif
                            </p>
                        </div>

                        <!-- Carbon Impact Box -->
                        <div class="ls-carbon-box">
                            <small class="ls-carbon-label"><i class="fas fa-leaf me-1"></i>Environmental Impact</small>
                            <p class="ls-carbon-value">{{ $listing->carbon_footprint ?? 0 }} kg CO₂</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="ls-card-actions">
                            <a href="{{ route('listings.show', $listing) }}" class="ls-action-btn ls-action-view">
                                <i class="fas fa-eye"></i>View
                            </a>
                            @auth
                                @if(auth()->user()->isBuyer() && auth()->user()->is_verified)
                                    <a href="{{ route('offers.create', $listing) }}" class="ls-action-btn ls-action-offer">
                                        <i class="fas fa-handshake"></i>Offer
                                    </a>
                                @endif

                                @if(auth()->user()->isBuyer())
                                    @if($savedListingIds->contains($listing->id))
                                        <form method="POST" action="{{ route('buyer.saved-items.destroy', $listing) }}" class="ls-action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ls-action-btn ls-action-unsave" title="Remove from Saved Items">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('buyer.saved-items.store', $listing) }}" class="ls-action-form">
                                            @csrf
                                            <button type="submit" class="ls-action-btn ls-action-save" title="Save Item">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="ls-card-footer">
                        <i class="fas fa-user-circle" style="color: #10b981; font-size: 1.4rem;"></i>
                        <div>
                            <small class="ls-seller-name">{{ $listing->seller?->name ?? 'Unknown Seller' }}</small>
                            <small class="ls-seller-date">{{ $listing->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div style="grid-column: 1 / -1;">
                    <div class="ls-empty-state">
                        <div class="ls-empty-icon"><i class="fas fa-inbox"></i></div>
                        <h5 class="ls-empty-title">No Listings Found</h5>
                        <p class="ls-empty-text">Check back soon or try different filters to find available e-waste items.</p>
                        <a href="{{ route('listings.index') }}" class="ls-empty-btn">
                            <i class="fas fa-redo me-1"></i>Clear Filters
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($listings->hasPages())
            <div class="ls-pagination-wrapper">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
