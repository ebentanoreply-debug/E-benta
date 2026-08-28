@extends('layouts.app')

@section('title', 'Admin Dashboard & Control Center - E-Benta')

@section('styles')
<style>
    /* ==========================================================================
       ADMIN CONTROL CENTER MODERN DESIGN SYSTEM
       ========================================================================== */
    .admin-dashboard-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .admin-dashboard-container {
        background: #09171f;
    }

    /* Top Executive Header */
    .admin-exec-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.5rem 0 2.25rem;
        position: relative;
        overflow: hidden;
    }

    .admin-exec-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .admin-live-pulse {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 800;
        color: #34d399;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 10px #10b981;
        animation: pulse-glow 1.8s infinite;
    }

    @keyframes pulse-glow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.6; }
    }

    .admin-quick-pills {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .admin-pill-btn {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 0.6rem 1.1rem;
        border-radius: 0.75rem;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.25s ease;
        backdrop-filter: blur(10px);
    }

    .admin-pill-btn:hover {
        background: rgba(13, 148, 136, 0.25);
        border-color: #0d9488;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* 4-Column KPI Grid */
    .admin-kpi-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        padding: 1.6rem 1.4rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .admin-kpi-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .admin-kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: linear-gradient(90deg, #0d9488, #06b6d4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .admin-kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.12);
        border-color: #0d9488;
    }

    .admin-kpi-card:hover::before {
        opacity: 1;
    }

    .admin-kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .admin-kpi-val {
        font-size: 2rem;
        font-weight: 900;
        color: #0f172a;
        font-family: 'Outfit', sans-serif;
        line-height: 1.1;
        margin: 0.4rem 0 0.25rem;
        word-break: break-word;
    }

    body.dark-mode .admin-kpi-val {
        color: #ffffff;
    }

    /* Content Cards */
    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    body.dark-mode .admin-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .admin-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    body.dark-mode .admin-card-header {
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    .admin-card-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    body.dark-mode .admin-card-title {
        color: #ffffff;
    }

    /* Table Styles */
    .admin-table {
        margin: 0;
        width: 100%;
    }

    .admin-table th {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        padding: 0.85rem 1.25rem;
        border: none;
    }

    body.dark-mode .admin-table th {
        background: rgba(0, 0, 0, 0.2);
        color: #94a3b8;
    }

    .admin-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #334155;
    }

    body.dark-mode .admin-table td {
        border-top-color: rgba(255, 255, 255, 0.05);
        color: #cbd5e1;
    }

    .admin-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.03);
    }

    body.dark-mode .admin-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.08);
    }

    /* Verification Queue Item */
    .admin-queue-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        transition: background 0.2s ease;
    }

    body.dark-mode .admin-queue-item {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .admin-queue-item:hover {
        background: #f0fdfa;
    }

    body.dark-mode .admin-queue-item:hover {
        background: rgba(13, 148, 136, 0.1);
    }

    .admin-queue-item:last-child {
        border-bottom: none;
    }

    /* Audit Log Stream Item */
    .admin-audit-item {
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
    }

    body.dark-mode .admin-audit-item {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .admin-audit-item:last-child {
        border-bottom: none;
    }

    .admin-audit-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
        margin-top: 0.2rem;
    }
</style>
@endsection

@section('content')

<!-- Include Admin Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="admin-dashboard-container">
        
        <!-- 1. EXECUTIVE HEADER & ACTIONS -->
        <div class="admin-exec-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="admin-live-pulse">
                                <span class="pulse-dot"></span> Live Operations Sync
                            </div>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• E-Benta Version 2.0</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 900; letter-spacing: -0.5px; margin: 0;">
                            <i class="fas fa-shield-halved me-2" style="color: #10b981;"></i>Admin Control Center
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Environmental impact performance, user verifications, and marketplace oversight.
                        </p>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="admin-quick-pills">
                        <a href="{{ route('admin.pending-verifications') }}" class="admin-pill-btn">
                            <i class="fas fa-id-card" style="color: #38bdf8;"></i>
                            <span>ID Queue</span>
                            @if(($pendingVerificationsCount ?? 0) > 0)
                                <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem; font-weight: 800;">{{ $pendingVerificationsCount }}</span>
                            @else
                                <span class="badge bg-success rounded-pill" style="font-size: 0.7rem;">0</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="admin-pill-btn">
                            <i class="fas fa-flag" style="color: #f59e0b;"></i>
                            <span>Reports</span>
                            @if(($pendingReportsCount ?? 0) > 0)
                                <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.7rem; font-weight: 800;">{{ $pendingReportsCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.audit-logs.index') }}" class="admin-pill-btn">
                            <i class="fas fa-history" style="color: #a855f7;"></i>
                            <span>Audit Trail</span>
                        </a>
                        <a href="{{ route('admin.dashboard.export') }}" class="admin-pill-btn" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); border: none; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);">
                            <i class="fas fa-file-arrow-down"></i>
                            <span>Export Report</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. MAIN DASHBOARD CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- 4-COLUMN KPI CARDS ROW (NO CLIPPING / OVERLAPPING) -->
            <div class="row g-3 g-lg-4 mb-4">
                <!-- KPI 1: Total E-Waste Diverted -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">E-WASTE DIVERTED</small>
                                @php
                                    $divertedRaw = (float)($analytics['total_waste_diverted'] ?? 0);
                                    $displayWeight = $divertedRaw >= 1000 ? number_format($divertedRaw / 1000, 2) . ' Tons' : number_format($divertedRaw, 1) . ' kg';
                                @endphp
                                <div class="admin-kpi-val">{{ $displayWeight }}</div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                                <i class="fas fa-recycle"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700; color: #10b981;">
                            <i class="fas fa-arrow-trend-up"></i>
                            <span>Zero-Landfill Verified</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 2: CO2 Emissions Prevented -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">CARBON REDUCED</small>
                                @php
                                    $co2Raw = (float)($analytics['total_co2_saved'] ?? 0);
                                    $displayCo2 = $co2Raw >= 1000 ? number_format($co2Raw / 1000, 2) . ' t CO₂' : number_format($co2Raw, 0) . ' kg CO₂';
                                @endphp
                                <div class="admin-kpi-val">{{ $displayCo2 }}</div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700; color: #10b981;">
                            <i class="fas fa-check-circle"></i>
                            <span>Tracked via Impact Logs</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 3: User Network -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL MEMBERS</small>
                                <div class="admin-kpi-val">{{ number_format($totalUsers ?? 0) }}</div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                            <strong style="color: #0f172a;">{{ $analytics['active_buyers'] ?? 0 }}</strong> Recyclers • <strong style="color: #0f172a;">{{ $analytics['active_sellers'] ?? 0 }}</strong> Sellers
                        </div>
                    </div>
                </div>

                <!-- KPI 4: Platform Trades -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">PLATFORM TRADES</small>
                                <div class="admin-kpi-val">{{ number_format($totalOffers ?? 0) }}</div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                                <i class="fas fa-handshake"></i>
                            </div>
                        </div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                            <strong style="color: #10b981;">{{ $completedTransactionsCount ?? 0 }}</strong> Completed • <strong style="color: #0d9488;">{{ $activeListingsCount ?? 0 }}</strong> Active
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. ANALYTICS CHARTS ROW -->
            <div class="row g-4 mb-4">
                <!-- E-Waste & Carbon Trends Chart -->
                <div class="col-lg-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <div>
                                <h5 class="admin-card-title">
                                    <i class="fas fa-chart-line" style="color: #0d9488;"></i>
                                    E-Waste & Carbon Trend Analytics
                                </h5>
                                <small style="color: #64748b; font-size: 0.8rem;">Monthly collection and environmental carbon offset tracking</small>
                            </div>
                            <select id="wasteChartFilter" class="form-select form-select-sm" style="width: auto; font-weight: 700; border-radius: 0.6rem; border-color: rgba(13, 148, 136, 0.3);">
                                <option value="6">Last 6 Months</option>
                                <option value="12">Last 12 Months</option>
                                <option value="24">Last 2 Years</option>
                            </select>
                        </div>
                        <div class="p-3 p-md-4 flex-grow-1" style="min-height: 280px; position: relative;">
                            <canvas id="wasteCollectionChart" style="max-height: 280px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Material Recovery Doughnut Chart -->
                <div class="col-lg-4">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="admin-card-title">
                                <i class="fas fa-chart-pie" style="color: #06b6d4;"></i>
                                Material Recovery
                            </h5>
                            <span class="badge bg-light text-dark border" style="font-size: 0.75rem;">Recovered Elements</span>
                        </div>
                        <div class="p-3 p-md-4 d-flex flex-column align-items-center justify-content-center flex-grow-1" style="min-height: 280px; position: relative;">
                            <canvas id="materialsDistributionChart" style="max-height: 200px; width: 100%;"></canvas>
                            <div class="d-flex justify-content-center flex-wrap gap-2 mt-3" style="font-size: 0.78rem;">
                                <span class="badge bg-warning text-dark"><i class="fas fa-circle me-1" style="color: #eab308;"></i>Gold</span>
                                <span class="badge bg-danger text-white"><i class="fas fa-circle me-1" style="color: #f97316;"></i>Copper</span>
                                <span class="badge bg-secondary text-white"><i class="fas fa-circle me-1" style="color: #94a3b8;"></i>Aluminum</span>
                                <span class="badge bg-info text-dark"><i class="fas fa-circle me-1" style="color: #06b6d4;"></i>Plastics</span>
                                <span class="badge bg-primary text-white"><i class="fas fa-circle me-1" style="color: #a855f7;"></i>Rare Earth</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. OPERATIONS DUAL ROW (VERIFICATIONS & AUDIT STREAM) -->
            <div class="row g-4 mb-4">
                <!-- Left: Pending ID Verifications Queue -->
                <div class="col-lg-6">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="admin-card-title">
                                    <i class="fas fa-id-card-clip" style="color: #38bdf8;"></i>
                                    Pending ID & Recycler Verifications
                                </h5>
                                @if(($pendingVerificationsCount ?? 0) > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $pendingVerificationsCount }}</span>
                                @endif
                            </div>
                            <a href="{{ route('admin.pending-verifications') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.5rem; font-weight: 700; font-size: 0.8rem;">
                                View All
                            </a>
                        </div>
                        <div class="p-0 flex-grow-1" style="max-height: 360px; overflow-y: auto;">
                            @forelse($pendingVerifications as $user)
                                <div class="admin-queue-item">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #0d9488, #06b6d4); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $user->name }}</strong>
                                            <small style="color: #64748b; font-size: 0.8rem;">{{ $user->email }}</small>
                                            <div class="mt-1">
                                                <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-size: 0.72rem; font-weight: 700;">
                                                    {{ $user->id_type ?? 'Government ID' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.verify-user', $user) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" style="font-weight: 800; border-radius: 0.5rem; font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                                <i class="fas fa-check me-1"></i>Approve
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.pending-verifications') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.5rem; font-size: 0.8rem;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 3rem 1.5rem; color: #64748b;">
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 0.75rem;">
                                        <i class="fas fa-circle-check"></i>
                                    </div>
                                    <h6 style="font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">All Clear!</h6>
                                    <p style="margin: 0; font-size: 0.85rem;">No pending ID submissions requiring administrator review.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Real-Time System Audit Trail -->
                <div class="col-lg-6">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="admin-card-title">
                                <i class="fas fa-clock-rotate-left" style="color: #a855f7;"></i>
                                Real-Time Security & Audit Feed
                            </h5>
                            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.5rem; font-weight: 700; font-size: 0.8rem;">
                                Full Log
                            </a>
                        </div>
                        <div class="p-0 flex-grow-1" style="max-height: 360px; overflow-y: auto;">
                            @forelse($recentAuditLogs as $log)
                                <div class="admin-audit-item">
                                    <div class="admin-audit-icon">
                                        <i class="fas fa-shield"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                            <strong style="color: #0f172a; font-size: 0.88rem; text-transform: capitalize;">
                                                {{ str_replace('_', ' ', $log->action) }}
                                            </strong>
                                            <small style="color: #94a3b8; font-size: 0.75rem; white-space: nowrap;">
                                                {{ $log->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <p style="color: #475569; font-size: 0.82rem; margin: 0.2rem 0 0; line-height: 1.5;">
                                            {{ Str::limit($log->description, 75) }}
                                        </p>
                                        <small style="color: #64748b; font-size: 0.75rem;">
                                            by <strong>{{ $log->user?->name ?? 'System' }}</strong>
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 3rem 1.5rem; color: #64748b;">
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f8fafc; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 0.75rem;">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h6 style="font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">No Recent Events</h6>
                                    <p style="margin: 0; font-size: 0.85rem;">System audit events will appear here automatically.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. RECENT TRANSACTIONS DATA TABLE -->
            <div class="row">
                <div class="col-12">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <div>
                                <h5 class="admin-card-title">
                                    <i class="fas fa-receipt" style="color: #10b981;"></i>
                                    Recent Platform Transactions & Certified Disposals
                                </h5>
                                <small style="color: #64748b; font-size: 0.8rem;">Real-time stream of completed trades and verified e-waste collection</small>
                            </div>
                            <a href="{{ route('admin.impact-logs') }}" class="btn btn-sm btn-outline-dark" style="border-radius: 0.5rem; font-weight: 700; font-size: 0.8rem;">
                                View All Impact Logs
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>Device / Item</th>
                                        <th>Seller</th>
                                        <th>Verified Buyer / Recycler</th>
                                        <th>CO₂ Prevented</th>
                                        <th>Diverted Weight</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                                        <i class="fas fa-microchip"></i>
                                                    </div>
                                                    <strong>{{ $transaction->device_category ?: 'Electronics' }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $transaction->seller?->name ?? 'N/A' }}</td>
                                            <td>{{ $transaction->buyer?->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-success" style="font-size: 0.8rem; font-weight: 800;">
                                                    <i class="fas fa-leaf me-1"></i>{{ $transaction->co2_saved ?? 0 }} kg
                                                </span>
                                            </td>
                                            <td>{{ $transaction->landfill_diverted_weight ?? 0 }} kg</td>
                                            <td>
                                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                                    <i class="fas fa-circle-check me-1"></i>Completed
                                                </span>
                                            </td>
                                            <td style="color: #64748b; font-size: 0.85rem;">
                                                {{ $transaction->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 3rem 1.5rem;">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                <span>No completed transactions logged yet.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initWasteTrendChart();
        initMaterialDoughnutChart();
    });

    let wasteChart = null;

    function initWasteTrendChart() {
        const ctx = document.getElementById('wasteCollectionChart');
        if (!ctx) return;

        const months = ['Mar 2026', 'Apr 2026', 'May 2026', 'Jun 2026', 'Jul 2026', 'Aug 2026'];
        const dataValues = [450, 720, 980, 1400, 1850, 2450];

        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(13, 148, 136, 0.35)');
        gradient.addColorStop(1, 'rgba(13, 148, 136, 0.0)');

        wasteChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'E-Waste Diverted (kg)',
                    data: dataValues,
                    borderColor: '#0d9488',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0d9488',
                    pointBorderWidth: 2.5,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#5eead4',
                        padding: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: { color: '#64748b', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 11 } }
                    }
                }
            }
        });

        document.getElementById('wasteChartFilter')?.addEventListener('change', function(e) {
            const count = parseInt(e.target.value);
            if (count === 12) {
                wasteChart.data.labels = ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
                wasteChart.data.datasets[0].data = [200, 280, 350, 420, 560, 680, 850, 1100, 1450, 1800, 2100, 2450];
            } else {
                wasteChart.data.labels = months;
                wasteChart.data.datasets[0].data = dataValues;
            }
            wasteChart.update();
        });
    }

    function initMaterialDoughnutChart() {
        const ctx = document.getElementById('materialsDistributionChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Gold (g)', 'Copper (kg)', 'Aluminum (kg)', 'Plastics (kg)', 'Rare Earth (g)'],
                datasets: [{
                    data: [15, 45, 30, 60, 20],
                    backgroundColor: ['#eab308', '#f97316', '#94a3b8', '#06b6d4', '#a855f7'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        padding: 10
                    }
                },
                cutout: '72%'
            }
        });
    }
</script>
@endsection
