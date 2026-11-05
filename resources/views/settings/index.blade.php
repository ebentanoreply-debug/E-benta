@extends(auth()->check() && auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->check() && auth()->user()->isSeller() ? 'layouts.seller' : 'layouts.buyer'))

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

/* ─── HERO HEADER ─────────────────────────────────────────── */
.stt-hero-header {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
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

.stt-nav-item:hover {
    background: rgba(13, 148, 136, 0.08);
    color: #0d9488;
    border-left-color: rgba(13, 148, 136, 0.4);
    transform: translateX(3px);
}

.stt-nav-item.active {
    background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
    color: #0d9488;
    font-weight: 800;
    border-left-color: #0d9488;
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

/* ─── CARDS ───────────────────────────────────────────── */
.stt-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
}

.stt-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #ffffff;
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

.stt-card-sub {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0;
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

.stt-input::placeholder { color: #94a3b8; }
.stt-input:focus {
    border-color: #0d9488;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
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

.stt-toggle-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.15rem;
    display: block;
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

/* ─── ID SCANNER & AUTO-FETCH STYLES ───────────────────────────────── */
.id-scan-card {
    border-radius: 1rem;
    padding: 1.1rem 1.25rem;
    margin-bottom: 1.25rem;
    transition: all 0.3s ease;
    animation: stt-fade 0.25s ease;
}

.id-scan-card.scanning {
    background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.12) 100%);
    border: 1.5px solid rgba(13, 148, 136, 0.35);
    box-shadow: 0 4px 15px rgba(13, 148, 136, 0.1);
}

.id-scan-card.success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(13, 148, 136, 0.12) 100%);
    border: 1.5px solid #10b981;
    box-shadow: 0 4px 18px rgba(16, 185, 129, 0.15);
}

.id-scan-card.info {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
}

.id-scan-spinner {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 0 15px rgba(13, 148, 136, 0.4);
    flex-shrink: 0;
}

.id-scan-check-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #10b981;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
}

.id-scan-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #0f172a;
}

.id-scan-success-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #065f46;
}

.id-scan-sub {
    font-size: 0.8rem;
    color: #64748b;
}

.id-scan-progress-bar {
    width: 100%;
    height: 6px;
    background: rgba(13, 148, 136, 0.15);
    border-radius: 99px;
    overflow: hidden;
}

.id-scan-progress-fill {
    height: 100%;
    width: 45%;
    background: linear-gradient(90deg, #0d9488, #06b6d4);
    border-radius: 99px;
    transition: width 0.3s ease;
    animation: scanPulse 1.5s infinite ease-in-out;
}

@keyframes scanPulse {
    0% { opacity: 0.6; transform: scaleX(0.9); }
    50% { opacity: 1; transform: scaleX(1); }
    100% { opacity: 0.6; transform: scaleX(0.9); }
}

.id-scan-chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.5rem;
}

.id-scan-chip {
    background: #ffffff;
    border: 1px solid rgba(13, 148, 136, 0.25);
    border-radius: 0.5rem;
    padding: 0.25rem 0.6rem;
    font-size: 0.78rem;
    color: #1e293b;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.auto-filled-highlight {
    animation: flashHighlight 1.5s ease;
}

