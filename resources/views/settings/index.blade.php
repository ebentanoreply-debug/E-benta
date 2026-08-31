@extends('layouts.app')

@section('title', 'Settings — E-Benta')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* ─── SETTINGS LAYOUT & CONTAINER ─────────────────────────────────────────── */
.stt-page {
    min-height: 100vh;
    background: #f8fafc;
    padding-bottom: 4rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

body.dark-mode .stt-page {
    background: #09171f;
}

/* ─── HERO HEADER ─────────────────────────────────────────── */
.stt-hero-header {
    background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
    border-bottom: 1px solid rgba(13, 148, 136, 0.25);
    color: #ffffff;
    padding: 2.25rem 0 2rem;
    position: relative;
    overflow: hidden;
}

.stt-hero-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(13, 148, 136, 0.15) 0%, transparent 70%);
    pointer-events: none;
}

.stt-wrapper {
    display: grid;
    grid-template-columns: 290px 1fr;
    gap: 1.75rem;
    max-width: 1400px;
    margin: 2rem auto 0;
    padding: 0 1.5rem;
}

/* ─── SETTINGS SIDEBAR NAV ─────────────────────────────────────────── */
.stt-sidebar {
    position: sticky;
    top: 85px;
    height: fit-content;
}

.stt-user-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 1.75rem 1.25rem;
    text-align: center;
    margin-bottom: 1rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
}

body.dark-mode .stt-user-card {
    background: #0f232d;
    border-color: rgba(13, 148, 136, 0.2);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
}

.stt-avatar-wrap {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
}

.stt-avatar-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #0d9488;
    box-shadow: 0 4px 15px rgba(13, 148, 136, 0.25);
}

.stt-avatar-default {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 900;
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
}

.stt-avatar-edit {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #0d9488, #06b6d4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    font-size: 0.7rem;
    color: white;
    border: 2px solid #ffffff;
    transition: transform 0.2s;
}

body.dark-mode .stt-avatar-edit {
    border-color: #0f232d;
}

.stt-avatar-edit:hover { transform: scale(1.15); color: white; }

.stt-user-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

body.dark-mode .stt-user-name {
    color: #f1f5f9;
}

.stt-user-email {
    font-size: 0.8rem;
    color: #64748b;
    margin-bottom: 0.75rem;
    word-break: break-all;
}

.stt-badge-row {
    display: flex;
    gap: 0.4rem;
    justify-content: center;
    flex-wrap: wrap;
}

.stt-badge {
    font-size: 0.7rem;
    font-weight: 800;
    padding: 0.25rem 0.65rem;
    border-radius: 99px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.stt-badge-admin { background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); }
.stt-badge-seller { background: rgba(13, 148, 136, 0.15); color: #0d9488; border: 1px solid rgba(13, 148, 136, 0.3); }
.stt-badge-buyer { background: rgba(6, 182, 212, 0.15); color: #0284c7; border: 1px solid rgba(6, 182, 212, 0.3); }
.stt-badge-verified { background: rgba(34, 197, 94, 0.15); color: #16a34a; border: 1px solid rgba(34, 197, 94, 0.3); }
.stt-badge-unverified { background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.3); }

/* Settings Nav Menu */
.stt-nav {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 0.75rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
}

body.dark-mode .stt-nav {
    background: #0f232d;
    border-color: rgba(13, 148, 136, 0.2);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
}

.stt-nav-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.85rem 1rem;
    border-radius: 0.85rem;
    color: #475569;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
    margin-bottom: 0.25rem;
}

body.dark-mode .stt-nav-item {
    color: #94a3b8;
}

.stt-nav-item:hover {
    background: rgba(13, 148, 136, 0.08);
    color: #0d9488;
    border-left-color: rgba(13, 148, 136, 0.4);
    transform: translateX(3px);
}

body.dark-mode .stt-nav-item:hover {
    background: rgba(13, 148, 136, 0.15);
    color: #2dd4bf;
}

.stt-nav-item.active {
    background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
    color: #0d9488;
    font-weight: 800;
    border-left-color: #0d9488;
}

body.dark-mode .stt-nav-item.active {
    background: linear-gradient(135deg, rgba(13, 148, 136, 0.25) 0%, rgba(6, 182, 212, 0.15) 100%);
    color: #2dd4bf;
    border-left-color: #2dd4bf;
}

.stt-nav-item i {
    width: 20px;
    text-align: center;
    font-size: 1rem;
}

.stt-nav-badge {
    margin-left: auto;
    font-size: 0.65rem;
    padding: 0.15rem 0.5rem;
    border-radius: 99px;
    font-weight: 800;
}

.stt-nav-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 0.5rem 0;
}

body.dark-mode .stt-nav-divider {
    background: rgba(255, 255, 255, 0.08);
}

/* ─── CONTENT PANELS ─────────────────────────────────────────── */
.stt-panel {
    display: none;
}

.stt-panel.active {
    display: block;
    animation: stt-fade 0.25s ease;
}

@keyframes stt-fade {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.stt-panel-header {
    margin-bottom: 1.5rem;
}

.stt-panel-title {
    font-size: 1.5rem;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin-bottom: 0.25rem;
}

body.dark-mode .stt-panel-title {
    color: #ffffff;
}

.stt-panel-title span {
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stt-panel-sub {
    color: #64748b;
    font-size: 0.88rem;
    margin: 0;
}

body.dark-mode .stt-panel-sub {
    color: #94a3b8;
}

/* ─── CARDS ───────────────────────────────────────────── */
.stt-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
}

body.dark-mode .stt-card {
    background: #0f232d;
    border-color: rgba(13, 148, 136, 0.2);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
}

.stt-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #ffffff;
}

