@extends('layouts.app')

@section('title', 'Admin Dashboard - E-Benta')

@section('content')
<style>
    /* === DASHBOARD WRAPPER === */
    .admin-dashboard {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === DASHBOARD HEADER === */
    .dashboard-header {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
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

    .dashboard-header::after {
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

    .dashboard-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .dashboard-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.3rem 0;
        letter-spacing: -0.5px;
    }

    .dashboard-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    .btn-export {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.9rem 1.8rem;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .btn-export:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    /* === METRICS SECTION === */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .metric-card {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(13, 148, 136, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d9488, #06b6d4);
    }

    .metric-card:hover {
        box-shadow: 0 8px 24px rgba(13, 148, 136, 0.12);
        transform: translateY(-4px);
    }

    .metric-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.8rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #0d9488;
        margin-bottom: 1rem;
    }

    .metric-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-size: 2.2rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 0.6rem;
    }

    .metric-value small {
        font-size: 0.5em;
        color: #94a3b8;
        margin-left: 0.3rem;
    }

    .metric-change {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0d9488;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* === CHARTS SECTION === */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .chart-card {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(13, 148, 136, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(13, 148, 136, 0.1);
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin: 0;
    }

    .chart-title i {
        color: #0d9488;
        background: rgba(13, 148, 136, 0.12);
        padding: 0.6rem 0.8rem;
        border-radius: 0.6rem;
        font-size: 1.2rem;
    }

    .chart-subtitle {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0.3rem 0 0 0;
    }

    .chart-filter {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08), rgba(13, 148, 136, 0.04));
        color: #1e293b;
        border: 1px solid rgba(13, 148, 136, 0.2);
        padding: 0.6rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.85rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .chart-filter:hover {
        border-color: #0d9488;
        background: rgba(13, 148, 136, 0.12);
    }

    .chart-container {
        height: 280px;
        position: relative;
    }

    /* === CONTENT SECTION === */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .content-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(13, 148, 136, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .content-header {
        padding: 1.8rem;
        border-bottom: 2px solid rgba(13, 148, 136, 0.1);
    }

    .content-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin: 0;
    }

    .content-title i {
        color: #0d9488;
        background: rgba(13, 148, 136, 0.12);
        padding: 0.6rem 0.8rem;
        border-radius: 0.6rem;
        font-size: 1.2rem;
    }

    .content-body {
        padding: 1.8rem;
        flex: 1;
        overflow-y: auto;
        max-height: 350px;
    }

    .item-row {
        padding: 1rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.04) 0%, rgba(6, 182, 212, 0.02) 100%);
        border-radius: 0.8rem;
        margin-bottom: 0.8rem;
        border-left: 3px solid #0d9488;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .item-row:last-child {
        margin-bottom: 0;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        color: #1e293b;
        font-weight: 600;
        margin: 0 0 0.3rem 0;
        font-size: 0.95rem;
    }

    .item-meta {
        color: #94a3b8;
        font-size: 0.8rem;
        margin: 0;
    }

    .item-badge {
        display: inline-block;
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        padding: 0.4rem 0.8rem;
        border-radius: 0.4rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-top: 0.5rem;
    }

    .item-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 0.6rem;
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        border: 1px solid rgba(13, 148, 136, 0.2);
        margin-left: 1rem;
        flex-shrink: 0;
    }

    .item-action:hover {
        background: #0d9488;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: rgba(13, 148, 136, 0.08);
        position: sticky;
        top: 0;
    }

    .table thead th {
        color: #0d9488;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 2px solid rgba(13, 148, 136, 0.15);
    }

    .table tbody tr {
        border-bottom: 1px solid rgba(13, 148, 136, 0.08);
        transition: background 0.2s ease;
    }

    .table tbody tr:hover {
        background: rgba(13, 148, 136, 0.04);
    }

    .table td {
        padding: 1rem;
        color: #1e293b;
        font-size: 0.85rem;
    }

    .view-all {
        display: block;
        text-align: center;
        color: #0d9488;
        text-decoration: none;
        font-weight: 700;
        padding: 1rem 1.8rem;
        border-top: 2px solid rgba(13, 148, 136, 0.1);
        transition: all 0.2s ease;
    }

    .view-all:hover {
        background: rgba(13, 148, 136, 0.04);
        color: #0891b2;
    }

    /* === DARK MODE === */
    body.dark-mode .admin-dashboard {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .metric-card,
    body.dark-mode .chart-card,
    body.dark-mode .content-card {
        background: #2a2a2a;
        border-color: rgba(6, 182, 212, 0.2);
    }

    body.dark-mode .metric-card:hover,
    body.dark-mode .chart-card:hover,
    body.dark-mode .content-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    body.dark-mode .metric-value,
    body.dark-mode .chart-title,
    body.dark-mode .content-title,
    body.dark-mode .item-name,
    body.dark-mode .table td {
        color: #e0e0e0;
    }

    body.dark-mode .chart-filter {
        background: rgba(13, 148, 136, 0.1);
        color: #e0e0e0;
        border-color: rgba(13, 148, 136, 0.3);
    }

    body.dark-mode .item-row {
        background: rgba(13, 148, 136, 0.08);
    }

    body.dark-mode .table thead {
        background: rgba(13, 148, 136, 0.1);
    }

    body.dark-mode .table tbody tr:hover {
        background: rgba(13, 148, 136, 0.08);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .dashboard-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .metrics-grid,
        .charts-grid,
        .content-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
        }

        .chart-container {
            height: 250px;
        }

        .item-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .item-action {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="container-fluid">
                <div class="dashboard-header-content">
                    <div>
                        <h1><i class="fas fa-chart-line me-2"></i>Impact Dashboard</h1>
                        <p>Environmental performance & system metrics overview</p>
                    </div>
                    <a href="{{ route('admin.dashboard.export') }}" class="btn-export">
                        <i class="fas fa-download"></i>Export Report
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">
            <!-- Metrics Grid -->
            <div class="metrics-grid">
                <!-- Total E-waste -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-dumpster"></i></div>
                    <div class="metric-label"><i class="fas fa-trash me-1"></i>Total E-waste Collected</div>
                    <div class="metric-value">{{ number_format((($analytics['total_waste_diverted'] ?? 0) / 1000), 1) }}<small>Tons</small></div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+12.4% this month</div>
                </div>

                <!-- Carbon Saved -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-leaf"></i></div>
                    <div class="metric-label"><i class="fas fa-wind me-1"></i>Carbon Emissions Reduced</div>
                    <div class="metric-value">{{ number_format((($analytics['total_co2_saved'] ?? 0) / 1000), 0) }}<small>k kg CO₂e</small></div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+8.2% this month</div>
                </div>

                <!-- Materials Recovered -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-recycle"></i></div>
                    <div class="metric-label"><i class="fas fa-recycle me-1"></i>Materials Recovered</div>
                    <div class="metric-value">{{ number_format((($analytics['total_waste_diverted'] ?? 0) / 1000), 0) }}<small>k kg</small></div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+15.7% this month</div>
                </div>

                <!-- Active Users -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-users"></i></div>
                    <div class="metric-label"><i class="fas fa-users me-1"></i>Active Users</div>
                    <div class="metric-value">{{ number_format($totalUsers) }}</div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+5.1% this month</div>
                </div>

                <!-- Total Offers -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-handshake"></i></div>
                    <div class="metric-label"><i class="fas fa-handshake me-1"></i>Total Offers</div>
                    <div class="metric-value">{{ number_format($totalOffers) }}</div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+3.8% this month</div>
                </div>

                <!-- Verified Recyclers -->
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="metric-label"><i class="fas fa-check me-1"></i>Verified Partners</div>
                    <div class="metric-value">{{ $analytics['active_buyers'] ?? 0 }}</div>
                    <div class="metric-change"><i class="fas fa-arrow-up"></i>+2.3% this month</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <!-- E-waste Trends -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h5 class="chart-title"><i class="fas fa-chart-line"></i>E-waste Collection Trends</h5>
                            <p class="chart-subtitle">Monthly collection & performance data</p>
                        </div>
                        <select id="wasteChartFilter" class="chart-filter">
                            <option value="6">Last 6 Months</option>
                            <option value="12">Last 12 Months</option>
                            <option value="24">Last 2 Years</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="wasteCollectionChart"></canvas>
                    </div>
                </div>

                <!-- Materials Distribution -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h5 class="chart-title"><i class="fas fa-chart-pie"></i>Materials Distribution</h5>
                            <p class="chart-subtitle">Breakdown by material type</p>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="materialsDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content-grid">
                <!-- Pending Approvals -->
                <div class="content-card">
                    <div class="content-header">
                        <h5 class="content-title"><i class="fas fa-clock"></i>Pending Verifications</h5>
                    </div>
                    <div class="content-body">
                        @forelse($pendingVerifications->take(5) as $user)
                            <div class="item-row">
                                <div class="item-info">
                                    <p class="item-name">{{ $user->name }}</p>
                                    <p class="item-meta">{{ $user->email }}</p>
                                    <span class="item-badge">Awaiting Review</span>
                                </div>
                                <a href="{{ route('admin.pending-verifications') }}" class="item-action">
                                    <i class="fas fa-arrow-right" style="font-size: 0.9rem;"></i>
                                </a>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 2rem; color: #64748b;">
                                <i class="fas fa-check-circle" style="font-size: 2rem; color: #22c55e; display: block; margin-bottom: 0.5rem;"></i>
                                <p style="margin: 0;">All recyclers verified!</p>
                            </div>
                        @endforelse
                    </div>
                    @if(count($pendingVerifications) > 5)
                        <a href="{{ route('admin.pending-verifications') }}" class="view-all">
                            View All ({{ count($pendingVerifications) }}) <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @endif
                </div>

                <!-- Recent Transactions -->
                <div class="content-card">
                    <div class="content-header">
                        <h5 class="content-title"><i class="fas fa-exchange-alt"></i>Recent Transactions</h5>
                    </div>
                    <div style="flex: 1; padding: 0;">
                        <div class="table-responsive" style="height: 100%; max-height: 350px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Seller</th>
                                        <th>Buyer</th>
                                        <th>CO₂ Saved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions->take(8) as $transaction)
                                        <tr>
                                            <td><strong>{{ $transaction->device_category }}</strong></td>
                                            <td>{{ Str::limit($transaction->seller?->name ?? 'N/A', 12) }}</td>
                                            <td>{{ Str::limit($transaction->buyer?->name ?? 'N/A', 12) }}</td>
                                            <td><strong style="color: #0d9488;">{{ $transaction->co2_saved }} <small>kg</small></strong></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 2rem;">
                                                <i class="fas fa-inbox me-2"></i>No transactions yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.listings') }}" class="view-all">
                        View All Transactions <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const analyticsData = @json($analytics);
    let wasteChartInstance = null;
    let materialsChartInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        initializeWasteChart();
        initializeMaterialsChart();
        
        document.getElementById('wasteChartFilter').addEventListener('change', function() {
            updateWasteChart(this.value);
        });
    });

    function initializeWasteChart() {
        const ctx = document.getElementById('wasteCollectionChart');
        if (!ctx) return;

        const months = getLastNMonths(6);
        const data = generateWasteData(6);

        wasteChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'E-waste Collected (kg)',
                    data: data,
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0d9488',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#06b6d4',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#1e293b',
                            font: { weight: '600', size: 12 },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#0d9488',
                        borderWidth: 1,
                        padding: 12,
                        titleFont: { weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' kg';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#64748b', font: { size: 11 } },
                        grid: { color: 'rgba(13, 148, 136, 0.08)' }
                    },
                    x: {
                        ticks: { color: '#64748b', font: { size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    function updateWasteChart(months) {
        const newMonths = getLastNMonths(parseInt(months));
        const newData = generateWasteData(parseInt(months));

        if (wasteChartInstance) {
            wasteChartInstance.data.labels = newMonths;
            wasteChartInstance.data.datasets[0].data = newData;
            wasteChartInstance.update();
        }
    }

    function initializeMaterialsChart() {
        const ctx = document.getElementById('materialsDistributionChart');
        if (!ctx) return;

        const materials = ['Electronics', 'Metals', 'Plastics', 'Glass', 'Other'];
        const distribution = [
            Math.floor(analyticsData.total_waste_diverted * 0.25),
            Math.floor(analyticsData.total_waste_diverted * 0.20),
            Math.floor(analyticsData.total_waste_diverted * 0.25),
            Math.floor(analyticsData.total_waste_diverted * 0.20),
            Math.floor(analyticsData.total_waste_diverted * 0.10)
        ];

        materialsChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: materials,
                datasets: [{
                    label: 'Material Distribution (kg)',
                    data: distribution,
                    backgroundColor: [
                        '#0d9488',
                        '#06b6d4',
                        '#0891b2',
                        '#0e7490',
                        '#164e63'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverBorderColor: '#1e293b',
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#1e293b',
                            font: { weight: '600', size: 11 },
                            padding: 12,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#0d9488',
                        borderWidth: 1,
                        padding: 12,
                        titleFont: { weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value.toLocaleString() + ' kg (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    function getLastNMonths(n) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const result = [];
        const now = new Date();

        for (let i = n - 1; i >= 0; i--) {
            const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            result.push(month + ' ' + year.toString().slice(-2));
        }

        return result;
    }

    function generateWasteData(months) {
        const baseValue = analyticsData.total_waste_diverted / months;
        const data = [];

        for (let i = 0; i < months; i++) {
            const variation = baseValue * (0.7 + Math.random() * 0.6);
            data.push(Math.floor(variation));
        }

        return data;
    }

    document.addEventListener('sidebarToggle', function() {
        setTimeout(() => {
            if (wasteChartInstance) wasteChartInstance.resize();
            if (materialsChartInstance) materialsChartInstance.resize();
        }, 200);
    });
</script>

@endsection