@keyframes flashHighlight {
    0% { background-color: #d1fae5; border-color: #10b981; }
    50% { background-color: #ecfdf5; border-color: #0d9488; }
    100% { background-color: #f8fafc; }
}

/* ─── STEP BY STEP WIZARD STYLES ───────────────────────────────── */
.verif-wizard-stepper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 1.25rem 2rem;
    margin-bottom: 1.75rem;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
}

.verif-step-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    cursor: pointer;
    user-select: none;
    transition: all 0.25s ease;
}

.verif-step-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    border: 2px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.verif-step-item.active .verif-step-circle {
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    color: #ffffff;
    border-color: #0d9488;
    box-shadow: 0 0 16px rgba(13, 148, 136, 0.45);
}

.verif-step-item.completed .verif-step-circle {
    background: #10b981;
    color: #ffffff;
    border-color: #10b981;
}

.verif-step-label {
    display: flex;
    flex-direction: column;
}

.verif-step-num {
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #94a3b8;
}

.verif-step-item.active .verif-step-num {
    color: #0d9488;
}

.verif-step-name {
    font-size: 0.95rem;
    font-weight: 800;
    color: #475569;
}

.verif-step-item.active .verif-step-name {
    color: #0f172a;
}

.verif-step-line {
    flex: 1;
    height: 3px;
    background: #e2e8f0;
    margin: 0 1.25rem;
    border-radius: 99px;
    transition: all 0.3s ease;
}

.verif-step-line.active {
    background: linear-gradient(90deg, #0d9488, #06b6d4);
}

.verif-step-content {
    display: none;
    animation: stt-fade 0.25s ease;
}

.verif-step-content.active {
    display: block;
}

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 991.98px) {
    .verif-wizard-stepper {
        padding: 0.85rem 1rem;
        border-radius: 1rem;
    }
    .verif-step-name {
        display: none;
    }
    .verif-step-line {
        margin: 0 0.5rem;
    }
    .verif-step-circle {
        width: 34px;
        height: 34px;
        font-size: 0.85rem;
    }
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
                            <input type="file" id="sttAvatarFileQuick" name="avatar" accept="image/*" onchange="submitAvatarWithCompression(this, 'sttAvatarFormQuick')">
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

                @php
                    $validTabs = ['account', 'notifications', 'privacy', 'id-verification', 'payments', 'seller', 'preferences'];
                    $activeTab = request('tab', 'account');
                    if (!in_array($activeTab, $validTabs)) {
                        $activeTab = 'account';
                    }
                @endphp
                {{-- Tab navigation buttons --}}
                <nav class="stt-nav">
                    <button class="stt-nav-item {{ $activeTab === 'account' ? 'active' : '' }}" onclick="sttSwitch('account', this)">
                        <i class="fas fa-user-circle"></i> Account Details
                    </button>
                    <button class="stt-nav-item {{ $activeTab === 'notifications' ? 'active' : '' }}" onclick="sttSwitch('notifications', this)">
                        <i class="fas fa-bell"></i> Notifications
                    </button>
                    <button class="stt-nav-item {{ $activeTab === 'privacy' ? 'active' : '' }}" onclick="sttSwitch('privacy', this)">
                        <i class="fas fa-lock"></i> Privacy & Security
                    </button>
                    @if(!auth()->user()->isAdmin())
                    <button class="stt-nav-item {{ $activeTab === 'id-verification' ? 'active' : '' }}" onclick="sttSwitch('id-verification', this)">
                        <i class="fas fa-id-card"></i> ID & Location
                        @if(auth()->user()->isIdVerified())
                            <span class="stt-nav-badge" style="background: rgba(34,197,94,0.15); color: #16a34a; border: 1px solid rgba(34,197,94,0.3);">Verified</span>
                        @elseif(auth()->user()->isIdPending())
                            <span class="stt-nav-badge" style="background: rgba(245,158,11,0.15); color: #d97706; border: 1px solid rgba(245,158,11,0.3);">Pending</span>
                        @elseif(auth()->user()->id_verification_status === 'rejected')
                            <span class="stt-nav-badge" style="background: rgba(239,68,68,0.15); color: #dc2626; border: 1px solid rgba(239,68,68,0.3);">Action Needed</span>
                        @endif
                    </button>
                    <button class="stt-nav-item {{ $activeTab === 'payments' ? 'active' : '' }}" onclick="sttSwitch('payments', this)">
                        <i class="fas fa-credit-card"></i> Payout & Banking
                    </button>
                    @endif
                    @if(auth()->user()->isSeller())
                    <div class="stt-nav-divider"></div>
                    <button class="stt-nav-item {{ $activeTab === 'seller' ? 'active' : '' }}" onclick="sttSwitch('seller', this)">
                        <i class="fas fa-store"></i> Seller Profile
                        <span class="stt-nav-badge" style="background: rgba(13,148,136,0.15); color: #0d9488;">Seller</span>
                    </button>
                    @endif
                    <div class="stt-nav-divider"></div>
                    <button class="stt-nav-item {{ $activeTab === 'preferences' ? 'active' : '' }}" onclick="sttSwitch('preferences', this)">
                        <i class="fas fa-sliders-h"></i> Preferences
                    </button>
                </nav>
            </aside>

            {{-- ─── MAIN CONTENT ────────────────────────────────── --}}
            <main class="stt-content" style="min-width: 0;">

                {{-- ════════════════════════════════════════════════
                     TAB 1: ACCOUNT DETAILS
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-account" class="stt-panel {{ $activeTab === 'account' ? 'active' : '' }}">
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
                                <p class="stt-card-sub">Upload an avatar. JPG, PNG or WEBP (automatically optimized).</p>
                            </div>
                            <div style="margin-left: auto; display: flex; gap: 0.6rem; align-items: center;">
                                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="sttAvatarForm">
                                    @csrf
                                    <label for="sttAvatarFile" id="sttAvatarBtn" class="stt-btn" style="cursor: pointer; margin: 0;">
                                        <i class="fas fa-upload"></i>Upload Photo
                                    </label>
                                    <input type="file" id="sttAvatarFile" name="avatar" accept="image/*" style="display: none" onchange="submitAvatarWithCompression(this, 'sttAvatarForm')">
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
                                        <label class="stt-label">Province / Region</label>
                                        <select name="address_province" id="sttAccountProvince" class="stt-input @error('address_province') is-invalid @enderror">
                                            <option value="">Select Province...</option>
                                        </select>
                                        @error('address_province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">City / Municipality</label>
                                        <select name="address_city" id="sttAccountCity" class="stt-input @error('address_city') is-invalid @enderror">
                                            <option value="">Select City / Municipality...</option>
                                        </select>
                                        @error('address_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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
                <div id="stt-notifications" class="stt-panel {{ $activeTab === 'notifications' ? 'active' : '' }}">
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
                <div id="stt-privacy" class="stt-panel {{ $activeTab === 'privacy' ? 'active' : '' }}">
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
                <div id="stt-id-verification" class="stt-panel {{ $activeTab === 'id-verification' ? 'active' : '' }}">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">ID & Location <span>Verification</span></h2>
                        <p class="stt-panel-sub">Submit your valid government ID and confirm your physical pickup location for safe marketplace transactions.</p>
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
                                        <span style="color: #16a34a; font-weight: 800;">VERIFIED 🛡️📍</span>
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
                                        Your government ID and physical location have been verified. You hold full access to marketplace trades, pickup coordination, and trusted seller badges.
                                        @if($user->location_verified_at)
                                            <span class="d-block mt-1 text-muted" style="font-size: 0.78rem;">Verified on {{ $user->location_verified_at->format('M d, Y') }}</span>
                                        @endif
                                    @elseif($isPending)
                                        Submitted on {{ $user->id_submitted_at ? $user->id_submitted_at->format('M d, Y') : 'recently' }} — currently queued for administrator review. We are inspecting your ID and cross-referencing your declared location.
                                    @elseif($isRejected)
                                        <strong style="color: #dc2626;">Reason for Rejection:</strong> {{ $user->id_rejection_reason ?? 'Document unreadable, address mismatch, or expired ID' }}. Please review the feedback and re-submit below.
                                    @else
                                        All sellers must verify their identity and physical location before creating active listings on E-benta to prevent fraudulent pickup points and fake listings.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($isVerified)
                        <div class="stt-card">
                            <div class="stt-card-body p-4 text-center">
                                <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10b981; display: inline-flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 0.85rem;">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;" class="dark:text-white">Identity & Location Verified</h5>
                                <p class="text-muted" style="max-width: 520px; margin: 0 auto 1rem; font-size: 0.88rem;">
                                    Your account is verified using your <strong>{{ $user->id_type ?? 'Government ID' }}</strong> (ID No: <code style="font-size: 0.88rem; font-weight: 700; color: #0f766e; background: #ccfbf1; padding: 0.15rem 0.45rem; border-radius: 0.35rem;">{{ $user->masked_id_number ?? $user->id_number }}</code>).
                                </p>
                                <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.03); max-width: 540px; margin: 0 auto; font-size: 0.8rem; color: #64748b; border: 1px dashed rgba(100, 116, 139, 0.3);">
                                    <i class="fas fa-lock me-1 text-emerald"></i>
                                    <strong>Data Privacy Compliance (RA 10173):</strong> Physical document scans and biometric selfies are permanently sealed and protected from exposure to prevent identity theft.
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!$isVerified)
                    <!-- STEPPER INDICATOR BAR -->
                    <div class="verif-wizard-stepper mb-4">
                        <div class="verif-step-item active" id="stepIndicator1" onclick="goToVerifStep(1)">
                            <div class="verif-step-circle">1</div>
                            <div class="verif-step-label">
                                <span class="verif-step-num">Step 1</span>
                                <span class="verif-step-name">Upload ID Documents</span>
                            </div>
                        </div>
                        <div class="verif-step-line" id="stepLine1"></div>
                        <div class="verif-step-item" id="stepIndicator2" onclick="goToVerifStep(2)">
                            <div class="verif-step-circle">2</div>
                            <div class="verif-step-label">
                                <span class="verif-step-num">Step 2</span>
                                <span class="verif-step-name">Extracted Details & Location</span>
                            </div>
                        </div>
                        <div class="verif-step-line" id="stepLine2"></div>
                        <div class="verif-step-item" id="stepIndicator3" onclick="goToVerifStep(3)">
                            <div class="verif-step-circle">3</div>
                            <div class="verif-step-label">
                                <span class="verif-step-num">Step 3</span>
                                <span class="verif-step-name">Confirm & Submit</span>
                            </div>
                        </div>
                    </div>

                    {{-- Submission form with automatic mobile image compression & Step-by-Step wizard --}}
                    <form method="POST" action="{{ route('settings.id-verification.submit') }}" enctype="multipart/form-data" id="idVerificationForm" onsubmit="return handleIdVerificationSubmit(this, event)">
                        @csrf

                        {{-- Hidden ID & Demographic Fields: Auto-fetched from scanned document & QR Code --}}
                        <input type="hidden" name="id_type" id="idTypeInput" value="{{ old('id_type', $user->id_type ?? 'Philippine National ID (PhilSys)') }}">
                        <input type="hidden" name="birth_date" id="idVerifBirthDate" value="{{ old('birth_date', $user->birth_date) }}">
                        <input type="hidden" name="birth_place" id="idVerifBirthPlace" value="{{ old('birth_place', $user->birth_place) }}">
                        <input type="hidden" name="gender" id="idVerifGender" value="{{ old('gender', $user->gender) }}">
                        <input type="hidden" name="marital_status" id="idVerifMaritalStatus" value="{{ old('marital_status', $user->marital_status) }}">
                        <input type="hidden" name="blood_type" id="idVerifBloodType" value="{{ old('blood_type', $user->blood_type) }}">
                        <input type="hidden" name="id_card_serial" id="idVerifCardSerial" value="{{ old('id_card_serial', $user->id_card_serial) }}">
                        <input type="hidden" name="id_raw_qr_data" id="idVerifRawQrData" value="{{ old('id_raw_qr_data', $user->id_raw_qr_data) }}">

                        <!-- ========================================================
                             STEP 1: UPLOAD GOVERNMENT ID DOCUMENTS ONLY
                             ======================================================== -->
                        <div class="verif-step-content active" id="verifStep1">
                            <div class="stt-card">
                                <div class="stt-card-header">
                                    <div class="stt-card-icon teal"><i class="fas fa-id-card"></i></div>
                                    <div>
                                        <p class="stt-card-title">Step 1 of 3: Upload Government ID</p>
                                        <p class="stt-card-sub">Upload your valid Philippine ID. ID details, number, and location will be automatically fetched.</p>
                                    </div>
                                </div>
                                <div class="stt-card-body">
                                    <!-- SCAN ERROR ALERT (Shown if ID is unreadable or blurry) -->
                                    <div id="idScanErrorBox" style="display:none;"></div>

                                    <!-- SCAN PROGRESS CARD -->
                                    <div id="idScanStatusCard" class="id-scan-card mb-3" style="display:none;"></div>

                                    <div class="p-3 mb-3 rounded-3" style="background: rgba(13, 148, 136, 0.05); border: 1px solid rgba(13, 148, 136, 0.2);">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fas fa-shield-halved text-teal"></i>
                                            <strong style="color: #0f766e; font-size: 0.88rem;">Philippine Government ID Verification</strong>
                                        </div>
                                        <p class="mb-0 text-muted" style="font-size: 0.82rem;">
                                            Accepted IDs: Philippine National ID (PhilSys), Driver's License, UMID / SSS, Passport, PRC ID, or Postal ID. Please upload clear photos so your details can be verified accurately.
                                        </p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="stt-label">Front ID Photo <span class="text-danger">*</span></label>
                                            <input type="file" name="id_photo" id="idPhotoInput" class="stt-input @error('id_photo') is-invalid @enderror" accept="image/*" {{ $user->id_photo_url ? '' : 'required' }} onchange="previewAndCompressDoc(this, 'idPhotoPreview')">
                                            <div id="idPhotoPreview" class="mt-1"></div>
                                            <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Front side showing photo and name (JPG, PNG, WEBP)</small>
                                            @if($user->id_photo_url)
                                                 <div class="mt-1 d-flex align-items-center gap-2">
                                                     <span class="badge bg-success" style="font-size: 0.72rem;"><i class="fas fa-check me-1"></i>Current File Uploaded</span>
                                                     <a href="{{ $user->id_photo_url }}" target="_blank" style="font-size: 0.78rem; color: #0d9488; font-weight: 700;">View Uploaded Photo</a>
                                                 </div>
                                            @endif
                                            @error('id_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="stt-label">Back ID Photo <span class="text-danger">* (Address Side)</span></label>
                                            <input type="file" name="id_back_photo" id="idBackPhotoInput" class="stt-input @error('id_back_photo') is-invalid @enderror" accept="image/*" onchange="previewAndCompressDoc(this, 'idBackPhotoPreview')">
                                            <div id="idBackPhotoPreview" class="mt-1"></div>
                                            <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Back side showing address and QR code (JPG, PNG, WEBP)</small>
                                            @if($user->id_back_photo_url)
                                                 <div class="mt-1 d-flex align-items-center gap-2">
                                                     <span class="badge bg-success" style="font-size: 0.72rem;"><i class="fas fa-check me-1"></i>Current Back ID Uploaded</span>
                                                     <a href="{{ $user->id_back_photo_url }}" target="_blank" style="font-size: 0.78rem; color: #0d9488; font-weight: 700;">View Back ID</a>
                                                 </div>
                                            @endif
                                            @error('id_back_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="stt-label">Selfie Holding ID <span style="color: #64748b;">(Optional for faster approval)</span></label>
                                            <input type="file" name="id_selfie" id="idSelfieInput" class="stt-input @error('id_selfie') is-invalid @enderror" accept="image/*" onchange="previewAndCompressDoc(this, 'idSelfiePreview')">
                                            <div id="idSelfiePreview" class="mt-1"></div>
                                            <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Hold your government ID beside your face</small>
                                            @if($user->id_selfie_url)
                                                 <div class="mt-1 d-flex align-items-center gap-2">
                                                     <span class="badge bg-secondary" style="font-size: 0.72rem;"><i class="fas fa-check me-1"></i>Selfie Uploaded</span>
                                                     <a href="{{ $user->id_selfie_url }}" target="_blank" style="font-size: 0.78rem; color: #0d9488; font-weight: 700;">View Selfie</a>
                                                 </div>
                                            @endif
                                            @error('id_selfie')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button type="button" id="btnScanAndContinue" class="stt-btn" onclick="validateAndScanIdStep1()" style="padding: 0.8rem 1.8rem; font-size: 0.95rem;">
                                            <span>Next: Scan & Verify ID Details</span>
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ========================================================
                             STEP 2: EXTRACTED ID DETAILS & PICKUP LOCATION
                             ======================================================== -->
                        <div class="verif-step-content" id="verifStep2">
                            <div class="stt-card">
                                <div class="stt-card-header">
                                    <div class="stt-card-icon blue"><i class="fas fa-map-location-dot"></i></div>
                                    <div>
                                        <p class="stt-card-title">Step 2 of 3: Extracted Details & Location</p>
                                        <p class="stt-card-sub">All details below were automatically retrieved from your ID. Review your registered pickup address.</p>
                                    </div>
                                </div>
                                <div class="stt-card-body">
                                    <!-- AUTO-FETCHED ID DETAILS DISPLAY CARD (Auto-populated from ID) -->
                                    <div class="p-3 mb-3 rounded-3" id="extractedIdDetailsDisplayCard" style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.1) 100%); border: 1.5px solid rgba(13, 148, 136, 0.3);">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-shield-halved text-teal fa-lg"></i>
                                                <strong style="color: #0f172a; font-size: 0.92rem;">Verified Document Information (Fetched from ID)</strong>
                                            </div>
                                            <span class="badge bg-success" style="font-size: 0.74rem; font-weight: 700;"><i class="fas fa-check-circle me-1"></i>Auto-Fetched from ID</span>
                                        </div>
                                        <div class="row g-3 pt-1">
                                            <div class="col-md-6">
                                                <label class="stt-label mb-1" style="color: #475569; font-size: 0.78rem;">Verified Government ID</label>
                                                <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background: #ffffff; border: 1.5px solid #ccfbf1; min-height: 42px;">
                                                    <i class="fas fa-id-card text-teal"></i>
                                                    <strong id="displayExtractedIdType" style="color: #0f766e; font-size: 0.9rem;">{{ $user->id_type ?? 'Philippine National ID (PhilSys)' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <label class="stt-label mb-0" style="color: #475569; font-size: 0.78rem;">Extracted ID Number</label>
                                                    <span class="badge bg-teal-subtle text-teal" style="font-size: 0.68rem; font-weight: 700;"><i class="fas fa-wand-magic-sparkles me-1"></i>Auto-Retrieved</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background: #ffffff; border: 1.5px solid #0d9488; min-height: 42px;">
                                                    <i class="fas fa-fingerprint text-teal"></i>
                                                    <input type="text" name="id_number" id="idNumberInput" class="form-control border-0 p-0 shadow-none" 
                                                        value="{{ old('id_number', $user->id_number) }}" 
                                                        placeholder="Auto-fetched from ID photo" 
                                                        required 
                                                        style="font-weight: 800; color: #0d9488; font-size: 0.95rem; background: transparent; letter-spacing: 0.5px;">
                                                </div>
                                                <small style="font-size: 0.72rem; color: #64748b; margin-top: 0.25rem; display: block;">
                                                    <i class="fas fa-check-double text-teal me-1"></i>Automatically retrieved from your uploaded card. No manual typing needed.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- QR CODE & DEMOGRAPHIC DETAILS BOX (Scanned from ID) -->
                                    <div id="qrDecodedDetailsBox" class="p-3 mb-4 rounded-3" style="background: #ffffff; border: 1.5px solid #06b6d4; box-shadow: 0 4px 15px rgba(6, 182, 212, 0.08);">
                                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(6, 182, 212, 0.12); color: #0891b2; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                                    <i class="fas fa-qrcode"></i>
                                                </div>
                                                <div>
                                                    <strong style="color: #0f172a; font-size: 0.9rem;">QR Code & Document Details Verified</strong>
                                                    <span class="d-block text-muted" style="font-size: 0.74rem;">Decoded demographic identity, birthday, and official security features from your ID</span>
                                                </div>
                                            </div>
                                            <span class="badge" id="qrStatusBadge" style="background: rgba(6, 182, 212, 0.15); color: #0891b2; font-weight: 700; font-size: 0.72rem; padding: 0.35rem 0.65rem;">
                                                <i class="fas fa-shield-check me-1"></i>QR Code Verified
                                            </span>
                                        </div>
                                        <div class="row g-2 pt-1" style="font-size: 0.82rem;">
                                            <div class="col-sm-6 col-md-4">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-user text-teal me-1"></i>Full Legal Name</span>
                                                <strong id="displayQrName" style="color: #0f172a;">{{ $user->name }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-cake-candles text-danger me-1"></i>Birthday (Date of Birth)</span>
                                                <strong id="displayQrBirthDate" style="color: #0f172a;">{{ $user->birth_date ?? 'October 24, 2002' }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-location-dot text-teal me-1"></i>Place of Birth</span>
                                                <strong id="displayQrPlaceOfBirth" style="color: #0f172a;">{{ $user->birth_place ?? 'Bayambang, Pangasinan' }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-3 mt-2">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-venus-mars text-primary me-1"></i>Sex / Kasarian</span>
                                                <strong id="displayQrGender" style="color: #0f172a;">{{ $user->gender ?? 'Male' }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-3 mt-2">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-droplet text-danger me-1"></i>Blood Type</span>
                                                <strong id="displayQrBloodType" style="color: #0f172a;">{{ $user->blood_type ?? 'O+' }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-3 mt-2">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-ring text-warning me-1"></i>Civil Status</span>
                                                <strong id="displayQrCivilStatus" style="color: #0f172a;">{{ $user->marital_status ?? 'Single' }}</strong>
                                            </div>
                                            <div class="col-sm-6 col-md-3 mt-2">
                                                <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fas fa-barcode text-cyan me-1"></i>Card Serial</span>
                                                <code id="displayQrBarcode" style="font-size: 0.8rem; font-weight: 700; color: #0891b2; background: #ecfeff; padding: 0.15rem 0.45rem; border-radius: 0.3rem; border: 1px solid #cffafe;">{{ $user->id_card_serial ?? '23F0969175' }}</code>
                                            </div>
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div style="flex: 1; min-width: 250px;">
                                                        <span class="text-muted d-block" style="font-size: 0.7rem;"><i class="fas fa-qrcode text-teal me-1"></i>Decoded QR Data / Security Stream</span>
                                                        <code id="displayQrPayload" style="font-size: 0.75rem; color: #0f766e; background: #f0fdfa; padding: 0.2rem 0.5rem; border-radius: 0.35rem; display: inline-block; word-break: break-all;">PhilSys QR Digital Signature: PCN {{ $user->id_number ?? '5908-9120-1780-9349' }} | Authenticated by PSA Security</code>
                                                    </div>
                                                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-size: 0.72rem; font-weight: 700;">
                                                        <i class="fas fa-check-double me-1"></i>All ID & QR Details Fetched
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="stt-label">Province / Region <span class="text-danger">*</span></label>
                                            <select name="address_province" id="idVerifProvince" class="stt-input @error('address_province') is-invalid @enderror" required>
                                                <option value="">Select Province...</option>
                                            </select>
                                            @error('address_province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="stt-label">City / Municipality <span class="text-danger">*</span></label>
                                            <select name="address_city" id="idVerifCity" class="stt-input @error('address_city') is-invalid @enderror" required>
                                                <option value="">Select Municipality / City...</option>
                                            </select>
                                            @error('address_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <label class="stt-label mb-0">Barangay <span class="text-danger">*</span></label>
                                                <button type="button" class="btn btn-link p-0 text-decoration-none" id="btnToggleBarangayInput" onclick="toggleCustomBarangayMode()" style="font-size: 0.74rem; color: #0d9488; font-weight: 700;">
                                                    <i class="fas fa-pen me-1"></i>Type manually
                                                </button>
                                            </div>
                                            <select id="idVerifBarangaySelect" class="stt-input @error('barangay') is-invalid @enderror" onchange="syncBarangayFromSelect(this)">
                                                <option value="">-- Select Barangay --</option>
                                            </select>
                                            <input type="text" name="barangay" id="idVerifBarangay" class="stt-input mt-1 @error('barangay') is-invalid @enderror"
                                                value="{{ old('barangay', $user->barangay ?? 'San Juan') }}" placeholder="Enter Barangay name" required style="display:none;">
                                            @error('barangay')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-5">
                                            <label class="stt-label">Street Address / Building / Unit No. <span class="text-danger">*</span></label>
                                            <input type="text" name="address_line_1" id="idVerifAddress1" class="stt-input @error('address_line_1') is-invalid @enderror"
                                                value="{{ old('address_line_1', $user->address_line_1 ?? $user->addresses()->first()?->address_line_1) }}"
                                                placeholder="e.g. Unit 402 Palm Tower, 123 Emerald Ave" required>
                                            @error('address_line_1')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="stt-label">Postal / ZIP Code <span class="text-danger">*</span></label>
                                            <input type="text" name="postal_code" id="idVerifPostal" class="stt-input @error('postal_code') is-invalid @enderror"
                                                value="{{ old('postal_code', $user->postal_code ?? $user->addresses()->first()?->postal_code ?? '2420') }}"
                                                placeholder="e.g. 2420" required>
                                            @error('postal_code')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="stt-label">Pickup Notes & Specific Landmarks <span style="color: #64748b;">(Optional)</span></label>
                                            <input type="text" name="location_notes" class="stt-input @error('location_notes') is-invalid @enderror"
                                                value="{{ old('location_notes', $user->location_notes) }}"
                                                placeholder="e.g. Near San Antonio de Padua Parish, blue gate with bell">
                                            @error('location_notes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <button type="button" class="stt-btn-ghost" onclick="goToVerifStep(1)">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            <span>Back to ID Upload</span>
                                        </button>
                                        <button type="button" class="stt-btn" onclick="goToVerifStep(3)">
                                            <span>Continue to Step 3: Confirmation</span>
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ========================================================
                             STEP 3: PROOF OF ADDRESS & FINAL REVIEW
                             ======================================================== -->
                        <div class="verif-step-content" id="verifStep3">
                            <div class="stt-card">
                                <div class="stt-card-header">
                                    <div class="stt-card-icon purple"><i class="fas fa-file-invoice"></i></div>
                                    <div>
                                        <p class="stt-card-title">Step 3 of 3: Proof of Location & Final Review</p>
                                        <p class="stt-card-sub">Confirm how your physical location corresponds with your documents.</p>
                                    </div>
                                </div>
                                <div class="stt-card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="stt-label">Address Proof Basis <span class="text-danger">*</span></label>
                                            <select name="proof_of_address_type" class="stt-input @error('proof_of_address_type') is-invalid @enderror" required>
                                                <option value="id_address_match" {{ old('proof_of_address_type', $user->proof_of_address_type) === 'id_address_match' ? 'selected' : '' }}>
                                                    Address is clearly stated on my submitted ID card
                                                </option>
                                                <option value="barangay_certificate" {{ old('proof_of_address_type', $user->proof_of_address_type) === 'barangay_certificate' ? 'selected' : '' }}>
                                                    Barangay Certificate of Residency / Clearance
                                                </option>
                                                <option value="utility_bill" {{ old('proof_of_address_type', $user->proof_of_address_type) === 'utility_bill' ? 'selected' : '' }}>
                                                    Utility Bill (Electricity, Water, Internet, Telco)
                                                </option>
                                                <option value="lease_contract" {{ old('proof_of_address_type', $user->proof_of_address_type) === 'lease_contract' ? 'selected' : '' }}>
                                                    Commercial / Residential Lease Contract
                                                </option>
                                                <option value="business_permit" {{ old('proof_of_address_type', $user->proof_of_address_type) === 'business_permit' ? 'selected' : '' }}>
                                                    Mayor's Permit / DTI / Business Registration
                                                </option>
                                            </select>
                                            @error('proof_of_address_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="stt-label">Supplemental Proof Document <span style="color: #64748b;">(Optional if ID already shows address)</span></label>
                                            <input type="file" name="proof_of_address" id="proofAddressInput" class="stt-input @error('proof_of_address') is-invalid @enderror" accept="image/*,application/pdf" onchange="previewAndCompressDoc(this, 'proofAddressPreview')">
                                            <div id="proofAddressPreview" class="mt-1"></div>
                                            <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 0.25rem;">Barangay Cert, Meralco bill, or lease contract (max 25MB)</small>
                                            @if($user->proof_of_address_url)
                                                <div class="mt-1 d-flex align-items-center gap-2">
                                                    <span class="badge bg-purple" style="font-size: 0.72rem; background: #9333ea; color: white;"><i class="fas fa-check me-1"></i>Document Attached</span>
                                                    <a href="{{ $user->proof_of_address_url }}" target="_blank" style="font-size: 0.78rem; color: #0d9488; font-weight: 700;">View Proof Document</a>
                                                </div>
                                            @endif
                                            @error('proof_of_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <!-- FINAL SUBMISSION SUMMARY BOX -->
                                    <div class="mt-4 p-3 rounded-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
                                        <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                            <i class="fas fa-clipboard-check text-teal"></i>
                                            <strong style="color: #0f172a; font-size: 0.92rem;">Verification Submission Summary</strong>
                                        </div>
                                        <div class="row g-2" style="font-size: 0.85rem;">
                                            <div class="col-md-6">
                                                <span style="color: #64748b;">Full Legal Name:</span>
                                                <strong id="summaryFullName" style="color: #0f172a; margin-left: 0.25rem;">{{ $user->name }}</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <span style="color: #64748b;">Extracted ID No:</span>
                                                <code id="summaryIdNumber" style="font-size: 0.88rem; font-weight: 700; color: #0d9488; background: #ffffff; padding: 0.15rem 0.45rem; border-radius: 0.35rem; border: 1px solid #ccfbf1; margin-left: 0.25rem;">{{ $user->id_number ?? 'Auto-verified' }}</code>
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <span style="color: #64748b;">Government ID:</span>
                                                <strong id="summaryDocType" style="color: #0f172a; margin-left: 0.25rem;">{{ $user->id_type ?? 'Philippine National ID (PhilSys)' }}</strong>
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <span style="color: #64748b;">Birthday & Birthplace:</span>
                                                <strong id="summaryBirthDetails" style="color: #0f172a; margin-left: 0.25rem;">{{ $user->birth_date ?? 'October 24, 2002' }} ({{ $user->birth_place ?? 'Bayambang, Pangasinan' }})</strong>
                                            </div>
                                            <div class="col-12 mt-1">
                                                <span style="color: #64748b;">Pickup & Registered Location:</span>
                                                <strong id="summaryLocation" style="color: #0d9488; margin-left: 0.25rem;">{{ $user->barangay ? 'Brgy. ' . $user->barangay . ', ' : '' }}{{ $user->address_city ?? 'San Carlos City' }}, {{ $user->address_province ?? 'Pangasinan' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <button type="button" class="stt-btn-ghost" onclick="goToVerifStep(2)">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            <span>Back: Location</span>
                                        </button>
                                        <button type="submit" id="idVerificationSubmitBtn" class="stt-btn" style="padding: 0.8rem 1.8rem; font-size: 0.95rem;">
                                            <i class="fas fa-paper-plane me-2"></i>{{ $isRejected ? 'Re-Submit ID & Location for Review' : ($isPending ? 'Update Submitted Documents' : 'Submit ID & Location for Verification') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>

                {{-- ════════════════════════════════════════════════
                     TAB 5: PAYMENTS & PAYOUTS (Members only)
                ═══════════════════════════════════════════════════ --}}
                <div id="stt-payments" class="stt-panel {{ $activeTab === 'payments' ? 'active' : '' }}">
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
                <div id="stt-seller" class="stt-panel {{ $activeTab === 'seller' ? 'active' : '' }}">
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
                                        <label class="stt-label">Province / Region</label>
                                        <select name="address_province" id="sttSellerProvince" class="stt-input @error('address_province') is-invalid @enderror">
                                            <option value="">Select Province...</option>
                                        </select>
                                        @error('address_province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="stt-label">City / Municipality</label>
                                        <select name="address_city" id="sttSellerCity" class="stt-input @error('address_city') is-invalid @enderror">
                                            <option value="">Select City / Municipality...</option>
                                        </select>
                                        @error('address_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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
                <div id="stt-preferences" class="stt-panel {{ $activeTab === 'preferences' ? 'active' : '' }}">
                    <div class="stt-panel-header">
                        <h2 class="stt-panel-title">General <span>Preferences</span></h2>
                        <p class="stt-panel-sub">Localization standards and account preferences.</p>
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

<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script src="{{ asset('js/jsqr.min.js') }}"></script>
<script src="{{ asset('js/zxing.min.js') }}"></script>
<script src="{{ asset('js/image-compressor.js') }}"></script>
<script src="{{ asset('js/philippine-locations.js') }}?v={{ file_exists(public_path('js/philippine-locations.js')) ? filemtime(public_path('js/philippine-locations.js')) : time() }}"></script>
<script src="{{ asset('js/id-scanner.js') }}?v={{ file_exists(public_path('js/id-scanner.js')) ? filemtime(public_path('js/id-scanner.js')) : time() }}"></script>
<script>
// Document Compression State Tracker
const pendingCompressions = new Set();

async function previewAndCompressDoc(inputEl, previewId) {
    const previewBox = document.getElementById(previewId);
    if (!inputEl || !inputEl.files || inputEl.files.length === 0) {
        if (previewBox) previewBox.innerHTML = '';
        return;
    }

    const file = inputEl.files[0];
    const isImage = file.type && file.type.startsWith('image/');

    if (previewBox) {
        previewBox.style.display = 'block';
        previewBox.innerHTML = `
            <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.4rem 0.6rem; background: #f1f5f9; border-radius: 0.5rem; font-size: 0.78rem;">
                <i class="fas fa-spinner fa-spin" style="color: #0d9488;"></i>
                <span style="color: #475569;">Optimizing photo (${(file.size / 1024 / 1024).toFixed(1)} MB)...</span>
            </div>
        `;
    }

    if (!isImage) {
        if (previewBox) {
            previewBox.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.4rem 0.6rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem; font-size: 0.78rem;">
                    <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1rem;"></i>
                    <span style="color: #166534; font-weight: 600;">${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
                </div>
            `;
        }
        return;
    }

    pendingCompressions.add(inputEl.name);

    try {
        const compressedFile = await window.ImageCompressor.compress(file, {
            maxWidth: 2048,
            maxHeight: 2048,
            quality: 0.82
        });

        // Update the file input using DataTransfer
        const dt = new DataTransfer();
        dt.items.add(compressedFile);
        inputEl.files = dt.files;

        if (previewBox) {
            const previewUrl = URL.createObjectURL(compressedFile);
            previewBox.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem;">
                    <img src="${previewUrl}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; border: 1px solid #86efac;">
                    <div style="font-size: 0.78rem; line-height: 1.35;">
                        <div style="font-weight: 700; color: #15803d;"><i class="fas fa-check-circle me-1"></i>Optimized & Ready</div>
                        <span style="color: #64748b;">${(file.size / 1024 / 1024).toFixed(1)} MB ➔ <strong style="color: #0f172a;">${(compressedFile.size / 1024).toFixed(0)} KB</strong></span>
                    </div>
                </div>
            `;
        }
    } catch (err) {
        console.warn('Compression fallback', err);
    } finally {
        pendingCompressions.delete(inputEl.name);
    }
}

async function submitAvatarWithCompression(inputEl, formId) {
    if (!inputEl || !inputEl.files || inputEl.files.length === 0) return;

    const file = inputEl.files[0];
    const form = document.getElementById(formId);
    if (!form) return;

    // Show indicator
    const btn = document.getElementById('sttAvatarBtn');
    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Optimizing...';
        btn.style.pointerEvents = 'none';
    }

    try {
        const compressed = await window.ImageCompressor.compress(file, {
            maxWidth: 800,
            maxHeight: 800,
            quality: 0.85
        });

        const dt = new DataTransfer();
        dt.items.add(compressed);
        inputEl.files = dt.files;
    } catch (e) {
        console.warn(e);
    }

    form.submit();
}

async function handleIdVerificationSubmit(form, event) {
    const submitBtn = document.getElementById('idVerificationSubmitBtn');
    
    // Check if any compressions are currently working
    if (pendingCompressions.size > 0) {
        event.preventDefault();
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Optimizing Images, Please wait...';
        }
        const checkDone = setInterval(() => {
            if (pendingCompressions.size === 0) {
                clearInterval(checkDone);
                form.submit();
            }
        }, 150);
        return false;
    }

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading Documents...';
    }

    const ready = await window.ImageCompressor.prepareFormForSubmit(form);
    if (!ready) {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit ID & Location for Verification';
        }
        return false;
    }

    return true;
}

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

/* ─── STEP-BY-STEP VERIFICATION WIZARD NAVIGATION ─────────────────── */
window.CURRENT_VERIF_STEP = 1;
window.ID_VERIFICATION_SCANNED = {{ $user->id_photo_url ? 'true' : 'false' }};
window.USER_HAS_EXISTING_ID = {{ $user->id_photo_url ? 'true' : 'false' }};
window.EXISTING_USER_ID_NUMBER = "{{ $user->id_number ?? '' }}";
window.USER_NAME = "{{ $user->name ?? '' }}";

function goToVerifStep(targetStep) {
    targetStep = parseInt(targetStep, 10);
    if (isNaN(targetStep) || targetStep < 1 || targetStep > 3) return;

    const frontInput = document.getElementById('idPhotoInput');
    const hasFrontFile = frontInput && frontInput.files && frontInput.files.length > 0;
    const hasExisting = window.USER_HAS_EXISTING_ID === true;

    // Moving to Step 2: STRICT CHECK - Only allow if ID was uploaded and verified readable
    if (targetStep === 2) {
        if (!window.ID_VERIFICATION_SCANNED && !hasExisting) {
            if (hasFrontFile) {
                // Photo is chosen, run the scanner validation
                if (typeof window.validateAndScanIdStep1 === 'function') {
                    window.validateAndScanIdStep1();
                }
                return;
            } else {
                if (typeof window.showStep1Error === 'function') {
                    window.showStep1Error('Please upload your Philippine Government ID before proceeding.');
                }
                if (frontInput) frontInput.focus();
                return;
            }
        }
    } 
    // Moving to Step 3: Validate Step 1 completed and Step 2 location fields filled
    else if (targetStep === 3) {
        if (!window.ID_VERIFICATION_SCANNED && !hasExisting) {
            goToVerifStep(1);
            return;
        }

        const prov = document.getElementById('idVerifProvince');
        const city = document.getElementById('idVerifCity');
        const brgy = document.getElementById('idVerifBarangay');
        const addr1 = document.getElementById('idVerifAddress1');

        if (prov && !prov.value) {
            alert('Please select your Province.');
            prov.focus();
            return;
        }
        if (city && !city.value) {
            alert('Please select your Municipality / City.');
            city.focus();
            return;
        }
        if (brgy && !brgy.value.trim()) {
            alert('Please enter your Barangay.');
            brgy.focus();
            return;
        }
        if (addr1 && !addr1.value.trim()) {
            alert('Please enter your Street Address.');
            addr1.focus();
            return;
        }

        updateStep3ReviewSummary();
    }

    window.CURRENT_VERIF_STEP = targetStep;

    // Strict toggle: ONLY active step is displayed, others are hidden
    for (let s = 1; s <= 3; s++) {
        const stepEl = document.getElementById('verifStep' + s);
        const indEl = document.getElementById('stepIndicator' + s);
        if (stepEl) {
            if (s === targetStep) {
                stepEl.classList.add('active');
            } else {
                stepEl.classList.remove('active');
            }
        }
        if (indEl) {
            if (s === targetStep) {
                indEl.classList.add('active');
                indEl.classList.remove('completed');
            } else if (s < targetStep) {
                indEl.classList.remove('active');
                indEl.classList.add('completed');
            } else {
                indEl.classList.remove('active');
                indEl.classList.remove('completed');
            }
        }
    }

    // Update lines
    const line1 = document.getElementById('stepLine1');
    const line2 = document.getElementById('stepLine2');
    if (line1) {
        if (targetStep >= 2) line1.classList.add('completed');
        else line1.classList.remove('completed');
    }
    if (line2) {
        if (targetStep >= 3) line2.classList.add('completed');
        else line2.classList.remove('completed');
    }

    // Scroll smoothly to top of wizard
    const stepper = document.querySelector('.verif-wizard-stepper');
    if (stepper) {
        stepper.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function updateStep3ReviewSummary() {
    const docType = document.getElementById('idTypeInput')?.value || document.getElementById('displayExtractedIdType')?.textContent || 'Philippine National ID (PhilSys)';
    const idNum = document.getElementById('idNumberInput')?.value || '5908-9120-1780-9349';
    const fullName = document.getElementById('displayQrName')?.textContent || window.USER_NAME || 'Nico Mark Agbuya';
    const birthDate = document.getElementById('idVerifBirthDate')?.value || document.getElementById('displayQrBirthDate')?.textContent || 'October 24, 2002';
    const birthPlace = document.getElementById('idVerifBirthPlace')?.value || document.getElementById('displayQrPlaceOfBirth')?.textContent || 'Bayambang, Pangasinan';
    const prov = document.getElementById('idVerifProvince')?.value || '';
    const city = document.getElementById('idVerifCity')?.value || '';
    const brgy = document.getElementById('idVerifBarangay')?.value || '';

    const summaryName = document.getElementById('summaryFullName');
    const summaryDoc = document.getElementById('summaryDocType');
    const summaryNum = document.getElementById('summaryIdNumber');
    const summaryBirth = document.getElementById('summaryBirthDetails');
    const summaryLoc = document.getElementById('summaryLocation');

    if (summaryName) summaryName.textContent = fullName;
    if (summaryDoc) summaryDoc.textContent = docType;
    if (summaryNum) summaryNum.textContent = idNum;
    if (summaryBirth) summaryBirth.textContent = `${birthDate} (${birthPlace})`;
    if (summaryLoc) {
        let parts = [];
        if (brgy) parts.push('Brgy. ' + brgy);
        if (city) parts.push(city);
        if (prov) parts.push(prov);
        summaryLoc.textContent = parts.join(', ') || 'Not specified';
    }
}

function syncBarangayFromSelect(sel) {
    const textInput = document.getElementById('idVerifBarangay');
    if (!textInput || !sel) return;
    if (sel.value === '__custom__') {
        sel.style.display = 'none';
        textInput.style.display = 'block';
        textInput.value = '';
        textInput.focus();
        const btn = document.getElementById('btnToggleBarangayInput');
        if (btn) btn.innerHTML = '<i class="fas fa-list me-1"></i>Select from list';
    } else {
        textInput.value = sel.value;
    }
}

function toggleCustomBarangayMode() {
    const sel = document.getElementById('idVerifBarangaySelect');
    const textInput = document.getElementById('idVerifBarangay');
    const btn = document.getElementById('btnToggleBarangayInput');
    if (!sel || !textInput) return;

    if (sel.style.display !== 'none') {
        sel.style.display = 'none';
        textInput.style.display = 'block';
        textInput.focus();
        if (btn) btn.innerHTML = '<i class="fas fa-list me-1"></i>Select from list';
    } else {
        textInput.style.display = 'none';
        sel.style.display = 'block';
        if (btn) btn.innerHTML = '<i class="fas fa-pen me-1"></i>Type manually';
        if (sel.value && sel.value !== '__custom__') {
            textInput.value = sel.value;
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Initialize cascading province & municipality dropdowns
    // 1. Verification tab
    if (typeof window.initProvinceAndCityDropdowns === 'function') {
        window.initProvinceAndCityDropdowns(
            'idVerifProvince',
            'idVerifCity',
            "{{ old('address_province', $user->address_province ?? $user->addresses()->first()?->state ?? 'Pangasinan') }}",
            "{{ old('address_city', $user->address_city ?? $user->addresses()->first()?->city ?? 'San Carlos City') }}",
            'idVerifPostal',
            'idVerifBarangaySelect',
            "{{ old('barangay', $user->barangay ?? 'San Juan') }}"
        );

        // 2. Account profile tab
        const accProv = document.getElementById('sttAccountProvince');
        const accCity = document.getElementById('sttAccountCity');
        if (accProv && accCity) {
            window.initProvinceAndCityDropdowns(
                accProv,
                accCity,
                "{{ old('address_province', auth()->user()->address_province ?? 'Pangasinan') }}",
                "{{ old('address_city', auth()->user()->address_city ?? 'San Carlos City') }}"
            );
        }

        // 3. Seller profile tab
        const sellProv = document.getElementById('sttSellerProvince');
        const sellCity = document.getElementById('sttSellerCity');
        if (sellProv && sellCity) {
            window.initProvinceAndCityDropdowns(
                sellProv,
                sellCity,
                "{{ old('address_province', auth()->user()->address_province ?? 'Pangasinan') }}",
                "{{ old('address_city', auth()->user()->address_city ?? 'San Carlos City') }}"
            );
        }
    }

    // Restore active tab: Priority 1. Query parameter (?tab=id-verification), Priority 2. Hash (#id-verification)
    const urlParams = new URLSearchParams(window.location.search);
    const queryTab = urlParams.get('tab');
    const hashTab = window.location.hash.replace('#', '');
    const targetTab = queryTab || hashTab;
    const panels = ['account', 'notifications', 'privacy', 'id-verification', 'payments', 'seller', 'preferences'];

    if (targetTab && panels.includes(targetTab)) {
        const navBtn = document.querySelector(`.stt-nav-item[onclick*="'${targetTab}'"]`);
        if (navBtn) {
            sttSwitch(targetTab, navBtn);
        }
    }

    // Reactive tab switching on hash change (e.g. clicking dashboard banners or browser back/forward)
    window.addEventListener('hashchange', function() {
        const currentHash = window.location.hash.replace('#', '');
        if (currentHash && panels.includes(currentHash)) {
            sttSwitch(currentHash);
        }
    });
});
</script>
@endsection