body.dark-mode .stt-card-header {
    background: #0f232d;
    border-bottom-color: rgba(255, 255, 255, 0.06);
}

.stt-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}

.stt-card-icon.teal { background: rgba(13, 148, 136, 0.12); color: #0d9488; }
.stt-card-icon.blue { background: rgba(6, 182, 212, 0.12); color: #0284c7; }
.stt-card-icon.purple { background: rgba(168, 85, 247, 0.12); color: #9333ea; }
.stt-card-icon.amber { background: rgba(245, 158, 11, 0.12); color: #d97706; }
.stt-card-icon.rose { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
.stt-card-icon.green { background: rgba(34, 197, 94, 0.12); color: #16a34a; }

.stt-card-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 0.15rem;
}

body.dark-mode .stt-card-title {
    color: #f1f5f9;
}

.stt-card-sub {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0;
}

body.dark-mode .stt-card-sub {
    color: #94a3b8;
}

.stt-card-body {
    padding: 1.5rem;
}

/* ─── FORM ELEMENTS ──────────────────────────────────── */
.stt-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #475569;
    letter-spacing: 0.4px;
    margin-bottom: 0.45rem;
    display: block;
    text-transform: uppercase;
}

body.dark-mode .stt-label {
    color: #94a3b8;
}

.stt-input {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    color: #0f172a;
    font-size: 0.9rem;
    font-family: inherit;
    transition: all 0.2s ease;
    outline: none;
}

body.dark-mode .stt-input {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.12);
    color: #f1f5f9;
}

.stt-input::placeholder { color: #94a3b8; }
.stt-input:focus {
    border-color: #0d9488;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
}

body.dark-mode .stt-input:focus {
    background: rgba(255, 255, 255, 0.08);
}

.stt-btn {
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    color: #ffffff;
    font-weight: 800;
    font-size: 0.88rem;
    border: none;
    border-radius: 0.75rem;
    padding: 0.7rem 1.4rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
    text-decoration: none;
}

.stt-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(13, 148, 136, 0.45);
    color: #ffffff;
}

.stt-btn-ghost {
    background: rgba(13, 148, 136, 0.1);
    color: #0d9488;
    font-weight: 800;
    font-size: 0.88rem;
    border: 1px solid rgba(13, 148, 136, 0.25);
    border-radius: 0.75rem;
    padding: 0.7rem 1.25rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

body.dark-mode .stt-btn-ghost {
    background: rgba(13, 148, 136, 0.15);
    color: #2dd4bf;
    border-color: rgba(13, 148, 136, 0.35);
}

.stt-btn-ghost:hover {
    background: rgba(13, 148, 136, 0.2);
    color: #0d9488;
}

.stt-btn-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    font-weight: 800;
    font-size: 0.85rem;
    border: 1px solid rgba(239, 68, 68, 0.25);
    border-radius: 0.65rem;
    padding: 0.6rem 1.1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.stt-btn-danger:hover {
    background: #ef4444;
    color: #ffffff;
}

.stt-form-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid #f1f5f9;
}

body.dark-mode .stt-form-footer {
    border-top-color: rgba(255, 255, 255, 0.06);
}

/* ─── TOGGLE SWITCH ──────────────────────────────────── */
.stt-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-radius: 0.85rem;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    margin-bottom: 0.75rem;
}

body.dark-mode .stt-toggle-row {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.06);
}

.stt-toggle-info {
    flex: 1;
    padding-right: 1.5rem;
}

.stt-toggle-label {
    font-weight: 700;
    font-size: 0.92rem;
    color: #0f172a;
    display: block;
}

body.dark-mode .stt-toggle-label {
    color: #e2e8f0;
}

.stt-toggle-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.15rem;
    display: block;
}

body.dark-mode .stt-toggle-desc {
    color: #94a3b8;
}

.stt-toggle {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
    cursor: pointer;
}

.stt-toggle input { opacity: 0; width: 0; height: 0; }

.stt-toggle-track {
    position: absolute;
    inset: 0;
    background: #cbd5e1;
    border-radius: 24px;
    transition: 0.25s ease;
}

body.dark-mode .stt-toggle-track {
    background: rgba(255, 255, 255, 0.15);
}

