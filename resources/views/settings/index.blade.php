@extends('layouts.app')

@section('title', 'Settings — E-Benta')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }

/* ─── LAYOUT ─────────────────────────────────────────── */
.stt-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a1628 0%, #0d1f38 40%, #0c2040 100%);
    padding: 2rem 0 4rem;
    font-family: 'Inter', sans-serif;
}

.stt-wrapper {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.75rem;
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ─── SIDEBAR ─────────────────────────────────────────── */
.stt-sidebar {
    position: sticky;
    top: 90px;
    height: fit-content;
}

.stt-user-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 1.25rem;
    padding: 1.75rem;
    text-align: center;
    margin-bottom: 1rem;
    backdrop-filter: blur(20px);
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
    border: 3px solid rgba(13,148,136,0.6);
    box-shadow: 0 0 20px rgba(13,148,136,0.3);
}

.stt-avatar-default {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488, #06b6d4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 800;
    color: white;
    border: 3px solid rgba(13,148,136,0.6);
    box-shadow: 0 0 20px rgba(13,148,136,0.3);
}

.stt-avatar-edit {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #0d9488, #06b6d4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    font-size: 0.65rem;
    color: white;
    border: 2px solid #0d1f38;
    transition: transform 0.2s;
}

.stt-avatar-edit:hover { transform: scale(1.15); }

.stt-user-name {
    font-size: 1rem;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 0.35rem;
}

.stt-user-email {
    font-size: 0.78rem;
    color: #64748b;
    margin-bottom: 0.75rem;
    word-break: break-all;
}

