@extends('layouts.app')

@section('title', 'Impact Logs - E-Benta Admin')

@section('content')
<style>
    /* === IMPACT LOGS WRAPPER === */
    .impact-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .impact-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .impact-header::before {
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

    .impact-header::after {
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

    .impact-header-content {
        position: relative;
        z-index: 1;
    }

    .impact-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .impact-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === FILTER SECTION === */
    .filter-card-impact {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-wrapper-impact {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group-impact {
        flex: 1;
        min-width: 250px;
    }

    .filter-label-impact {
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

    .filter-label-impact i {
        color: #10b981;
    }

    .filter-select-impact {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.95rem;
    }

    .filter-select-impact:focus {
        border-color: rgba(16, 185, 129, 0.5);
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);
        background: white;
        outline: none;
    }

    .filter-btn-impact {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        cursor: pointer;
        white-space: nowrap;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-btn-impact:hover {
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        transform: translateY(-2px);
    }

    /* === TABLE SECTION === */
    .table-card-impact {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-header-impact {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
        border-bottom: 1px solid rgba(16, 185, 129, 0.15);
        padding: 1.5rem;
    }

    .table-header-impact h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-header-impact i {
        color: #10b981;
    }

    .table-responsive-impact {
        overflow-x: auto;
    }

    .impact-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .impact-table thead {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.04) 100%);
        border-bottom: 2px solid rgba(16, 185, 129, 0.15);
    }

    .impact-table thead th {
        color: #10b981;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
    }

    .impact-table tbody tr {
        border-bottom: 1px solid rgba(16, 185, 129, 0.08);
        transition: background 0.2s ease;
    }

    .impact-table tbody tr:hover {
        background: rgba(16, 185, 129, 0.04);
    }

    .impact-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    .device-info-impact {
        color: #1e293b;
        font-weight: 600;
    }

    .device-weight {
        color: #64748b;
        font-weight: 400;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .seller-info-impact,
    .buyer-info-impact {
        color: #1e293b;
    }

    .seller-name-impact,
    .buyer-name-impact {
        font-weight: 700;
        display: block;
    }

    .seller-email-impact,
    .buyer-email-impact {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.3rem;
        display: block;
    }

    .co2-value {
        color: #10b981;
        font-weight: 700;
        font-size: 1rem;
    }

    .landfill-value {
        color: #0891b2;
        font-weight: 700;
        font-size: 1rem;
    }

    .materials-container {
        font-size: 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .material-badge {
        font-weight: 600;
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.3rem;
        font-size: 0.8rem;
    }

    .material-gold {
        color: #f59e0b;
    }

    .material-copper {
        color: #d97706;
    }

    .material-plastic {
        color: #6b7280;
    }

    .material-aluminum {
        color: #9ca3af;
    }

    .no-recovery {
        background: linear-gradient(135deg, rgba(148, 163, 184, 0.12) 0%, rgba(148, 163, 184, 0.06) 100%);
        color: #64748b;
        font-weight: 600;
        padding: 0.4rem 0.6rem;
        border-radius: 0.3rem;
        font-size: 0.8rem;
        display: inline-block;
        border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .status-badge-impact {
        padding: 0.5rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        display: inline-block;
        font-weight: 700;
        border: 1px solid;
    }

    .status-pending-impact {
        background: rgba(249, 115, 22, 0.15);
        color: #f97316;
        border-color: rgba(249, 115, 22, 0.2);
    }

    .status-certified-impact {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }

    .status-completed-impact {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border-color: rgba(168, 85, 247, 0.2);
    }

    .date-value-impact {
        color: #64748b;
        font-size: 0.9rem;
    }

    .date-meta-impact {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }

    /* === PAGINATION === */
    .pagination-wrapper-impact {
        padding: 1.5rem;
        border-top: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        justify-content: center;
    }

    /* === EMPTY STATE === */
    .empty-state-impact {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-icon-impact {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: #10b981;
    }

    .empty-title-impact {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .empty-message-impact {
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .empty-link-impact {
        color: #10b981;
        text-decoration: none;
        font-weight: 700;
    }

    .empty-link-impact:hover {
        text-decoration: underline;
    }

    /* === DARK MODE === */
    body.dark-mode .impact-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .filter-card-impact,
    body.dark-mode .table-card-impact {
        background: #2a2a2a;
        border-color: rgba(16, 185, 129, 0.2);
    }

    body.dark-mode .filter-label-impact,
    body.dark-mode .table-header-impact h5,
    body.dark-mode .device-info-impact,
    body.dark-mode .seller-info-impact,
    body.dark-mode .buyer-info-impact,
    body.dark-mode .empty-title-impact,
    body.dark-mode .impact-table td {
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-impact {
        background: #333333;
        border-color: rgba(16, 185, 129, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-impact:focus {
        background: #3a3a3a;
    }

    body.dark-mode .impact-table thead {
        background: rgba(16, 185, 129, 0.1);
    }

    body.dark-mode .impact-table tbody tr:hover {
        background: rgba(16, 185, 129, 0.08);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .impact-header {
            padding: 1.75rem 1rem;
        }

        .impact-header h1 {
            font-size: 1.5rem;
        }

        .filter-wrapper-impact {
            flex-direction: column;
            gap: 1rem;
        }

        .filter-group-impact,
        .filter-btn-impact {
            width: 100%;
        }

        .impact-table {
            font-size: 0.85rem;
        }

        .impact-table td {
            padding: 0.85rem 0.5rem;
        }

        .materials-container {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .impact-wrapper {
            padding: 1rem 0;
        }

        .filter-card-impact, .table-card-impact {
            border-radius: 1rem;
            padding: 1rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="impact-wrapper">
        <!-- Header -->
        <div class="impact-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="impact-header-content">
                    <h1><i class="fas fa-leaf me-2"></i>Impact Logs</h1>
                    <p>Track environmental impact and certifications ({{ $logs->total() }} records)</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-3 px-md-4">
            <!-- Filter Section -->
            <div class="filter-card-impact">
                <form method="GET" action="{{ route('admin.impact-logs') }}" class="filter-wrapper-impact">
                    <div class="filter-group-impact">
                        <label class="filter-label-impact">
                            <i class="fas fa-filter"></i>Filter by Status
                        </label>
                        <select name="status" class="filter-select-impact">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="certified" {{ request('status') == 'certified' ? 'selected' : '' }}>Certified</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="filter-btn-impact">
                        <i class="fas fa-search"></i>Filter
                    </button>
                </form>
            </div>

            <!-- Impact Logs Table -->
            <div class="table-card-impact">
                <div class="table-header-impact">
                    <h5><i class="fas fa-chart-line"></i>Environmental Impact Records</h5>
                </div>
                <div class="table-responsive-impact">
                    @if($logs->count() > 0)
                        <table class="impact-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-laptop me-1"></i>Device</th>
                                    <th><i class="fas fa-user me-1"></i>Seller</th>
                                    <th><i class="fas fa-handshake me-1"></i>Buyer</th>
                                    <th><i class="fas fa-leaf me-1"></i>CO₂ Saved</th>
                                    <th><i class="fas fa-recycle me-1"></i>Landfill Diverted</th>
                                    <th><i class="fas fa-gem me-1"></i>Materials Recovered</th>
                                    <th><i class="fas fa-certificate me-1"></i>Status</th>
                                    <th><i class="fas fa-calendar me-1"></i>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <!-- Device -->
                                        <td>
                                            <div class="device-info-impact">{{ $log->device_category }}</div>
                                            <div class="device-weight">{{ $log->device_weight }} kg</div>
                                        </td>

                                        <!-- Seller -->
                                        <td>
                                            <div class="seller-info-impact">
                                                <span class="seller-name-impact">{{ $log->seller->name }}</span>
                                                <span class="seller-email-impact">{{ $log->seller->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Buyer -->
                                        <td>
                                            <div class="buyer-info-impact">
                                                <span class="buyer-name-impact">{{ $log->buyer->name ?? 'N/A' }}</span>
                                                <span class="buyer-email-impact">{{ $log->buyer->email ?? 'N/A' }}</span>
                                            </div>
                                        </td>

                                        <!-- CO2 Saved -->
                                        <td>
                                            <span class="co2-value">{{ number_format($log->co2_saved, 2) }} kg</span>
                                        </td>

                                        <!-- Landfill Diverted -->
                                        <td>
                                            <span class="landfill-value">{{ number_format($log->landfill_diverted_weight, 2) }} kg</span>
                                        </td>

                                        <!-- Materials Recovered -->
                                        <td>
                                            @php
                                                $hasRecovered = ($log->gold_recovered > 0) || ($log->copper_recovered > 0) || ($log->plastic_recovered > 0) || ($log->aluminum_recovered > 0);
                                            @endphp
                                            @if($hasRecovered)
                                                <div class="materials-container">
                                                    @if($log->gold_recovered > 0)
                                                        <span class="material-badge material-gold"><i class="fas fa-ring me-1"></i>Au: {{ $log->gold_recovered }}g</span>
                                                    @endif
                                                    @if($log->copper_recovered > 0)
                                                        <span class="material-badge material-copper"><i class="fas fa-bolt me-1"></i>Cu: {{ $log->copper_recovered }}g</span>
                                                    @endif
                                                    @if($log->plastic_recovered > 0)
                                                        <span class="material-badge material-plastic"><i class="fas fa-cube me-1"></i>Plastic: {{ $log->plastic_recovered }}g</span>
                                                    @endif
                                                    @if($log->aluminum_recovered > 0)
                                                        <span class="material-badge material-aluminum"><i class="fas fa-shield-alt me-1"></i>Al: {{ $log->aluminum_recovered }}g</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="no-recovery"><i class="fas fa-info-circle me-1"></i>No Recovery Data</span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @if($log->status === 'pending')
                                                <span class="status-badge-impact status-pending-impact">
                                                    <i class="fas fa-hourglass-half me-1"></i>Pending
                                                </span>
                                            @elseif($log->status === 'certified')
                                                <span class="status-badge-impact status-certified-impact">
                                                    <i class="fas fa-certificate me-1"></i>Certified
                                                </span>
                                            @elseif($log->status === 'completed')
                                                <span class="status-badge-impact status-completed-impact">
                                                    <i class="fas fa-check-circle me-1"></i>Completed
                                                </span>
                                            @else
                                                <span class="status-badge-impact" style="background: rgba(203, 213, 225, 0.15); color: #64748b; border-color: rgba(203, 213, 225, 0.2);">
                                                    {{ ucfirst($log->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <div class="date-value-impact">{{ $log->created_at->format('M d, Y') }}</div>
                                            <span class="date-meta-impact">{{ $log->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper-impact">
                            {{ $logs->links() }}
                        </div>
                    @else
                        <div class="empty-state-impact">
                            <div class="empty-icon-impact">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5 class="empty-title-impact">No Impact Logs Found</h5>
                            <p class="empty-message-impact">
                                @if(request('status'))
                                    No impact logs found with the selected status. <a href="{{ route('admin.impact-logs') }}" class="empty-link-impact">Clear filters</a>
                                @else
                                    There are currently no impact logs in the system.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
