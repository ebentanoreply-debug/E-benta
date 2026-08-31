@extends('layouts.app')

@section('title', 'Sales Analytics - E-Benta')

@section('styles')
<style>
    /* ==========================================================================
       OBSIDIAN SALES ANALYTICS DESIGN SYSTEM
       ========================================================================== */
    .sa-wrapper {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding-bottom: 4rem;
    }

    body.dark-mode .sa-wrapper {
        background-color: #09171f;
    }

    /* Executive Obsidian Header */
    .sa-hero-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .sa-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 420px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .sa-live-pulse {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.78rem;
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
        animation: pulseAnimation 2s infinite;
    }

    @keyframes pulseAnimation {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.6; }
    }

    /* Modern KPI Cards */
    .sa-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .sa-stat-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.18);
        border-radius: 1.1rem;
        padding: 1.25rem 1.35rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    body.dark-mode .sa-stat-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .sa-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.4);
    }

    .sa-stat-label {
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 800;
        margin: 0 0 0.35rem;
    }

    .sa-stat-value {
        color: #0f172a;
        font-size: 1.75rem;
        font-weight: 900;
        margin: 0;
        font-family: 'Outfit', sans-serif;
        letter-spacing: -0.5px;
    }

    body.dark-mode .sa-stat-value {
        color: #ffffff;
    }

    .sa-money {
        color: #10b981 !important;
    }

    .sa-stat-sub {
        margin-top: 0.35rem;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Analytics Chart Panels */
    .sa-panels {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .sa-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.18);
        border-radius: 1.15rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    body.dark-mode .sa-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .sa-card-header {
        padding: 1.15rem 1.4rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    body.dark-mode .sa-card-header {
        background: #0d1e27;
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .sa-card-header h5 {
        margin: 0;
        color: #0f172a;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: -0.2px;
    }

    body.dark-mode .sa-card-header h5 {
        color: #ffffff;
    }

    .sa-card-body {
        padding: 1.25rem 1.4rem;
    }

    .sa-chart-wrap {
        position: relative;
        height: 300px;
    }

    .sa-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #64748b;
        font-size: 0.9rem;
        min-height: 220px;
        border: 1px dashed rgba(13, 148, 136, 0.25);
        border-radius: 0.85rem;
        background: rgba(13, 148, 136, 0.03);
    }

    /* Tables */
    .sa-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .sa-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.95rem 1.25rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
    }

    body.dark-mode .sa-table thead th {
        background: #08141b;
        color: #94a3b8;
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .sa-table td {
        padding: 0.95rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
        vertical-align: middle;
        color: #334155;
    }

    body.dark-mode .sa-table td {
        border-bottom-color: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }

    .sa-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.03);
    }

    body.dark-mode .sa-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.08);
    }

    @media (max-width: 991.98px) {
        .sa-panels {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

@include('seller.sidebar')

<div class="main-content-wrapper">
    <div class="sa-wrapper">
        
        <!-- 1. HERO HEADER -->
        <header class="sa-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="sa-live-pulse">
                                <span class="pulse-dot"></span> Live Sales Intelligence
                            </div>
                            <span style="color: #94a3b8; font-size: 0.82rem;">• E-Benta Seller Studio</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 900; letter-spacing: -0.5px; margin: 0;">
                            <i class="fas fa-chart-line me-2" style="color: #10b981;"></i>Sales & Revenue Analytics
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Track offers, completed recycling transactions, revenue trends, and category performance.
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- 2. KPI METRICS GRID -->
        <div class="container-fluid px-3 px-md-4 mt-4">
            <div class="sa-stats-grid">
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Total Listings</p>
                    <h3 class="sa-stat-value">{{ number_format($totalListings) }}</h3>
                    <div class="sa-stat-sub">Published to catalog</div>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Offers Received</p>
                    <h3 class="sa-stat-value" style="color: #f59e0b;">{{ number_format($totalOffers) }}</h3>
                    <div class="sa-stat-sub">From verified recyclers</div>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Completed Sales</p>
                    <h3 class="sa-stat-value" style="color: #3b82f6;">{{ number_format($completedSales) }}</h3>
                    <div class="sa-stat-sub">Fulfilled transactions</div>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Total Revenue</p>
                    <h3 class="sa-stat-value sa-money">₱{{ number_format($totalRevenue, 2) }}</h3>
                    <div class="sa-stat-sub">Net payout earned</div>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Acceptance Rate</p>
                    <h3 class="sa-stat-value">{{ number_format($acceptanceRate, 1) }}%</h3>
                    <div class="sa-stat-sub">Avg bid: ₱{{ number_format($averageCompletedBid, 2) }}</div>
                </div>
            </div>

            <!-- 3. CHARTS GRID -->
            <div class="sa-panels">
                <div class="sa-card">
                    <div class="sa-card-header">
                        <h5><i class="fas fa-chart-area me-2" style="color: #0d9488;"></i>Monthly Sales and Revenue (Last 6 Months)</h5>
                    </div>
                    <div class="sa-card-body">
                        @if(array_sum($monthlySalesCounts) > 0 || array_sum($monthlyRevenue) > 0)
                            <div class="sa-chart-wrap">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        @else
                            <div class="sa-empty">No monthly sales data available yet.</div>
                        @endif
                    </div>
                </div>

                <div class="sa-card">
                    <div class="sa-card-header">
                        <h5><i class="fas fa-chart-pie me-2" style="color: #0d9488;"></i>Offer Status Breakdown</h5>
                    </div>
                    <div class="sa-card-body">
                        @if(array_sum($statusBreakdown) > 0)
                            <div class="sa-chart-wrap" style="height: 260px;">
                                <canvas id="statusBreakdownChart"></canvas>
                            </div>
                        @else
                            <div class="sa-empty">No offers available for status analytics.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 4. DETAILED TABLES ROW -->
            <div class="row g-3 g-lg-4">
                <div class="col-lg-6">
                    <div class="sa-card" style="height: 100%;">
                        <div class="sa-card-header">
                            <h5><i class="fas fa-layer-group me-2" style="color: #0d9488;"></i>Top Categories (Completed Sales)</h5>
                        </div>
                        <div class="sa-card-body p-0">
                            @if($topCategories->count() > 0)
                                <div class="table-responsive">
                                    <table class="sa-table">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Sales</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topCategories as $category)
                                                <tr>
                                                    <td style="font-weight: 700;">{{ $category->category }}</td>
                                                    <td>{{ number_format($category->sales_count) }}</td>
                                                    <td class="sa-money">₱{{ number_format((float) $category->revenue, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="sa-empty">No completed sales categories to show yet.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="sa-card" style="height: 100%;">
                        <div class="sa-card-header">
                            <h5><i class="fas fa-clock me-2" style="color: #0d9488;"></i>Recent Completed Sales</h5>
                        </div>
                        <div class="sa-card-body p-0">
                            @if($recentCompletedSales->count() > 0)
                                <div class="table-responsive">
                                    <table class="sa-table">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Buyer</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentCompletedSales as $sale)
                                                <tr>
                                                    <td style="font-weight: 700;">{{ $sale->listing->category ?: ($sale->listing->deviceType->name ?? 'Item') }}</td>
                                                    <td>{{ $sale->buyer->name }}</td>
                                                    <td class="sa-money">₱{{ number_format($sale->bid_amount, 2) }}</td>
                                                    <td style="color: #64748b; font-size: 0.82rem;">{{ $sale->updated_at->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="sa-empty">No completed sales yet.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlySalesCanvas = document.getElementById('monthlySalesChart');
        if (monthlySalesCanvas && typeof Chart !== 'undefined') {
            new Chart(monthlySalesCanvas, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [
                        {
                            label: 'Completed Sales',
                            data: @json($monthlySalesCounts),
                            backgroundColor: 'rgba(13, 148, 136, 0.8)',
                            hoverBackgroundColor: '#10b981',
                            borderColor: '#0d9488',
                            borderWidth: 1,
                            borderRadius: 8,
                            maxBarThickness: 36,
                            yAxisID: 'ySales'
                        },
                        {
                            label: 'Revenue (PHP)',
                            data: @json($monthlyRevenue),
                            type: 'line',
                            borderColor: '#06b6d4',
                            backgroundColor: 'rgba(6, 182, 212, 0.1)',
                            pointBackgroundColor: '#06b6d4',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            yAxisID: 'yRevenue'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#64748b',
                                font: { weight: '600', size: 12 },
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(9, 23, 31, 0.95)',
                            titleColor: '#ffffff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(13, 148, 136, 0.4)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    if (context.dataset.label.includes('Revenue')) {
                                        return context.dataset.label + ': ₱' + Number(context.parsed.y).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    }
                                    return context.dataset.label + ': ' + context.parsed.y + ' orders';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { weight: '700', size: 11 }
                            }
                        },
                        ySales: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Completed Sales',
                                color: '#64748b',
                                font: { weight: '700', size: 11 }
                            },
                            ticks: {
                                precision: 0,
                                color: '#64748b'
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.12)'
                            }
                        },
                        yRevenue: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            title: {
                                display: true,
                                text: 'Revenue (PHP)',
                                color: '#64748b',
                                font: { weight: '700', size: 11 }
                            },
                            ticks: {
                                color: '#64748b',
                                callback: function (value) {
                                    return '₱' + Number(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        const statusCanvas = document.getElementById('statusBreakdownChart');
        if (statusCanvas && typeof Chart !== 'undefined') {
            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Accepted', 'Completed', 'Rejected', 'Cancelled'],
                    datasets: [{
                        data: [
                            {{ $statusBreakdown['pending'] }},
                            {{ $statusBreakdown['accepted'] }},
                            {{ $statusBreakdown['completed'] }},
                            {{ $statusBreakdown['rejected'] }},
                            {{ $statusBreakdown['cancelled'] }}
                        ],
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.85)',
                            'rgba(59, 130, 246, 0.85)',
                            'rgba(13, 148, 136, 0.85)',
                            'rgba(239, 68, 68, 0.85)',
                            'rgba(100, 116, 139, 0.85)'
                        ],
                        borderColor: [
                            'rgba(245, 158, 11, 1)',
                            'rgba(59, 130, 246, 1)',
                            'rgba(13, 148, 136, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(100, 116, 139, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
