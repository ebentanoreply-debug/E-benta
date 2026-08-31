@extends('layouts.app')

@section('title', 'Sales Analytics - E-Benta')

@section('content')
<style>
    .sa-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .sa-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: white;
        padding: 2.25rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .sa-header::before {
        content: '';
        position: absolute;
        top: -45%;
        right: -12%;
        width: 420px;
        height: 420px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .sa-header-content {
        position: relative;
        z-index: 1;
    }

    .sa-header h1 {
        font-size: 2.1rem;
        font-weight: 900;
        margin: 0 0 0.4rem;
        letter-spacing: -0.4px;
    }

    .sa-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 0.95rem;
    }

    .sa-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .sa-stat-card {
        background: white;
        border: 1px solid rgba(13, 148, 136, 0.12);
        border-radius: 1rem;
        padding: 1.1rem 1.2rem;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.06);
    }

    .sa-stat-label {
        color: #64748b;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        margin: 0 0 0.5rem;
    }

    .sa-stat-value {
        color: #0f172a;
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0;
    }

    .sa-stat-sub {
        margin-top: 0.3rem;
        color: #64748b;
        font-size: 0.82rem;
    }

    .sa-panels {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .sa-card {
        background: white;
        border: 1px solid rgba(13, 148, 136, 0.12);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .sa-card-header {
        padding: 1rem 1.2rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.12);
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%);
    }

    .sa-card-header h5 {
        margin: 0;
        color: #1e293b;
        font-size: 1rem;
        font-weight: 800;
    }

    .sa-card-body {
        padding: 1rem 1.2rem;
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
        border-radius: 0.8rem;
        background: rgba(13, 148, 136, 0.03);
    }

    .sa-table {
        width: 100%;
        margin: 0;
        color: #1e293b;
        border-collapse: collapse;
    }

    .sa-table thead {
        background: rgba(13, 148, 136, 0.06);
    }

    .sa-table th {
        color: #0d9488;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 800;
        padding: 0.85rem 0.8rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
    }

    .sa-table td {
        padding: 0.9rem 0.8rem;
        border-bottom: 1px solid rgba(13, 148, 136, 0.08);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .sa-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.03);
    }

    .sa-money {
        color: #0d9488;
        font-weight: 800;
    }

    .sa-section {
        margin-top: 1rem;
    }

    body.dark-mode .sa-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .sa-card,
    body.dark-mode .sa-stat-card {
        background: #2a2a2a;
        border-color: rgba(13, 148, 136, 0.25);
    }

    body.dark-mode .sa-card-header {
        border-bottom-color: rgba(13, 148, 136, 0.2);
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.04) 100%);
    }

    body.dark-mode .sa-card-header h5,
    body.dark-mode .sa-stat-value,
    body.dark-mode .sa-table td {
        color: #e2e8f0;
    }

    body.dark-mode .sa-stat-label,
    body.dark-mode .sa-stat-sub,
    body.dark-mode .sa-empty {
        color: #94a3b8;
    }

    @media (max-width: 992px) {
        .sa-panels {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .sa-header {
            padding: 1.75rem 1rem;
        }

        .sa-header h1 {
            font-size: 1.5rem;
        }

        .sa-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .sa-chart-wrap {
            height: 240px;
        }
    }

    @media (max-width: 480px) {
        .sa-wrapper {
            padding: 1rem 0;
        }

        .sa-stats-grid {
            grid-template-columns: 1fr;
        }

        .sa-stat-card, .sa-chart-card {
            border-radius: 1rem;
            padding: 1.25rem 1rem;
        }
    }
</style>

@include('seller.sidebar')
<div class="main-content-wrapper">
    <div class="sa-wrapper">
        <div class="sa-header">
            <div class="container-fluid px-3 px-md-4 sa-header-content">
                <h1><i class="fas fa-chart-bar me-2"></i>Sales Analytics</h1>
                <p>Track your offers, completed sales, revenue trends, and category performance.</p>
            </div>
        </div>

        <div class="container-fluid px-3 px-md-4">
            <div class="sa-stats-grid">
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Total Listings</p>
                    <h3 class="sa-stat-value">{{ number_format($totalListings) }}</h3>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Offers Received</p>
                    <h3 class="sa-stat-value">{{ number_format($totalOffers) }}</h3>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Completed Sales</p>
                    <h3 class="sa-stat-value">{{ number_format($completedSales) }}</h3>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Total Revenue</p>
                    <h3 class="sa-stat-value sa-money">PHP {{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="sa-stat-card">
                    <p class="sa-stat-label">Acceptance Rate</p>
                    <h3 class="sa-stat-value">{{ number_format($acceptanceRate, 1) }}%</h3>
                    <div class="sa-stat-sub">Avg completed bid: PHP {{ number_format($averageCompletedBid, 2) }}</div>
                </div>
            </div>

            <div class="sa-panels">
                <div class="sa-card">
                    <div class="sa-card-header">
                        <h5><i class="fas fa-chart-line me-2" style="color: #0d9488;"></i>Monthly Sales and Revenue (Last 6 Months)</h5>
                    </div>
                    <div class="sa-card-body">
                        @if(array_sum($monthlySalesCounts) > 0 || array_sum($monthlyRevenue) > 0)
                            <div class="sa-chart-wrap">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        @else
                            <div class="sa-empty">No monthly sales data yet.</div>
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

            <div class="row sa-section">
                <div class="col-lg-6 mb-3">
                    <div class="sa-card" style="height: 100%;">
                        <div class="sa-card-header">
                            <h5><i class="fas fa-layer-group me-2" style="color: #0d9488;"></i>Top Categories (Completed Sales)</h5>
                        </div>
                        <div class="sa-card-body" style="padding: 0;">
                            @if($topCategories->count() > 0)
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
                                                <td>{{ $category->category }}</td>
                                                <td>{{ number_format($category->sales_count) }}</td>
                                                <td class="sa-money">PHP {{ number_format((float) $category->revenue, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="sa-card-body">
                                    <div class="sa-empty">No completed sales categories to show yet.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="sa-card" style="height: 100%;">
                        <div class="sa-card-header">
                            <h5><i class="fas fa-clock me-2" style="color: #0d9488;"></i>Recent Completed Sales</h5>
                        </div>
                        <div class="sa-card-body" style="padding: 0;">
                            @if($recentCompletedSales->count() > 0)
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
                                                <td>{{ $sale->listing->category ?: ($sale->listing->deviceType->name ?? 'Item') }}</td>
                                                <td>{{ $sale->buyer->name }}</td>
                                                <td class="sa-money">PHP {{ number_format($sale->bid_amount, 2) }}</td>
                                                <td>{{ $sale->updated_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="sa-card-body">
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
                            backgroundColor: 'rgba(13, 148, 136, 0.65)',
                            borderColor: 'rgba(13, 148, 136, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            yAxisID: 'ySales'
                        },
                        {
                            label: 'Revenue (PHP)',
                            data: @json($monthlyRevenue),
                            type: 'line',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderWidth: 2,
                            tension: 0.35,
                            fill: false,
                            yAxisID: 'yRevenue'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        ySales: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Completed Sales'
                            },
                            ticks: {
                                precision: 0
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
                                text: 'Revenue (PHP)'
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
