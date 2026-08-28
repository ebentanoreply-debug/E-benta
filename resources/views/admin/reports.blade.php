@extends('layouts.app')

@section('title', 'Generate Analytics Reports - E-Benta Admin')

@section('styles')
<style>
    .admin-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .admin-page-container {
        background: #09171f;
    }

    .admin-module-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    body.dark-mode .admin-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }
</style>
@endsection

@section('content')

@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="admin-page-container">
        
        <!-- HEADER -->
        <div class="admin-module-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(6, 182, 212, 0.2); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-file-export me-1"></i>Executive Analytics Reports
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• Period: {{ $data['period'] }}</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Generate System & ESG Reports
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Generate periodic compliance summaries, carbon accounting data, and platform growth metrics.
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.dashboard.export') }}" class="btn btn-emerald d-inline-flex align-items-center gap-2 font-weight-bold" style="background: #10b981; color: white; border-radius: 0.75rem; padding: 0.55rem 1rem;">
                            <i class="fas fa-file-csv"></i>
                            <span>Export CSV Data</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.2);">
                            <i class="fas fa-arrow-left"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- PERIOD SELECTOR -->
            <div class="admin-card mb-4 p-3 p-md-4">
                <form method="GET" action="{{ route('admin.generate-reports') }}" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Reporting Timeframe</label>
                        <select name="type" class="form-select" style="border-radius: 0.65rem; font-weight: 600;">
                            <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Monthly Report (Current Month)</option>
                            <option value="quarterly" {{ $reportType == 'quarterly' ? 'selected' : '' }}>Quarterly Report (Current Quarter)</option>
                            <option value="yearly" {{ $reportType == 'yearly' ? 'selected' : '' }}>Yearly ESG Audit (Current Year)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-dark w-100 font-weight-bold" style="border-radius: 0.65rem; padding: 0.6rem;">
                            <i class="fas fa-arrows-rotate me-1"></i>Recompute Metrics
                        </button>
                    </div>
                </form>
            </div>

            <!-- METRIC CARDS ROW 1: TRANSACTIONS & ENVIRONMENT -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="p-4 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">LISTINGS CREATED</small>
                            <h3 class="m-0 font-weight-bold" style="font-family: 'Outfit', sans-serif; color: #0f172a;">{{ $data['total_items'] }}</h3>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-4 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">TRADES COMPLETED</small>
                            <h3 class="m-0 font-weight-bold text-info" style="font-family: 'Outfit', sans-serif;">{{ $data['total_transactions'] }}</h3>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(6, 182, 212, 0.1); color: #06b6d4; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-4 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">NET CO₂ PREVENTED</small>
                            <h3 class="m-0 font-weight-bold text-success" style="font-family: 'Outfit', sans-serif;">{{ number_format($data['total_co2_saved'], 0) }} kg</h3>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-4 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">LANDFILL DIVERTED</small>
                            <h3 class="m-0 font-weight-bold" style="font-family: 'Outfit', sans-serif; color: #8b5cf6;">{{ number_format($data['total_waste_diverted'], 0) }} kg</h3>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fas fa-recycle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- METRIC CARDS ROW 2: USER ONBOARDING -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">NEW SELLERS ONBOARDED</small>
                            <h4 class="m-0 font-weight-bold" style="color: #10b981;">+{{ $data['new_sellers'] }}</h4>
                        </div>
                        <i class="fas fa-user-plus text-success fa-lg"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">NEW BUYERS REGISTERED</small>
                            <h4 class="m-0 font-weight-bold" style="color: #0284c7;">+{{ $data['new_buyers'] }}</h4>
                        </div>
                        <i class="fas fa-users text-primary fa-lg"></i>
                    </div>
                </div>
                @if(isset($data['verified_buyers']))
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">VERIFIED BUYERS & RECYCLERS</small>
                                <h4 class="m-0 font-weight-bold" style="color: #0d9488;">{{ $data['verified_buyers'] }}</h4>
                            </div>
                            <i class="fas fa-certificate text-teal fa-lg"></i>
                        </div>
                    </div>
                @endif
            </div>

            <!-- EXECUTIVE ESG SUMMARY CARD -->
            <div class="admin-card p-4">
                <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 1.25rem; font-family: 'Outfit', sans-serif;">
                    <i class="fas fa-file-lines text-emerald me-2"></i>Executive Summary Statement
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #06b6d4;">
                            <strong style="color: #0f172a; display: block; font-size: 0.9rem;">Marketplace Velocity</strong>
                            <p style="font-size: 0.88rem; color: #475569; margin: 0.25rem 0 0;">
                                During <strong>{{ $data['period'] }}</strong>, the platform recorded <strong>{{ $data['total_transactions'] }}</strong> transactions across <strong>{{ $data['total_items'] }}</strong> listed items.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #10b981;">
                            <strong style="color: #0f172a; display: block; font-size: 0.9rem;">Carbon & Landfill Divergence</strong>
                            <p style="font-size: 0.88rem; color: #475569; margin: 0.25rem 0 0;">
                                Net carbon avoidance reached <strong>{{ number_format($data['total_co2_saved'], 0) }} kg CO₂</strong>, with <strong>{{ number_format($data['total_waste_diverted'], 0) }} kg</strong> successfully diverted from disposal.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #8b5cf6;">
                            <strong style="color: #0f172a; display: block; font-size: 0.9rem;">Community Expansion</strong>
                            <p style="font-size: 0.88rem; color: #475569; margin: 0.25rem 0 0;">
                                Userbase expanded with <strong>{{ $data['new_sellers'] }}</strong> new sellers and <strong>{{ $data['new_buyers'] }}</strong> verified scrap buyers joining the network.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