.stt-toggle-thumb {
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: 0.25s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.stt-toggle input:checked + .stt-toggle-track {
    background: #0d9488;
}

.stt-toggle input:checked + .stt-toggle-track .stt-toggle-thumb {
    transform: translateX(20px);
}

/* ─── PRIVACY SHIELD ─────────────────────────────────── */
.stt-shield-row {
    display: flex;
    gap: 0.85rem;
    margin-bottom: 1.25rem;
}

.stt-shield-opt {
    flex: 1;
    padding: 1.25rem;
    border-radius: 1rem;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

body.dark-mode .stt-shield-opt {
    border-color: rgba(255, 255, 255, 0.08);
    background: rgba(255, 255, 255, 0.03);
}

.stt-shield-opt:hover {
    border-color: #0d9488;
    background: rgba(13, 148, 136, 0.04);
}

.stt-shield-opt.selected {
    border-color: #0d9488;
    background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%);
}

.stt-shield-opt i { font-size: 1.5rem; margin-bottom: 0.5rem; display: block; color: #0d9488; }
.stt-shield-opt-label { font-size: 0.95rem; font-weight: 800; color: #0f172a; }
body.dark-mode .stt-shield-opt-label { color: #f1f5f9; }
.stt-shield-opt-sub { font-size: 0.78rem; color: #64748b; margin-top: 0.25rem; }

/* ─── PAYMENT METHODS ─────────────────────────────────── */
.stt-payment-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.1rem 1.25rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    margin-bottom: 1rem;
}

body.dark-mode .stt-payment-method {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.08);
}

.stt-payment-logo {
    width: 44px;
    height: 44px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 900;
    flex-shrink: 0;
}

.stt-payment-logo.gcash { background: rgba(0, 114, 187, 0.12); color: #0284c7; }
.stt-payment-logo.bank { background: rgba(245, 158, 11, 0.12); color: #d97706; }

.stt-payment-info { flex: 1; }
.stt-payment-name { font-size: 0.95rem; font-weight: 800; color: #0f172a; }
body.dark-mode .stt-payment-name { color: #f1f5f9; }
.stt-payment-status { font-size: 0.8rem; color: #64748b; margin-top: 0.15rem; }

/* ─── SELLER STATS GRID ─────────────────────────────────── */
.stt-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stt-stat {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.25rem 1rem;
    text-align: center;
}

body.dark-mode .stt-stat {
    background: #0f232d;
    border-color: rgba(13, 148, 136, 0.2);
}

.stt-stat-value {
    font-size: 1.5rem;
    font-weight: 900;
    color: #0d9488;
    display: block;
}

.stt-stat-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    margin-top: 0.25rem;
    display: block;
}

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 991.98px) {
    .stt-wrapper {
        grid-template-columns: 1fr;
        padding: 0 1rem;
        margin-top: 1.25rem;
    }
    .stt-sidebar { position: static; }
    .stt-user-card { display: flex; align-items: center; gap: 1.25rem; text-align: left; }
    .stt-avatar-wrap { margin: 0; }
    .stt-badge-row { justify-content: flex-start; }
    .stt-nav { display: flex; flex-wrap: wrap; gap: 0.4rem; padding: 0.5rem; }
    .stt-nav-item { width: auto; border-radius: 0.75rem; border-left: none; padding: 0.6rem 0.85rem; font-size: 0.82rem; }
    .stt-nav-item:hover, .stt-nav-item.active { transform: none; }
    .stt-nav-divider { display: none; }
    .stt-nav-badge { display: none; }
}
</style>
@endsection

@section('content')

{{-- Include Active Role Workspace Sidebar --}}
@if(auth()->user()->isAdmin())
    @include('admin.sidebar')
@elseif(auth()->user()->isSeller())
    @include('seller.sidebar')
@else
    @include('buyer.sidebar')
@endif

<div class="main-content-wrapper">
    <div class="stt-page">

        {{-- HERO HEADER --}}
        <div class="stt-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if(auth()->user()->isAdmin())
                                <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-shield-halved me-1"></i>Admin Workspace
                                </span>
                            @elseif(auth()->user()->isSeller())
                                <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-store me-1"></i>Seller Hub
                                </span>
                            @else
                                <span class="badge" style="background: rgba(6, 182, 212, 0.2); color: #38bdf8; border: 1px solid rgba(6, 182, 212, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-shopping-bag me-1"></i>Buyer Hub
                                </span>
                            @endif
                            <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #e2e8f0; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-sliders me-1"></i>Configuration
                            </span>
                        </div>
                        <h1 style="font-size: clamp(1.4rem, 2.5vw, 1.85rem); font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.5px;">
                            {{ auth()->user()->isAdmin() ? 'System Settings & Preferences' : 'Account Settings & Preferences' }}
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.35rem 0 0 0;">
                            {{ auth()->user()->isAdmin() ? 'Manage administrative credentials, system notification channels, and platform configurations.' : 'Manage your personal profile, notification preferences, ID verification, and payout accounts.' }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard')) }}" class="btn btn-outline-light btn-sm" style="border-radius: 0.65rem; font-weight: 700; padding: 0.55rem 1.1rem; border-color: rgba(255,255,255,0.25);">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stt-wrapper">

            {{-- ─── SETTINGS INNER SIDEBAR ─────────────────────────────────────── --}}
            <aside class="stt-sidebar">

                {{-- User mini profile card --}}
                <div class="stt-user-card">
                    <div class="stt-avatar-wrap">
                        @if(auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="stt-avatar-img">
                        @else
                            <div class="stt-avatar-default">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                        <label for="sttAvatarFileQuick" class="stt-avatar-edit" title="Change photo">
                            <i class="fas fa-camera"></i>
                        </label>
                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="sttAvatarFormQuick" style="display:none;">
                            @csrf
                            <input type="file" id="sttAvatarFileQuick" name="avatar" accept="image/*" onchange="document.getElementById('sttAvatarFormQuick').submit()">
                        </form>
                    </div>
                    <div>
                        <div class="stt-user-name">{{ auth()->user()->name }}</div>
                        <div class="stt-user-email">{{ auth()->user()->email }}</div>
                        <div class="stt-badge-row">
                            @if(auth()->user()->isAdmin())
                                <span class="stt-badge stt-badge-admin"><i class="fas fa-shield-halved me-1"></i>Admin</span>
                            @elseif(auth()->user()->isSeller())
                                <span class="stt-badge stt-badge-seller"><i class="fas fa-store me-1"></i>Seller</span>
                            @elseif(auth()->user()->isBuyer())
                                <span class="stt-badge stt-badge-buyer"><i class="fas fa-shopping-bag me-1"></i>Buyer</span>
                            @endif

                            @if(auth()->user()->is_verified)
                                <span class="stt-badge stt-badge-verified"><i class="fas fa-check-circle me-1"></i>Verified</span>
                            @else
                                <span class="stt-badge stt-badge-unverified"><i class="fas fa-clock me-1"></i>Pending ID</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tab navigation buttons --}}
                <nav class="stt-nav">
                    <button class="stt-nav-item active" onclick="sttSwitch('account', this)">
                        <i class="fas fa-user-circle"></i> Account Details
                    </button>
                    <button class="stt-nav-item" onclick="sttSwitch('notifications', this)">
                        <i class="fas fa-bell"></i> Notifications
                    </button>
                    <button class="stt-nav-item" onclick="sttSwitch('privacy', this)">
                        <i class="fas fa-lock"></i> Privacy & Security
                    </button>
                    @if(!auth()->user()->isAdmin())
                    <button class="stt-nav-item" onclick="sttSwitch('id-verification', this)">
                        <i class="fas fa-id-card"></i> ID Verification
                        @if(auth()->user()->isIdVerified())
                            <span class="stt-nav-badge" style="background: rgba(34,197,94,0.15); color: #16a34a; border: 1px solid rgba(34,197,94,0.3);">Verified</span>
                        @elseif(auth()->user()->isIdPending())
                            <span class="stt-nav-badge" style="background: rgba(245,158,11,0.15); color: #d97706; border: 1px solid rgba(245,158,11,0.3);">Pending</span>
                        @endif
                    </button>
                    <button class="stt-nav-item" onclick="sttSwitch('payments', this)">
                        <i class="fas fa-credit-card"></i> Payout & Banking
                    </button>
                    @endif
                    @if(auth()->user()->isSeller())
                    <div class="stt-nav-divider"></div>
                    <button class="stt-nav-item" onclick="sttSwitch('seller', this)">
                        <i class="fas fa-store"></i> Seller Profile
                        <span class="stt-nav-badge" style="background: rgba(13,148,136,0.15); color: #0d9488;">Seller</span>
                    </button>
                    @endif
                    <div class="stt-nav-divider"></div>
                    <button class="stt-nav-item" onclick="sttSwitch('preferences', this)">
                        <i class="fas fa-sliders-h"></i> Preferences
                    </button>
                </nav>
            </aside>

            {{-- ─── MAIN CONTENT ────────────────────────────────── --}}
            <main class="stt-content" style="min-width: 0;">

                {{-- ════════════════════════════════════════════════
                     TAB 1: ACCOUNT DETAILS
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-account" class="stt-panel active">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Account <span>Settings</span></h2>
                        <p class="stt-panel-sub">Update your personal details, profile image, and contact information.</p>
                    </div>

                    {{-- Profile picture card --}}
                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon teal"><i class="fas fa-camera"></i></div>
                            <div>
                                <p class="stt-card-title">Profile Picture</p>
                                <p class="stt-card-sub">Upload a high-resolution avatar. JPG, PNG or WEBP up to 2MB.</p>
                            </div>
                            <div style="margin-left: auto; display: flex; gap: 0.6rem; align-items: center;">
                                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="sttAvatarForm">
                                    @csrf
                                    <label for="sttAvatarFile" class="stt-btn" style="cursor: pointer; margin: 0;">
                                        <i class="fas fa-upload"></i>Upload Photo
                                    </label>
                                    <input type="file" id="sttAvatarFile" name="avatar" accept="image/*" style="display: none" onchange="document.getElementById('sttAvatarForm').submit()">
                                </form>
                                @if(auth()->user()->avatar)
                                <form action="{{ route('profile.avatar.delete') }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="stt-btn-danger"><i class="fas fa-trash"></i>Remove</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Personal details form --}}
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon blue"><i class="fas fa-id-card"></i></div>
                                <div>
                                    <p class="stt-card-title">Personal Information</p>
                                    <p class="stt-card-sub">Manage your name, contact phone, and operating location.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="stt-label">Full Name</label>
                                        <input type="text" name="name" class="stt-input @error('name') is-invalid @enderror"
                                            value="{{ old('name', auth()->user()->name) }}" required>
                                        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">Phone Number</label>
                                        <input type="tel" name="phone" class="stt-input @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="09XXXXXXXXX">
                                        @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">City</label>
                                        <input type="text" name="address_city" class="stt-input @error('address_city') is-invalid @enderror"
                                            value="{{ old('address_city', auth()->user()->address_city) }}" placeholder="e.g. Makati">
                                        @error('address_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">Province / Region</label>
                                        <input type="text" name="address_province" class="stt-input @error('address_province') is-invalid @enderror"
                                            value="{{ old('address_province', auth()->user()->address_province) }}" placeholder="e.g. Metro Manila">
                                        @error('address_province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    @if(auth()->user()->isSeller() || auth()->user()->isBuyer())
                                    <div class="col-md-12">
                                        <label class="stt-label">{{ auth()->user()->isSeller() ? 'Business Name' : 'Organization Name' }}</label>
                                        <input type="text" name="business_name" class="stt-input @error('business_name') is-invalid @enderror"
                                            value="{{ old('business_name', auth()->user()->business_name) }}" placeholder="Your store or company name">
                                        @error('business_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    @endif
                                    <div class="col-12">
                                        <label class="stt-label">Bio / Profile Description</label>
                                        <textarea name="business_description" class="stt-input @error('business_description') is-invalid @enderror"
                                            rows="3" placeholder="Tell members about yourself...">{{ old('business_description', auth()->user()->business_description) }}</textarea>
                                        @error('business_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="stt-form-footer">
                                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ════════════════════════════════════════════════
                     TAB 2: NOTIFICATIONS
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-notifications" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Notification <span>Preferences</span></h2>
                        <p class="stt-panel-sub">Control your delivery channels and event notifications.</p>
                    </div>

                    <form method="POST" action="{{ route('settings.notifications.update') }}">
                        @csrf @method('PUT')
                        @php $u = auth()->user(); @endphp
                        <input type="hidden" name="email_notifications" id="hi_email" value="{{ $u->email_notifications ? 1 : 0 }}">
                        <input type="hidden" name="sms_notifications" id="hi_sms" value="{{ $u->sms_notifications ? 1 : 0 }}">
                        <input type="hidden" name="marketing_updates" id="hi_marketing" value="{{ $u->marketing_updates ? 1 : 0 }}">
                        <input type="hidden" name="notify_new_offer" id="hi_offer" value="{{ $u->notify_new_offer ? 1 : 0 }}">
                        <input type="hidden" name="notify_transaction_complete" id="hi_txn" value="{{ $u->notify_transaction_complete ? 1 : 0 }}">
                        <input type="hidden" name="notify_new_message" id="hi_msg" value="{{ $u->notify_new_message ? 1 : 0 }}">
                        <input type="hidden" name="notify_admin_updates" id="hi_admin" value="{{ $u->notify_admin_updates ? 1 : 0 }}">

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon teal"><i class="fas fa-paper-plane"></i></div>
                                <div>
                                    <p class="stt-card-title">Delivery Channels</p>
                                    <p class="stt-card-sub">Choose how you want to receive alerts.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                @php
                                $toggles = [
                                    ['id' => 'hi_email', 'val' => $u->email_notifications, 'icon' => 'fas fa-envelope', 'label' => 'Email Notifications', 'desc' => 'Receive notifications, negotiations, and alerts to your email.'],
                                    ['id' => 'hi_sms', 'val' => $u->sms_notifications, 'icon' => 'fas fa-comment-dots', 'label' => 'SMS / Text Alerts', 'desc' => 'Get immediate text messages for urgent transaction updates.'],
                                    ['id' => 'hi_marketing', 'val' => $u->marketing_updates, 'icon' => 'fas fa-bullhorn', 'label' => 'Platform Updates & E-Waste Drives', 'desc' => 'Announcements about drop-off events and circular economy features.'],
                                ];
                                @endphp
                                @foreach($toggles as $t)
                                <div class="stt-toggle-row">
                                    <div class="stt-toggle-info">
                                        <span class="stt-toggle-label"><i class="{{ $t['icon'] }} me-2" style="color: #0d9488;"></i>{{ $t['label'] }}</span>
                                        <span class="stt-toggle-desc">{{ $t['desc'] }}</span>
                                    </div>
                                    <label class="stt-toggle">
                                        <input type="checkbox" {{ $t['val'] ? 'checked' : '' }} onchange="document.getElementById('{{ $t['id'] }}').value = this.checked ? 1 : 0">
                                        <div class="stt-toggle-track">
                                            <div class="stt-toggle-thumb"></div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon purple"><i class="fas fa-bell"></i></div>
                                <div>
                                    <p class="stt-card-title">Activity Triggers</p>
                                    <p class="stt-card-sub">Select which events generate system notifications.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                @php
                                $events = [
                                    ['id' => 'hi_offer', 'val' => $u->notify_new_offer, 'icon' => 'fas fa-handshake', 'label' => 'New Offers & Bids', 'desc' => 'Notify when an offer is placed on a listing.'],
                                    ['id' => 'hi_txn', 'val' => $u->notify_transaction_complete, 'icon' => 'fas fa-check-circle', 'label' => 'Deal Completed', 'desc' => 'Notify when an offer is finalized and marked complete.'],
                                    ['id' => 'hi_msg', 'val' => $u->notify_new_message, 'icon' => 'fas fa-comment', 'label' => 'Direct Messages', 'desc' => 'Notify when a buyer or seller messages you.'],
                                    ['id' => 'hi_admin', 'val' => $u->notify_admin_updates, 'icon' => 'fas fa-shield-alt', 'label' => 'Administrative Alerts', 'desc' => 'Critical security and account status updates.'],
                                ];
                                @endphp
                                @foreach($events as $e)
                                <div class="stt-toggle-row">
                                    <div class="stt-toggle-info">
                                        <span class="stt-toggle-label"><i class="{{ $e['icon'] }} me-2" style="color: #9333ea;"></i>{{ $e['label'] }}</span>
                                        <span class="stt-toggle-desc">{{ $e['desc'] }}</span>
                                    </div>
                                    <label class="stt-toggle">
                                        <input type="checkbox" {{ $e['val'] ? 'checked' : '' }} onchange="document.getElementById('{{ $e['id'] }}').value = this.checked ? 1 : 0">
                                        <div class="stt-toggle-track">
                                            <div class="stt-toggle-thumb"></div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                                <div class="stt-form-footer">
                                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Preferences</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ════════════════════════════════════════════════
                     TAB 3: PRIVACY & SECURITY
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-privacy" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Privacy & <span>Security</span></h2>
                        <p class="stt-panel-sub">Manage profile visibility, change credentials, and protect your account.</p>
                    </div>

                    {{-- Profile visibility form --}}
                    <form method="POST" action="{{ route('settings.privacy.update') }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="profile_visibility" id="pvInput" value="{{ auth()->user()->profile_visibility ?? 'public' }}">
                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon purple"><i class="fas fa-user-secret"></i></div>
                                <div>
                                    <p class="stt-card-title">Profile Visibility</p>
                                    <p class="stt-card-sub">Control who can view your profile and impact credentials.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <div class="stt-shield-row">
                                    <div class="stt-shield-opt {{ (auth()->user()->profile_visibility ?? 'public') === 'public' ? 'selected' : '' }}"
                                        onclick="selectVisibility('public', this)">
                                        <i class="fas fa-globe"></i>
                                        <div class="stt-shield-opt-label">Public</div>
                                        <div class="stt-shield-opt-sub">Visible to marketplace buyers & sellers</div>
                                    </div>
                                    <div class="stt-shield-opt {{ (auth()->user()->profile_visibility ?? '') === 'private' ? 'selected' : '' }}"
                                        onclick="selectVisibility('private', this)">
                                        <i class="fas fa-user-lock"></i>
                                        <div class="stt-shield-opt-label">Private</div>
                                        <div class="stt-shield-opt-sub">Only visible to direct transaction counterparties</div>
                                    </div>
                                </div>
                                <div class="stt-form-footer" style="margin-top: 0; padding-top: 0; border: none; justify-content: flex-start;">
                                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Privacy Setting</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Password Card --}}
                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon amber"><i class="fas fa-key"></i></div>
                            <div>
                                <p class="stt-card-title">Account Password</p>
                                <p class="stt-card-sub">
                                    @if(auth()->user()->oauth_provider)
                                        <span class="text-success fw-bold"><i class="fab fa-google me-1"></i>Google OAuth Connected (Password managed via Google)</span>
                                    @else
                                        Keep your password secure with regular updates.
                                    @endif
                                </p>
                            </div>
                            <div style="margin-left: auto;">
                                @if(!auth()->user()->oauth_provider)
                                <a href="{{ route('password.change') }}" class="stt-btn-ghost">
                                    <i class="fas fa-lock me-1"></i>Change Password
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Email Address Card --}}
                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon blue"><i class="fas fa-envelope"></i></div>
                            <div>
                                <p class="stt-card-title">Email Address</p>
                                <p class="stt-card-sub">Current: <strong style="color: #0284c7;">{{ auth()->user()->email }}</strong></p>
                            </div>
                            <div style="margin-left: auto;">
                                @if(!auth()->user()->oauth_provider)
                                <a href="{{ route('email.change.request') }}" class="stt-btn-ghost">
                                    <i class="fas fa-pen me-1"></i>Change Email
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════════════════════════
                     TAB 4: ID VERIFICATION (Members only)
                ═══════════════════════════════════════════════════ --}}
                @if(!auth()->user()->isAdmin())
                <div id="stt-id-verification" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Government <span>ID Verification</span></h2>
                        <p class="stt-panel-sub">Submit a government-issued ID to get a Verified badge for safe transactions.</p>
                    </div>

                    @php
                        $user = auth()->user();
                        $isVerified = $user->isIdVerified();
                        $isPending = $user->isIdPending();
                        $isRejected = $user->id_verification_status === 'rejected';
                    @endphp

                    {{-- Verification status card --}}
                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon {{ $isVerified ? 'green' : ($isPending ? 'amber' : ($isRejected ? 'rose' : 'blue')) }}">
                                <i class="fas {{ $isVerified ? 'fa-check-circle' : ($isPending ? 'fa-hourglass-half' : ($isRejected ? 'fa-exclamation-triangle' : 'fa-id-card')) }}"></i>
                            </div>
                            <div>
                                <p class="stt-card-title">
                                    Status: 
                                    @if($isVerified)
                                        <span style="color: #16a34a; font-weight: 800;">VERIFIED 🛡️</span>
                                    @elseif($isPending)
                                        <span style="color: #d97706; font-weight: 800;">PENDING REVIEW ⏳</span>
                                    @elseif($isRejected)
                                        <span style="color: #dc2626; font-weight: 800;">REJECTED ⚠️</span>
                                    @else
                                        <span style="color: #64748b; font-weight: 800;">NOT SUBMITTED 📋</span>
                                    @endif
                                </p>
                                <p class="stt-card-sub">
                                    @if($isVerified)
                                        Your government ID is verified. You have full access to marketplace trades and trusted badges.
                                    @elseif($isPending)
                                        Submitted on {{ $user->id_submitted_at ? $user->id_submitted_at->format('M d, Y') : 'recently' }} — currently queued for administrator review.
                                    @elseif($isRejected)
                                        Reason: {{ $user->id_rejection_reason ?? 'Document unreadable or expired' }}. Please re-submit a clear document below.
                                    @else
                                        Upload a valid Philippine ID to build trust with community recyclers and buyers.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if(!$isVerified)
                    {{-- Submission form --}}
                    <form method="POST" action="{{ route('settings.id-verification.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon teal"><i class="fas fa-upload"></i></div>
                                <div>
                                    <p class="stt-card-title">{{ $isRejected ? 'Re-Submit Valid ID' : ($isPending ? 'Update Submitted Documents' : 'Submit Valid ID') }}</p>
                                    <p class="stt-card-sub">Acceptable IDs: PhilSys National ID, Driver's License, UMID, Passport, PRC ID, Postal ID, Voter's ID.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="stt-label">Valid ID Type <span class="text-danger">*</span></label>
                                        <select name="id_type" class="stt-input @error('id_type') is-invalid @enderror" required>
                                            <option value="">Select ID Type...</option>
                                            <option value="Philippine National ID (PhilSys)" {{ old('id_type', $user->id_type) === 'Philippine National ID (PhilSys)' ? 'selected' : '' }}>Philippine National ID (PhilSys)</option>
                                            <option value="Driver's License" {{ old('id_type', $user->id_type) === "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                            <option value="UMID / SSS ID" {{ old('id_type', $user->id_type) === 'UMID / SSS ID' ? 'selected' : '' }}>UMID / SSS ID</option>
                                            <option value="Passport" {{ old('id_type', $user->id_type) === 'Passport' ? 'selected' : '' }}>Passport</option>
                                            <option value="PRC ID" {{ old('id_type', $user->id_type) === 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                                            <option value="Postal ID" {{ old('id_type', $user->id_type) === 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                                            <option value="Voter's ID / Certificate" {{ old('id_type', $user->id_type) === "Voter's ID / Certificate" ? 'selected' : '' }}>Voter's ID / Certificate</option>
                                            <option value="Other Government ID" {{ old('id_type', $user->id_type) === 'Other Government ID' ? 'selected' : '' }}>Other Government ID</option>
                                        </select>
                                        @error('id_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="stt-label">ID Number <span class="text-danger">*</span></label>
                                        <input type="text" name="id_number" class="stt-input @error('id_number') is-invalid @enderror"
                                            value="{{ old('id_number', $user->id_number) }}" placeholder="e.g. 1234-5678-9012-3456" required>
                                        @error('id_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="stt-label">Front ID Photo <span class="text-danger">*</span></label>
                                        <input type="file" name="id_photo" class="stt-input @error('id_photo') is-invalid @enderror" accept="image/*" required>
                                        <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Clear front side photo (JPG, PNG, WEBP max 4MB)</small>
                                        @error('id_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="stt-label">Selfie with ID <span style="color: #64748b;">(Optional)</span></label>
                                        <input type="file" name="id_selfie" class="stt-input @error('id_selfie') is-invalid @enderror" accept="image/*">
                                        <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Holding your ID next to your face for accelerated approval</small>
                                        @error('id_selfie')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="stt-form-footer">
                                    <button type="submit" class="stt-btn">
                                        <i class="fas fa-paper-plane me-1"></i>Submit for Verification
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>

                {{-- ════════════════════════════════════════════════
                     TAB 5: PAYMENTS & PAYOUTS (Members only)
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-payments" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Payout & <span>Banking</span></h2>
                        <p class="stt-panel-sub">Configure your GCash and bank details for fast escrow disbursements.</p>
                    </div>

                    <form method="POST" action="{{ route('settings.payments.update') }}">
                        @csrf @method('PUT')
                        @php $u = auth()->user(); @endphp

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-payment-logo gcash"><i class="fas fa-mobile-alt"></i></div>
                                <div>
                                    <p class="stt-card-title">GCash Account</p>
                                    <p class="stt-card-sub">
                                        @if($u->gcash_number)
                                            Configured: <strong style="color: #0284c7;">{{ preg_replace('/(\d{4})(\d{3})(\d{4})/', '$1-$2-$3', $u->gcash_number) }}</strong>
                                        @else
                                            No GCash number registered.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <label class="stt-label">GCash Mobile Number</label>
                                <input type="tel" name="gcash_number" class="stt-input @error('gcash_number') is-invalid @enderror"
                                    value="{{ old('gcash_number', $u->gcash_number) }}" placeholder="09XXXXXXXXX">
                                @error('gcash_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-payment-logo bank"><i class="fas fa-university"></i></div>
                                <div>
                                    <p class="stt-card-title">Bank Account</p>
                                    <p class="stt-card-sub">
                                        @if($u->bank_name && $u->bank_account_number)
                                            {{ $u->bank_name }} — ••••{{ substr($u->bank_account_number, -4) }}
                                        @else
                                            No bank account linked.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="stt-label">Bank Name</label>
                                        <input type="text" name="bank_name" class="stt-input @error('bank_name') is-invalid @enderror"
                                            value="{{ old('bank_name', $u->bank_name) }}" placeholder="e.g. BDO, BPI, UnionBank, Metrobank">
                                        @error('bank_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">Account Number</label>
                                        <input type="text" name="bank_account_number" class="stt-input @error('bank_account_number') is-invalid @enderror"
                                            value="{{ old('bank_account_number', $u->bank_account_number) }}" placeholder="xxxx-xxxx-xxxx">
                                        @error('bank_account_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="stt-form-footer">
                                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Payment Details</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                {{-- ════════════════════════════════════════════════
                     TAB 6: SELLER PROFILE (Sellers only)
                ═══════════════════════════════════════════════════ --}}
                @if(auth()->user()->isSeller())
                <div id="stt-seller" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">Seller <span>Profile</span></h2>
                        <p class="stt-panel-sub">Configure your public storefront, trading preferences, and review your stats.</p>
                    </div>

                    {{-- Stats Grid --}}
                    @if(!empty($stats))
                    <div class="stt-stats-grid">
                        <div class="stt-stat">
                            <span class="stt-stat-value">{{ $stats['total_listings'] }}</span>
                            <span class="stt-stat-label">Total Listings</span>
                        </div>
                        <div class="stt-stat">
                            <span class="stt-stat-value">{{ $stats['active_listings'] }}</span>
                            <span class="stt-stat-label">Active</span>
                        </div>
                        <div class="stt-stat">
                            <span class="stt-stat-value">{{ $stats['sold_items'] }}</span>
                            <span class="stt-stat-label">Deals Made</span>
                        </div>
                        <div class="stt-stat">
                            <span class="stt-stat-value">{{ $stats['items_processed'] }}</span>
                            <span class="stt-stat-label">Processed</span>
                        </div>
                        <div class="stt-stat">
                            <span class="stt-stat-value">{{ $stats['co2_saved'] }}</span>
                            <span class="stt-stat-label">kg CO₂ Saved</span>
                        </div>
                    </div>
                    @endif

                    {{-- Seller form --}}
                    <form method="POST" action="{{ route('settings.seller.update') }}">
                        @csrf @method('PUT')
                        @php $u = auth()->user(); @endphp

                        <div class="stt-card">
                            <div class="stt-card-header">
                                <div class="stt-card-icon teal"><i class="fas fa-store"></i></div>
                                <div>
                                    <p class="stt-card-title">Storefront Details</p>
                                    <p class="stt-card-sub">Your public seller branding and default listing preference.</p>
                                </div>
                            </div>
                            <div class="stt-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="stt-label">Business / Seller Store Name</label>
                                        <input type="text" name="business_name" class="stt-input @error('business_name') is-invalid @enderror"
                                            value="{{ old('business_name', $u->business_name) }}" placeholder="Your store name">
                                        @error('business_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">Default Listing Action</label>
                                        <select name="preferred_action" class="stt-input @error('preferred_action') is-invalid @enderror">
                                            <option value="sell" {{ ($u->preferred_action ?? 'sell') === 'sell' ? 'selected' : '' }}>💰 Sell</option>
                                            <option value="recycle" {{ ($u->preferred_action ?? '') === 'recycle' ? 'selected' : '' }}>♻️ Recycle</option>
                                        </select>
                                        @error('preferred_action')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">City</label>
                                        <input type="text" name="address_city" class="stt-input @error('address_city') is-invalid @enderror"
                                            value="{{ old('address_city', $u->address_city) }}" placeholder="e.g. Quezon City">
                                        @error('address_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">Province / Region</label>
                                        <input type="text" name="address_province" class="stt-input @error('address_province') is-invalid @enderror"
                                            value="{{ old('address_province', $u->address_province) }}" placeholder="e.g. Metro Manila">
                                        @error('address_province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="stt-label">Seller Bio</label>
                                        <textarea name="business_description" class="stt-input @error('business_description') is-invalid @enderror"
                                            rows="4" placeholder="Describe your selling inventory, turnaround times, and device testing methods...">{{ old('business_description', $u->business_description) }}</textarea>
                                        @error('business_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="stt-form-footer">
                                    <a href="{{ route('seller.dashboard') }}" class="stt-btn-ghost"><i class="fas fa-chart-line me-1"></i>Seller Hub</a>
                                    <a href="{{ route('listings.create') }}" class="stt-btn-ghost"><i class="fas fa-plus me-1"></i>New Listing</a>
                                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Seller Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                {{-- ════════════════════════════════════════════════
                     TAB 7: PREFERENCES & APPEARANCE
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-preferences" class="stt-panel">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">General <span>Preferences</span></h2>
                        <p class="stt-panel-sub">Customize interface styling and locale settings.</p>
                    </div>

                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon teal"><i class="fas fa-paint-brush"></i></div>
                            <div>
                                <p class="stt-card-title">Theme & Appearance</p>
                                <p class="stt-card-sub">Choose between Dark Mode and Light Mode.</p>
                            </div>
                        </div>
                        <div class="stt-card-body">
                            <div class="stt-toggle-row">
                                <div class="stt-toggle-info">
                                    <span class="stt-toggle-label"><i class="fas fa-moon me-2" style="color: #9333ea;"></i>Dark Mode</span>
                                    <span class="stt-toggle-desc">Toggle the sleek obsidian night theme across all workspace views.</span>
                                </div>
                                <label class="stt-toggle">
                                    <input type="checkbox" id="darkModeChk">
                                    <div class="stt-toggle-track">
                                        <div class="stt-toggle-thumb"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon blue"><i class="fas fa-language"></i></div>
                            <div>
                                <p class="stt-card-title">Localization & Currency</p>
                                <p class="stt-card-sub">Regional language and currency standards.</p>
                            </div>
                            <div style="margin-left: auto;">
                                <span class="badge" style="background: rgba(6, 182, 212, 0.15); color: #0284c7; border: 1px solid rgba(6, 182, 212, 0.3); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    🇵🇭 Filipino / English (PHP ₱)
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(!auth()->user()->isAdmin())
                    <div class="stt-card">
                        <div class="stt-card-header">
                            <div class="stt-card-icon rose"><i class="fas fa-trash-alt"></i></div>
                            <div>
                                <p class="stt-card-title" style="color: #dc2626;">Danger Zone</p>
                                <p class="stt-card-sub">Permanent account actions that cannot be reversed.</p>
                            </div>
                        </div>
                        <div class="stt-card-body">
                            <div class="stt-toggle-row" style="border: none; background: transparent; padding: 0;">
                                <div class="stt-toggle-info">
                                    <span class="stt-toggle-label" style="color: #dc2626;">Delete Account</span>
                                    <span class="stt-toggle-desc">Permanently remove your listings, offers, and account data.</span>
                                </div>
                                <button type="button" class="stt-btn-danger" onclick="alert('To request account deletion, please contact support@e-benta.ph')">
                                    <i class="fas fa-user-times"></i>Request Deletion
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
</div>

<script>
function sttSwitch(panel, btn) {
    // Hide all panels
    document.querySelectorAll('.stt-panel').forEach(p => {
        p.classList.remove('active');
    });
    // Show target panel
    const target = document.getElementById('stt-' + panel);
    if (target) target.classList.add('active');

    // Update nav
    document.querySelectorAll('.stt-nav-item').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    // Update URL hash
    window.location.hash = panel;

    // Scroll to top smoothly on mobile
    if (window.innerWidth < 992) {
        document.querySelector('.stt-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function selectVisibility(val, el) {
    document.querySelectorAll('.stt-shield-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('pvInput').value = val;
}

// Dark mode state management
document.addEventListener('DOMContentLoaded', function () {
    const chk = document.getElementById('darkModeChk');
    const isDark = localStorage.getItem('darkModeEnabled') === 'true';

    if (isDark) {
        document.body.classList.add('dark-mode');
        if (chk) chk.checked = true;
    }

    if (chk) {
        chk.addEventListener('change', function () {
            document.body.classList.toggle('dark-mode', this.checked);
            localStorage.setItem('darkModeEnabled', this.checked ? 'true' : 'false');
        });
    }

    // Restore active tab from hash
    const hash = window.location.hash.replace('#', '');
    const panels = ['account', 'notifications', 'privacy', 'id-verification', 'payments', 'seller', 'preferences'];
    if (hash && panels.includes(hash)) {
        const navBtn = document.querySelector(`.stt-nav-item[onclick*="'${hash}'"]`);
        if (navBtn) {
            sttSwitch(hash, navBtn);
        }
    }
});
</script>
@endsection
