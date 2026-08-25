@extends('layouts.app')

@section('title', 'Generate Reports - E-Benta Admin')

@section('content')
<style>
    /* === REPORTS WRAPPER === */
    .reports-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .reports-header {
        background: linear-gradient(135deg, #09a0db 0%, #0284c7 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .reports-header::before {
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

    .reports-header::after {
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

    .reports-header-content {
        position: relative;
        z-index: 1;
    }

    .reports-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .reports-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === FILTER SECTION === */
    .filter-card-reports {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(2, 132, 199, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-wrapper-reports {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group-reports {
        flex: 1;
        min-width: 250px;
    }

    .filter-label-reports {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .filter-label-reports i {
        color: #0284c7;
    }

    .filter-select-reports {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(2, 132, 199, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.95rem;
    }

    .filter-select-reports:focus {
        border-color: rgba(2, 132, 199, 0.5);
        box-shadow: 0 0 15px rgba(2, 132, 199, 0.15);
        background: white;
        outline: none;
    }

    .filter-btn-reports {
        background: linear-gradient(135deg, #09a0db 0%, #0284c7 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
        cursor: pointer;
        white-space: nowrap;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-btn-reports:hover {
        box-shadow: 0 6px 20px rgba(2, 132, 199, 0.35);
        transform: translateY(-2px);
    }

    /* === PERIOD DISPLAY === */
    .period-display {
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.1) 0%, rgba(2, 132, 199, 0.05) 100%);
        border-left: 4px solid #0284c7;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(2, 132, 199, 0.1);
    }

    .period-display h4 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 1rem;
    }

    .period-display h4 span {
        color: #0284c7;
        font-weight: 800;
    }

    /* === METRIC CARD === */
    .metric-card {
        background: white;
        border-radius: 1.2rem;
        padding: 1.75rem;
        border: 1px solid rgba(2, 132, 199, 0.08);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        border-top-width: 4px;
    }

    .metric-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }

    /* Color variations */
    .metric-card-teal {
        border-top-color: #0d9488;
    }

    .metric-card-cyan {
        border-top-color: #06b6d4;
    }

    .metric-card-blue {
        border-top-color: #3b82f6;
    }

    .metric-card-purple {
        border-top-color: #a855f7;
    }

    .metric-card-green {
        border-top-color: #22c55e;
    }

    .metric-card-orange {
        border-top-color: #f97316;
    }

    .metric-card-sky {
        border-top-color: #0ea5e9;
    }

    .metric-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .metric-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .metric-icon-teal {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.08) 100%);
        color: #0d9488;
    }

    .metric-icon-cyan {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
        color: #06b6d4;
    }

    .metric-icon-blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .metric-icon-purple {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(168, 85, 247, 0.08) 100%);
        color: #a855f7;
    }

    .metric-icon-green {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%);
        color: #22c55e;
    }

    .metric-icon-orange {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(249, 115, 22, 0.08) 100%);
        color: #f97316;
    }

    .metric-icon-sky {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.08) 100%);
        color: #0ea5e9;
    }

    .metric-label {
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 900;
        margin: 0.75rem 0 0.5rem 0;
    }

    .metric-description {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
        font-weight: 500;
    }

    /* === SUMMARY SECTION === */
    .summary-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(2, 132, 199, 0.1);
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        margin-bottom: 2rem;
    }

    .summary-card h5 {
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .summary-card h5 i {
        color: #0284c7;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .summary-item-label {
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .summary-item-text {
        color: #1e293b;
        margin: 0;
        font-weight: 600;
        line-height: 1.5;
    }

    /* === DARK MODE === */
    body.dark-mode .reports-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .filter-card-reports,
    body.dark-mode .metric-card,
    body.dark-mode .summary-card,
    body.dark-mode .period-display {
        background: #2a2a2a;
        border-color: rgba(2, 132, 199, 0.2);
    }

    body.dark-mode .filter-label-reports,
    body.dark-mode .metric-label,
    body.dark-mode .period-display h4,
    body.dark-mode .summary-card h5,
    body.dark-mode .metric-description {
        color: #e0e0e0;
    }

    body.dark-mode .metric-value {
        color: inherit;
    }

    body.dark-mode .filter-select-reports {
        background: #333333;
        border-color: rgba(2, 132, 199, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-reports:focus {
        background: #3a3a3a;
    }

    body.dark-mode .summary-item-text {
        color: #e0e0e0;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .reports-header h1 {
            font-size: 1.8rem;
        }

        .filter-wrapper-reports {
            flex-direction: column;
        }

        .filter-group-reports,
        .filter-btn-reports {
            width: 100%;
        }

        .metric-value {
            font-size: 1.5rem;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="reports-wrapper">
        <!-- Header -->
        <div class="reports-header">
            <div class="container-fluid">
                <div class="reports-header-content">
                    <h1><i class="fas fa-chart-bar me-2"></i>Generate Reports</h1>
                    <p>View system analytics and performance metrics</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">
            <!-- Filter Section -->
            <div class="filter-card-reports">
                <form method="GET" action="{{ route('admin.generate-reports') }}" class="filter-wrapper-reports">
                    <div class="filter-group-reports">
                        <label class="filter-label-reports">
                            <i class="fas fa-calendar"></i>Report Period
                        </label>
                        <select name="type" class="filter-select-reports">
                            <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Monthly Report</option>
                            <option value="quarterly" {{ $reportType == 'quarterly' ? 'selected' : '' }}>Quarterly Report</option>
                            <option value="yearly" {{ $reportType == 'yearly' ? 'selected' : '' }}>Yearly Report</option>
                        </select>
                    </div>
                    <button type="submit" class="filter-btn-reports">
                        <i class="fas fa-sync-alt"></i>Generate
                    </button>
                </form>
            </div>

            <!-- Period Display -->
            <div class="period-display">
                <h4>
                    <i class="fas fa-hourglass me-2"></i>Report Period: <span>{{ $data['period'] }}</span>
                </h4>
            </div>

            <!-- Metrics Grid -->
            <div class="row">
                <!-- Total Items -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-teal">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-teal">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div>
                                <p class="metric-label">Total Items</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #0d9488;">{{ $data['total_items'] }}</h3>
                        <p class="metric-description">Listings created</p>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-cyan">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-cyan">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <p class="metric-label">Total Transactions</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #06b6d4;">{{ $data['total_transactions'] }}</h3>
                        <p class="metric-description">Completed transactions</p>
                    </div>
                </div>

                <!-- Total CO2 Saved -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-blue">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-blue">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div>
                                <p class="metric-label">CO₂ Saved</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #3b82f6;">{{ number_format($data['total_co2_saved'], 0) }}</h3>
                        <p class="metric-description">kg CO₂ prevented</p>
                    </div>
                </div>

                <!-- Total Waste Diverted -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-purple">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-purple">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div>
                                <p class="metric-label">Waste Diverted</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #a855f7;">{{ number_format($data['total_waste_diverted'], 0) }}</h3>
                        <p class="metric-description">kg diverted from landfills</p>
                    </div>
                </div>
            </div>

            <!-- User Metrics Row -->
            <div class="row mt-4">
                <!-- New Sellers -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-green">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-green">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <p class="metric-label">New Sellers</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #22c55e;">{{ $data['new_sellers'] }}</h3>
                        <p class="metric-description">New sellers joined</p>
                    </div>
                </div>

                <!-- New Buyers -->
                <div class="col-lg-3 col-md-6">
                    <div class="metric-card metric-card-orange">
                        <div class="metric-header">
                            <div class="metric-icon-box metric-icon-orange">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div>
                                <p class="metric-label">New Buyers</p>
                            </div>
                        </div>
                        <h3 class="metric-value" style="color: #f97316;">{{ $data['new_buyers'] }}</h3>
                        <p class="metric-description">New buyers joined</p>
                    </div>
                </div>

                <!-- Verified Buyers (Only for Monthly) -->
                @if(isset($data['verified_buyers']))
                    <div class="col-lg-3 col-md-6">
                        <div class="metric-card metric-card-sky">
                            <div class="metric-header">
                                <div class="metric-icon-box metric-icon-sky">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <p class="metric-label">Verified Buyers</p>
                                </div>
                            </div>
                            <h3 class="metric-value" style="color: #0ea5e9;">{{ $data['verified_buyers'] }}</h3>
                            <p class="metric-description">Total verified buyers</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Summary Section -->
            <div class="summary-card">
                <h5><i class="fas fa-info-circle"></i>Report Summary</h5>
                <div class="summary-grid">
                    <div>
                        <span class="summary-item-label">Platform Activity</span>
                        <p class="summary-item-text">
                            This period saw <strong style="color: #06b6d4;">{{ $data['total_transactions'] }}</strong> completed transactions with <strong style="color: #0d9488;">{{ $data['total_items'] }}</strong> active listings.
                        </p>
                    </div>
                    <div>
                        <span class="summary-item-label">Environmental Impact</span>
                        <p class="summary-item-text">
                            A total of <strong style="color: #3b82f6;">{{ number_format($data['total_co2_saved'], 0) }} kg CO₂</strong> was saved and <strong style="color: #a855f7;">{{ number_format($data['total_waste_diverted'], 0) }} kg</strong> of waste diverted from landfills.
                        </p>
                    </div>
                    <div>
                        <span class="summary-item-label">User Growth</span>
                        <p class="summary-item-text">
                            <strong style="color: #22c55e;">{{ $data['new_sellers'] }}</strong> new sellers and <strong style="color: #f97316;">{{ $data['new_buyers'] }}</strong> new buyers joined the platform.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