.stt-badge-row {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.stt-badge {
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 0.7rem;
    border-radius: 99px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.stt-badge-seller { background: rgba(13,148,136,0.2); color: #2dd4bf; border: 1px solid rgba(13,148,136,0.4); }
.stt-badge-buyer { background: rgba(59,130,246,0.2); color: #93c5fd; border: 1px solid rgba(59,130,246,0.4); }
.stt-badge-admin { background: rgba(168,85,247,0.2); color: #c4b5fd; border: 1px solid rgba(168,85,247,0.4); }
.stt-badge-verified { background: rgba(34,197,94,0.2); color: #86efac; border: 1px solid rgba(34,197,94,0.4); }
.stt-badge-unverified { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }

/* Sidebar nav */
.stt-nav {
    background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 1.25rem;
    padding: 1rem;
    backdrop-filter: blur(20px);
}

.stt-nav-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.85rem 1rem;
    border-radius: 0.85rem;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    transition: all 0.2s ease;
    position: relative;
    border-left: 3px solid transparent;
    margin-bottom: 0.2rem;
}

.stt-nav-item:hover {
    background: rgba(13,148,136,0.1);
    color: #2dd4bf;
    border-left-color: rgba(13,148,136,0.4);
    transform: translateX(3px);
}

.stt-nav-item.active {
    background: linear-gradient(135deg, rgba(13,148,136,0.2) 0%, rgba(6,182,212,0.12) 100%);
    color: #2dd4bf;
    border-left-color: #0d9488;
}

.stt-nav-item i {
    width: 18px;
    text-align: center;
    font-size: 1rem;
    opacity: 0.85;
}

.stt-nav-badge {
    margin-left: auto;
    font-size: 0.65rem;
    padding: 0.15rem 0.5rem;
    background: rgba(13,148,136,0.2);
    color: #2dd4bf;
    border-radius: 99px;
    border: 1px solid rgba(13,148,136,0.3);
}

.stt-nav-divider {
    height: 1px;
    background: rgba(255,255,255,0.06);
    margin: 0.5rem 0;
}

/* ─── CONTENT PANEL ─────────────────────────────────── */
.stt-content {
    /* panels rendered here */
}

.stt-panel {
    display: none;
}

.stt-panel.active {
    display: block;
    animation: stt-fade 0.25s ease;
}

@keyframes stt-fade {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ─── CARD ───────────────────────────────────────────── */
.stt-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(20px);
}

.stt-card-header {
    padding: 1.4rem 1.75rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stt-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}

.stt-card-icon.teal { background: linear-gradient(135deg, rgba(13,148,136,0.3), rgba(6,182,212,0.2)); color: #2dd4bf; }
.stt-card-icon.blue { background: linear-gradient(135deg, rgba(59,130,246,0.3), rgba(99,102,241,0.2)); color: #93c5fd; }
.stt-card-icon.purple { background: linear-gradient(135deg, rgba(168,85,247,0.3), rgba(139,92,246,0.2)); color: #c4b5fd; }
.stt-card-icon.amber { background: linear-gradient(135deg, rgba(245,158,11,0.3), rgba(251,191,36,0.2)); color: #fbbf24; }
.stt-card-icon.rose { background: linear-gradient(135deg, rgba(244,63,94,0.3), rgba(239,68,68,0.2)); color: #fda4af; }
.stt-card-icon.green { background: linear-gradient(135deg, rgba(34,197,94,0.3), rgba(16,185,129,0.2)); color: #86efac; }

.stt-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #e2e8f0;
    margin: 0 0 0.2rem;
}

.stt-card-sub {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0;
}

.stt-card-body {
    padding: 1.5rem 1.75rem;
}

/* ─── FORM ELEMENTS ──────────────────────────────────── */
.stt-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #94a3b8;
    letter-spacing: 0.4px;
    margin-bottom: 0.5rem;
    display: block;
    text-transform: uppercase;
}

.stt-input {
    width: 100%;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 0.75rem;
    padding: 0.8rem 1rem;
    color: #e2e8f0;
    font-size: 0.92rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.2s ease;
    outline: none;
}

.stt-input::placeholder { color: #475569; }
.stt-input:focus {
    border-color: rgba(13,148,136,0.5);
    background: rgba(255,255,255,0.08);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.12);
}

select.stt-input option { background: #0d1f38; color: #e2e8f0; }

.stt-input.is-invalid { border-color: rgba(239,68,68,0.5); }
.invalid-feedback { color: #fca5a5; font-size: 0.8rem; margin-top: 0.3rem; }

/* ─── TOGGLE ─────────────────────────────────────────── */
.stt-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.stt-toggle-row:last-of-type { border-bottom: none; }

.stt-toggle-info { flex: 1; }

.stt-toggle-label {
    font-size: 0.92rem;
    font-weight: 600;
    color: #cbd5e1;
    display: block;
    margin-bottom: 0.2rem;
}

.stt-toggle-desc {
    font-size: 0.78rem;
    color: #475569;
}

.stt-toggle {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
    margin-left: 1rem;
}

.stt-toggle input { display: none; }

.stt-toggle-track {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.12);
    border-radius: 99px;
    cursor: pointer;
    transition: background 0.25s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.stt-toggle-thumb {
    position: absolute;
    left: 3px;
    top: 3px;
    width: 18px;
    height: 18px;
    background: #94a3b8;
    border-radius: 50%;
    transition: all 0.25s ease;
}

.stt-toggle input:checked ~ .stt-toggle-track { background: linear-gradient(135deg, #0d9488, #06b6d4); border-color: transparent; }
.stt-toggle input:checked ~ .stt-toggle-track .stt-toggle-thumb { left: 25px; background: white; }

/* ─── BUTTONS ────────────────────────────────────────── */
.stt-btn {
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: 'Inter', sans-serif;
    text-decoration: none;
}

.stt-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13,148,136,0.4);
    color: white;
}

.stt-btn-ghost {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.12);
    color: #94a3b8;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
}

.stt-btn-ghost:hover { background: rgba(255,255,255,0.09); color: #e2e8f0; }

.stt-btn-danger {
    background: rgba(239,68,68,0.12);
    border: 1px solid rgba(239,68,68,0.3);
    color: #fca5a5;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
}

.stt-btn-danger:hover { background: rgba(239,68,68,0.22); color: #fca5a5; }

.stt-form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(255,255,255,0.06);
    margin-top: 1.25rem;
}

/* ─── STAT CARDS ─────────────────────────────────────── */
.stt-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px,1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stt-stat {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 1rem;
    padding: 1.2rem 1rem;
    text-align: center;
}

.stt-stat-value {
    font-size: 1.65rem;
    font-weight: 900;
    background: linear-gradient(135deg, #2dd4bf, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
}

.stt-stat-label {
    font-size: 0.72rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
}

/* ─── SECTION HEADER ─────────────────────────────────── */
.stt-panel-header {
    margin-bottom: 1.5rem;
}

.stt-panel-title {
    font-size: 1.6rem;
    font-weight: 900;
    color: #e2e8f0;
    margin-bottom: 0.4rem;
}

.stt-panel-title span {
    background: linear-gradient(135deg, #2dd4bf, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stt-panel-sub {
    font-size: 0.88rem;
    color: #64748b;
}

/* ─── ALERT ─────────────────────────────────────────── */
.stt-alert {
    padding: 1rem 1.25rem;
    border-radius: 0.85rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    font-size: 0.88rem;
    font-weight: 600;
}

.stt-alert-success {
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.25);
    color: #86efac;
}

.stt-alert-error {
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.25);
    color: #fca5a5;
}

/* ─── PRIVACY SHIELD ─────────────────────────────────── */
.stt-shield-row {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

.stt-shield-opt {
    flex: 1;
    padding: 1rem;
    border-radius: 1rem;
    border: 2px solid rgba(255,255,255,0.08);
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}

.stt-shield-opt:hover {
    border-color: rgba(13,148,136,0.4);
    background: rgba(13,148,136,0.06);
}

.stt-shield-opt.selected {
    border-color: #0d9488;
    background: linear-gradient(135deg, rgba(13,148,136,0.15), rgba(6,182,212,0.08));
}

.stt-shield-opt i { font-size: 1.4rem; margin-bottom: 0.5rem; display: block; color: #2dd4bf; }
.stt-shield-opt-label { font-size: 0.85rem; font-weight: 700; color: #e2e8f0; }
.stt-shield-opt-sub { font-size: 0.72rem; color: #64748b; margin-top: 0.2rem; }

/* ─── PAYMENT METHOD ─────────────────────────────────── */
.stt-payment-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.1rem 1.25rem;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 1rem;
    margin-bottom: 1rem;
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

.stt-payment-logo.gcash { background: rgba(0,114,187,0.2); color: #60a5fa; }
.stt-payment-logo.bank { background: rgba(245,158,11,0.2); color: #fbbf24; }

.stt-payment-info { flex: 1; }
.stt-payment-name { font-size: 0.92rem; font-weight: 700; color: #e2e8f0; }
.stt-payment-status { font-size: 0.75rem; color: #64748b; margin-top: 0.15rem; }

/* ─── INLINE PASSWORD ────────────────────────────────── */
.stt-pw-form { display: none; margin-top: 1rem; }
.stt-pw-form.open { display: block; }

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 880px) {
    .stt-wrapper { grid-template-columns: 1fr; }
    .stt-sidebar { position: static; }
    .stt-user-card { display: flex; align-items: center; gap: 1.25rem; text-align: left; }
    .stt-avatar-wrap { margin: 0; }
    .stt-badge-row { justify-content: flex-start; }
    .stt-nav { display: flex; flex-wrap: wrap; gap: 0.4rem; padding: 0.75rem; }
    .stt-nav-item { width: auto; border-radius: 0.75rem; border-left: none; padding: 0.6rem 1rem; font-size: 0.82rem; }
    .stt-nav-item:hover, .stt-nav-item.active { transform: none; }
    .stt-nav-divider { display: none; }
    .stt-nav-badge { display: none; }
}
</style>
@endsection

@section('content')
<div class="stt-page">
<div class="stt-wrapper">

    {{-- ─── SIDEBAR ─────────────────────────────────────── --}}
    <aside class="stt-sidebar">

        {{-- User card --}}
        <div class="stt-user-card">
            <div class="stt-avatar-wrap">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="stt-avatar-img">
                @else
                    <div class="stt-avatar-default">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                @endif
                <a href="{{ route('profile') }}" class="stt-avatar-edit" title="Change photo">
                    <i class="fas fa-camera"></i>
                </a>
            </div>
            <div>
                <div class="stt-user-name">{{ auth()->user()->name }}</div>
                <div class="stt-user-email">{{ auth()->user()->email }}</div>
                <div class="stt-badge-row">
                    @if(auth()->user()->isSeller())
                        <span class="stt-badge stt-badge-seller"><i class="fas fa-store me-1"></i>Seller</span>
                    @elseif(auth()->user()->isBuyer())
                        <span class="stt-badge stt-badge-buyer"><i class="fas fa-shopping-bag me-1"></i>Buyer</span>
                    @endif
                    @if(auth()->user()->is_verified)
                        <span class="stt-badge stt-badge-verified"><i class="fas fa-check-circle me-1"></i>Verified</span>
                    @else
                        <span class="stt-badge stt-badge-unverified"><i class="fas fa-clock me-1"></i>Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="stt-nav">
            <button class="stt-nav-item active" onclick="sttSwitch('account', this)">
                <i class="fas fa-user-circle"></i> Account
            </button>
            <button class="stt-nav-item" onclick="sttSwitch('notifications', this)">
                <i class="fas fa-bell"></i> Notifications
            </button>
            <button class="stt-nav-item" onclick="sttSwitch('privacy', this)">
                <i class="fas fa-lock"></i> Privacy & Security
            </button>
            <button class="stt-nav-item" onclick="sttSwitch('id-verification', this)">
                <i class="fas fa-id-card"></i> ID Verification
                @if(auth()->user()->isIdVerified())
                    <span class="stt-nav-badge" style="background: rgba(34,197,94,0.2); color: #86efac; border-color: rgba(34,197,94,0.4);">Verified</span>
                @elseif(auth()->user()->isIdPending())
                    <span class="stt-nav-badge" style="background: rgba(245,158,11,0.2); color: #fde047; border-color: rgba(245,158,11,0.4);">Pending</span>
                @endif
            </button>
            <button class="stt-nav-item" onclick="sttSwitch('payments', this)">
                <i class="fas fa-credit-card"></i> Payments
            </button>
            @if(auth()->user()->isSeller())
            <div class="stt-nav-divider"></div>
            <button class="stt-nav-item" onclick="sttSwitch('seller', this)">
                <i class="fas fa-store"></i> Seller Profile
                <span class="stt-nav-badge">Seller</span>
            </button>
            @endif
            <div class="stt-nav-divider"></div>
            <button class="stt-nav-item" onclick="sttSwitch('preferences', this)">
                <i class="fas fa-sliders-h"></i> Preferences
            </button>
        </nav>
    </aside>

    {{-- ─── MAIN CONTENT ────────────────────────────────── --}}
    <main class="stt-content">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="stt-alert stt-alert-success">
            <i class="fas fa-check-circle" style="font-size:1.1rem;margin-top:0.05rem;"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="stt-alert stt-alert-error">
            <i class="fas fa-exclamation-circle" style="font-size:1.1rem;margin-top:0.05rem;"></i>
            {{ session('error') }}
        </div>
        @endif

        {{-- ════════════════════════════════════════════════
             ACCOUNT
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-account" class="stt-panel active">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Account <span>Settings</span></h2>
                <p class="stt-panel-sub">Update your personal information, profile photo, and public details.</p>
            </div>

            {{-- Profile picture --}}
            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon teal"><i class="fas fa-camera"></i></div>
                    <div>
                        <p class="stt-card-title">Profile Picture</p>
                        <p class="stt-card-sub">Upload a clear photo. JPG, PNG or WEBP, max 2 MB.</p>
                    </div>
                    <div style="margin-left:auto;display:flex;gap:0.6rem;align-items:center;">
                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="sttAvatarForm">
                            @csrf
                            <label for="sttAvatarFile" class="stt-btn" style="cursor:pointer;margin:0;">
                                <i class="fas fa-upload"></i>Upload
                            </label>
                            <input type="file" id="sttAvatarFile" name="avatar" accept="image/*" style="display:none" onchange="document.getElementById('sttAvatarForm').submit()">
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

            {{-- Personal info --}}
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="stt-card">
                    <div class="stt-card-header">
                        <div class="stt-card-icon blue"><i class="fas fa-id-card"></i></div>
                        <div>
                            <p class="stt-card-title">Personal Information</p>
                            <p class="stt-card-sub">Your name, contact number, and location.</p>
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
                            <div class="col-md-6">
                                <label class="stt-label">{{ auth()->user()->isSeller() ? 'Business Name' : 'Organization' }}</label>
                                <input type="text" name="business_name" class="stt-input @error('business_name') is-invalid @enderror"
                                    value="{{ old('business_name', auth()->user()->business_name) }}">
                                @error('business_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            @endif
                            <div class="col-12">
                                <label class="stt-label">Short Bio / Description</label>
                                <textarea name="business_description" class="stt-input @error('business_description') is-invalid @enderror"
                                    rows="3" placeholder="Tell others a little about yourself...">{{ old('business_description', auth()->user()->business_description) }}</textarea>
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
             NOTIFICATIONS
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-notifications" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Notification <span>Preferences</span></h2>
                <p class="stt-panel-sub">Control how and when you receive alerts from E-Benta.</p>
            </div>

            <form method="POST" action="{{ route('settings.notifications.update') }}">
                @csrf @method('PUT')
                @php $u = auth()->user(); @endphp
                {{-- hidden inputs --}}
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
                            <p class="stt-card-sub">Choose how you want to receive notifications.</p>
                        </div>
                    </div>
                    <div class="stt-card-body">
                        @php
                        $toggles = [
                            ['id' => 'hi_email', 'val' => $u->email_notifications, 'icon' => 'fas fa-envelope', 'label' => 'Email Notifications', 'desc' => 'Receive offers, updates, and alerts to your email.'],
                            ['id' => 'hi_sms', 'val' => $u->sms_notifications, 'icon' => 'fas fa-comment-dots', 'label' => 'SMS / Text Alerts', 'desc' => 'Get urgent updates via text message.'],
                            ['id' => 'hi_marketing', 'val' => $u->marketing_updates, 'icon' => 'fas fa-megaphone', 'label' => 'Marketing & Announcements', 'desc' => 'News about new features and promotions.'],
                        ];
                        @endphp
                        @foreach($toggles as $t)
                        <div class="stt-toggle-row">
                            <div class="stt-toggle-info">
                                <i class="{{ $t['icon'] }}" style="color:#2dd4bf;margin-right:0.5rem;"></i>
                                <span class="stt-toggle-label">{{ $t['label'] }}</span>
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
                        <div class="stt-card-icon purple"><i class="fas fa-bell-slash"></i></div>
                        <div>
                            <p class="stt-card-title">Event Notifications</p>
                            <p class="stt-card-sub">Fine-tune which activity types trigger notifications.</p>
                        </div>
                    </div>
                    <div class="stt-card-body">
                        @php
                        $events = [
                            ['id' => 'hi_offer', 'val' => $u->notify_new_offer, 'icon' => 'fas fa-handshake', 'label' => 'New Offer Received', 'desc' => 'Notify when a buyer makes an offer on your listing.'],
                            ['id' => 'hi_txn', 'val' => $u->notify_transaction_complete, 'icon' => 'fas fa-check-circle', 'label' => 'Transaction Completed', 'desc' => 'Notify when an offer is accepted and a deal is done.'],
                            ['id' => 'hi_msg', 'val' => $u->notify_new_message, 'icon' => 'fas fa-comment', 'label' => 'New Message', 'desc' => 'Notify when someone sends you a chat message.'],
                            ['id' => 'hi_admin', 'val' => $u->notify_admin_updates, 'icon' => 'fas fa-shield-alt', 'label' => 'Admin & System Updates', 'desc' => 'Critical system and account status updates.'],
                        ];
                        @endphp
                        @foreach($events as $e)
                        <div class="stt-toggle-row">
                            <div class="stt-toggle-info">
                                <i class="{{ $e['icon'] }}" style="color:#c4b5fd;margin-right:0.5rem;"></i>
                                <span class="stt-toggle-label">{{ $e['label'] }}</span>
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
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Preferences</button>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════
             PRIVACY & SECURITY
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-privacy" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Privacy & <span>Security</span></h2>
                <p class="stt-panel-sub">Manage who can see your profile and keep your account secure.</p>
            </div>

            {{-- Profile visibility --}}
            <form method="POST" action="{{ route('settings.privacy.update') }}">
                @csrf @method('PUT')
                <input type="hidden" name="profile_visibility" id="pvInput" value="{{ auth()->user()->profile_visibility ?? 'public' }}">
                <div class="stt-card">
                    <div class="stt-card-header">
                        <div class="stt-card-icon purple"><i class="fas fa-user-secret"></i></div>
                        <div>
                            <p class="stt-card-title">Profile Visibility</p>
                            <p class="stt-card-sub">Control who can view your profile and reviews.</p>
                        </div>
                    </div>
                    <div class="stt-card-body">
                        <div class="stt-shield-row">
                            <div class="stt-shield-opt {{ (auth()->user()->profile_visibility ?? 'public') === 'public' ? 'selected' : '' }}"
                                onclick="selectVisibility('public', this)">
                                <i class="fas fa-globe"></i>
                                <div class="stt-shield-opt-label">Public</div>
                                <div class="stt-shield-opt-sub">Anyone can view your profile</div>
                            </div>
                            <div class="stt-shield-opt {{ (auth()->user()->profile_visibility ?? '') === 'private' ? 'selected' : '' }}"
                                onclick="selectVisibility('private', this)">
                                <i class="fas fa-user-lock"></i>
                                <div class="stt-shield-opt-label">Private</div>
                                <div class="stt-shield-opt-sub">Only you can view your profile</div>
                            </div>
                        </div>
                        <div class="stt-form-footer" style="margin-top:0;padding-top:0;border:none;justify-content:flex-start;">
                            <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Privacy</button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Password --}}
            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon amber"><i class="fas fa-key"></i></div>
                    <div>
                        <p class="stt-card-title">Password</p>
                        <p class="stt-card-sub">
                            Keep your account safe with a strong password.
                            @if(auth()->user()->oauth_provider)
                                <span style="color:#fbbf24;">(Google login — no password required)</span>
                            @endif
                        </p>
                    </div>
                    <div style="margin-left:auto;">
                        @if(!auth()->user()->oauth_provider)
                        <a href="{{ route('password.change') }}" class="stt-btn-ghost">
                            <i class="fas fa-lock"></i> Change Password
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon blue"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="stt-card-title">Email Address</p>
                        <p class="stt-card-sub">Current: <strong style="color:#93c5fd;">{{ auth()->user()->email }}</strong></p>
                    </div>
                    <div style="margin-left:auto;">
                        @if(!auth()->user()->oauth_provider)
                        <a href="{{ route('email.change.request') }}" class="stt-btn-ghost">
                            <i class="fas fa-pen"></i> Change Email
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2FA placeholder --}}
            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon green"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <p class="stt-card-title">Two-Factor Authentication</p>
                        <p class="stt-card-sub">Add an extra layer of security to your account.</p>
                    </div>
                    <div style="margin-left:auto;">
                        <span style="font-size:0.75rem;padding:0.3rem 0.85rem;background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);border-radius:99px;font-weight:700;">
                            Coming Soon
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════
             PAYMENTS
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-payments" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Payment <span>Preferences</span></h2>
                <p class="stt-panel-sub">Set up your payout and collection details.</p>
            </div>

            <form method="POST" action="{{ route('settings.payments.update') }}">
                @csrf @method('PUT')
                @php $u = auth()->user(); @endphp

                <div class="stt-card">
                    <div class="stt-card-header">
                        <div class="stt-payment-logo gcash"><i class="fas fa-mobile-alt"></i></div>
                        <div>
                            <p class="stt-card-title">GCash</p>
                            <p class="stt-card-sub">
                                @if($u->gcash_number)
                                    Saved: <strong style="color:#60a5fa;">{{ preg_replace('/(\d{4})(\d{3})(\d{4})/', '$1-$2-$3', $u->gcash_number) }}</strong>
                                @else
                                    Not set up yet.
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
                                    value="{{ old('bank_name', $u->bank_name) }}" placeholder="e.g. BDO, BPI, UnionBank">
                                @error('bank_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="stt-label">Account Number</label>
                                <input type="text" name="bank_account_number" class="stt-input @error('bank_account_number') is-invalid @enderror"
                                    value="{{ old('bank_account_number', $u->bank_account_number) }}" placeholder="xxxx-xxxx-xxxx">
                                @error('bank_account_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Payment Info</button>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════
             SELLER PROFILE (sellers only)
        ═══════════════════════════════════════════════════ --}}
        @if(auth()->user()->isSeller())
        <div id="stt-seller" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Seller <span>Profile</span></h2>
                <p class="stt-panel-sub">Configure your seller identity, preferences, and see your selling stats.</p>
            </div>

            {{-- Stats --}}
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
                    <span class="stt-stat-label">Matched / Sold</span>
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

            {{-- Seller settings form --}}
            <form method="POST" action="{{ route('settings.seller.update') }}">
                @csrf @method('PUT')
                @php $u = auth()->user(); @endphp

                <div class="stt-card">
                    <div class="stt-card-header">
                        <div class="stt-card-icon teal"><i class="fas fa-store"></i></div>
                        <div>
                            <p class="stt-card-title">Seller Details</p>
                            <p class="stt-card-sub">Your public seller name, bio, and location.</p>
                        </div>
                        @if($u->is_verified)
                            <span class="stt-badge stt-badge-verified" style="margin-left:auto;"><i class="fas fa-check-circle me-1"></i>Verified Seller</span>
                        @else
                            <span class="stt-badge stt-badge-unverified" style="margin-left:auto;"><i class="fas fa-clock me-1"></i>Pending Verification</span>
                        @endif
                    </div>
                    <div class="stt-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="stt-label">Business / Seller Name</label>
                                <input type="text" name="business_name" class="stt-input @error('business_name') is-invalid @enderror"
                                    value="{{ old('business_name', $u->business_name) }}" placeholder="Your store or business name">
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
                                    rows="4" placeholder="Describe your selling style, what you typically list, turnaround time...">{{ old('business_description', $u->business_description) }}</textarea>
                                @error('business_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="stt-form-footer">
                            <a href="{{ route('seller.dashboard') }}" class="stt-btn-ghost"><i class="fas fa-tachometer-alt"></i>Open Dashboard</a>
                            <a href="{{ route('listings.create') }}" class="stt-btn-ghost"><i class="fas fa-plus"></i>New Listing</a>
                            <button type="submit" class="stt-btn"><i class="fas fa-save"></i>Save Seller Profile</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        {{-- ════════════════════════════════════════════════
             PREFERENCES
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-preferences" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">General <span>Preferences</span></h2>
                <p class="stt-panel-sub">Customize how E-Benta looks and behaves for you.</p>
            </div>

            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon teal"><i class="fas fa-paint-brush"></i></div>
                    <div>
                        <p class="stt-card-title">Appearance</p>
                        <p class="stt-card-sub">Choose your preferred look and feel.</p>
                    </div>
                </div>
                <div class="stt-card-body">
                    <div class="stt-toggle-row">
                        <div class="stt-toggle-info">
                            <i class="fas fa-moon" style="color:#c4b5fd;margin-right:0.5rem;"></i>
                            <span class="stt-toggle-label">Dark Mode</span>
                            <span class="stt-toggle-desc">Use a darker interface theme for E-Benta pages.</span>
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
                        <p class="stt-card-title">Language & Region</p>
                        <p class="stt-card-sub">Localization settings for language and currency.</p>
                    </div>
                    <div style="margin-left:auto;">
                        <span style="font-size:0.75rem;padding:0.3rem 0.85rem;background:rgba(59,130,246,0.15);color:#93c5fd;border:1px solid rgba(59,130,246,0.3);border-radius:99px;font-weight:700;">
                            🇵🇭 Filipino / English
                        </span>
                    </div>
                </div>
            </div>

            <div class="stt-card">
                <div class="stt-card-header">
                    <div class="stt-card-icon rose"><i class="fas fa-trash-alt"></i></div>
                    <div>
                        <p class="stt-card-title">Danger Zone</p>
                        <p class="stt-card-sub">Permanent account actions that cannot be undone.</p>
                    </div>
                </div>
                <div class="stt-card-body">
                    <div class="stt-toggle-row" style="border:none;">
                        <div class="stt-toggle-info">
                            <span class="stt-toggle-label" style="color:#fca5a5;">Delete Account</span>
                            <span class="stt-toggle-desc">Permanently remove your account and all your data from E-Benta.</span>
                        </div>
                        <button type="button" class="stt-btn-danger" onclick="alert('Please contact support@e-benta.com to delete your account.')">
                            <i class="fas fa-user-times"></i> Delete Account
                        </button>
        {{-- ════════════════════════════════════════════════
             ID VERIFICATION
        ═══════════════════════════════════════════════════ --}}
        <div id="stt-id-verification" class="stt-panel">
            <div class="stt-panel-header">
                <h2 class="stt-panel-title">Government <span>ID Verification</span></h2>
                <p class="stt-panel-sub">Submit a valid government-issued ID to get a Verified badge for safe meetups and transactions.</p>
            </div>

            @php
                $user = auth()->user();
                $isVerified = $user->isIdVerified();
                $isPending = $user->isIdPending();
                $isRejected = $user->id_verification_status === 'rejected';
            @endphp

            <!-- Status Card -->
            <div class="stt-card" style="margin-bottom: 1.5rem;">
                <div class="stt-card-header" style="align-items: center;">
                    <div class="stt-card-icon {{ $isVerified ? 'green' : ($isPending ? 'gold' : ($isRejected ? 'red' : 'blue')) }}">
                        <i class="fas {{ $isVerified ? 'fa-shield-check' : ($isPending ? 'fa-hourglass-half' : ($isRejected ? 'fa-exclamation-triangle' : 'fa-id-card')) }}"></i>
                    </div>
                    <div>
                        <p class="stt-card-title">
                            Verification Status: 
                            @if($isVerified)
                                <span style="color: #86efac; font-weight: 800;">VERIFIED 🛡️</span>
                            @elseif($isPending)
                                <span style="color: #fde047; font-weight: 800;">PENDING REVIEW ⏳</span>
                            @elseif($isRejected)
                                <span style="color: #fca5a5; font-weight: 800;">REJECTED ⚠️</span>
                            @else
                                <span style="color: #94a3b8; font-weight: 800;">NOT SUBMITTED 📋</span>
                            @endif
                        </p>
                        <p class="stt-card-sub">
                            @if($isVerified)
                                Your identity has been verified. You have full access to transactions, meetups, and verified badges.
                            @elseif($isPending)
                                Your valid ID has been submitted on {{ $user->id_submitted_at ? $user->id_submitted_at->format('M d, Y') : 'recently' }} and is currently under review by administrators.
                            @elseif($isRejected)
                                Reason: {{ $user->id_rejection_reason ?? 'Document unreadable or invalid' }}. Please re-submit a clear copy below.
                            @else
                                Upload your government ID to build trust with buyers and sellers during meetups.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if(!$isVerified)
            <!-- Submission Form -->
            <form method="POST" action="{{ route('settings.id-verification.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="stt-card">
                    <div class="stt-card-header">
                        <div class="stt-card-icon teal"><i class="fas fa-upload"></i></div>
                        <div>
                            <p class="stt-card-title">{{ $isRejected ? 'Re-Submit Valid ID' : ($isPending ? 'Update Submitted Documents' : 'Submit Valid ID') }}</p>
                            <p class="stt-card-sub">Acceptable IDs: Philippine National ID (PhilSys), Driver's License, UMID, Passport, PRC, Postal ID, Voter's ID.</p>
                        </div>
                    </div>
                    <div class="stt-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="stt-label">Valid ID Type <span style="color: #ef4444;">*</span></label>
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
                                <label class="stt-label">ID Number <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="id_number" class="stt-input @error('id_number') is-invalid @enderror"
                                    value="{{ old('id_number', $user->id_number) }}" placeholder="e.g. 1234-5678-9012-3456" required>
                                @error('id_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="stt-label">Front ID Photo <span style="color: #ef4444;">*</span></label>
                                <input type="file" name="id_photo" class="stt-input @error('id_photo') is-invalid @enderror" accept="image/*" required>
                                <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Clear photo of the front side of your ID (JPG, PNG, WEBP up to 4MB)</small>
                                @error('id_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="stt-label">Selfie with ID <span style="color: #64748b;">(Optional but Recommended)</span></label>
                                <input type="file" name="id_selfie" class="stt-input @error('id_selfie') is-invalid @enderror" accept="image/*">
                                <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Holding your ID next to your face for fastest approval</small>
                                @error('id_selfie')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="stt-form-footer" style="margin-top: 1.5rem;">
                            <button type="submit" class="stt-btn" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);">
                                <i class="fas fa-paper-plane me-1"></i>Submit for Verification
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>

    </main>
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

    // Scroll to top smoothly on mobile
    if (window.innerWidth < 880) {
        document.querySelector('.stt-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function selectVisibility(val, el) {
    document.querySelectorAll('.stt-shield-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('pvInput').value = val;
}

// Dark mode (stored in localStorage, same as before)
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
        sttSwitch(hash, navBtn);
    }
});
</script>
@endsection
