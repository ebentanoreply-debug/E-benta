@extends('layouts.app')

@section('title', 'Reports Management - E-Benta Admin')

@section('content')
<style>
    /* === REPORTS WRAPPER === */
    .reports-mgmt-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .reports-mgmt-header {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .reports-mgmt-header::before {
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

    .reports-mgmt-header::after {
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

    .reports-mgmt-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .reports-mgmt-icon-box {
        background: rgba(255, 255, 255, 0.2);
        width: 70px;
        height: 70px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
    }

    .reports-mgmt-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .reports-mgmt-header p {
        opacity: 0.95;
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    /* === STAT CARDS === */
    .stat-card-mgmt {
        background: white;
        border-radius: 1.2rem;
        padding: 1.75rem;
        border: 1px solid rgba(220, 38, 38, 0.08);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        border-top-width: 4px;
    }

    .stat-card-mgmt:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }

    .stat-card-red { border-top-color: #dc2626; }
    .stat-card-orange { border-top-color: #f97316; }
    .stat-card-blue { border-top-color: #3b82f6; }
    .stat-card-green { border-top-color: #22c55e; }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .stat-icon-red {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, rgba(220, 38, 38, 0.08) 100%);
        color: #dc2626;
    }

    .stat-icon-orange {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(249, 115, 22, 0.08) 100%);
        color: #f97316;
    }

    .stat-icon-blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .stat-icon-green {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%);
        color: #22c55e;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        margin: 0.75rem 0 0.5rem 0;
    }

    .stat-description {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
        font-weight: 500;
    }

    /* === FILTER SECTION === */
    .filter-card-mgmt {
        background: white;
        border-radius: 1.2rem;
        padding: 2rem;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-card-mgmt h6 {
        color: #1e293b;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-card-mgmt h6 i {
        color: #dc2626;
    }

    .filter-label-mgmt {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
        display: block;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-label-mgmt i {
        color: #dc2626;
    }

    .filter-select-mgmt,
    .filter-input-mgmt {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(220, 38, 38, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.95rem;
    }

    .filter-select-mgmt:focus,
    .filter-input-mgmt:focus {
        border-color: rgba(220, 38, 38, 0.5);
        box-shadow: 0 0 15px rgba(220, 38, 38, 0.15);
        background: white;
        outline: none;
    }

    .filter-btn-mgmt {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        width: 100%;
        justify-content: center;
    }

    .filter-btn-mgmt:hover {
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35);
        transform: translateY(-2px);
    }

    /* === TABLE SECTION === */
    .table-card-mgmt {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(220, 38, 38, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-header-mgmt {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        border-bottom: 2px solid rgba(220, 38, 38, 0.15);
        padding: 1.5rem;
    }

    .table-header-mgmt h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-header-mgmt i {
        color: #dc2626;
    }

    .table-responsive-mgmt {
        overflow-x: auto;
    }

    .reports-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .reports-table thead {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.08) 0%, rgba(220, 38, 38, 0.04) 100%);
        border-bottom: 2px solid rgba(220, 38, 38, 0.15);
    }

    .reports-table thead th {
        color: #dc2626;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
    }

    .reports-table tbody tr {
        border-bottom: 1px solid rgba(220, 38, 38, 0.08);
        transition: background 0.2s ease;
    }

    .reports-table tbody tr:hover {
        background: rgba(220, 38, 38, 0.04);
    }

    .reports-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    .report-id {
        color: #dc2626;
        font-weight: 700;
        background: rgba(220, 38, 38, 0.08);
        padding: 0.3rem 0.6rem;
        border-radius: 0.4rem;
        font-family: monospace;
        font-size: 0.85rem;
    }

    .reporter-info {
        color: #1e293b;
    }

    .reporter-name {
        font-weight: 700;
        display: block;
    }

    .reporter-email {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.3rem;
        display: block;
    }

    .reason-badge {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, rgba(220, 38, 38, 0.08) 100%);
        color: #dc2626;
        padding: 0.5rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .status-badge {
        padding: 0.5rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        display: inline-block;
        font-weight: 700;
        border: 1px solid;
    }

    .status-pending {
        background: rgba(249, 115, 22, 0.15);
        color: #f97316;
        border-color: rgba(249, 115, 22, 0.2);
    }

    .status-review {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .status-resolved {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.2);
    }

    .status-dismissed {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
        border-color: rgba(107, 114, 128, 0.2);
    }

    .date-value {
        color: #64748b;
        font-size: 0.9rem;
    }

    .review-btn {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border: none;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        cursor: pointer;
    }

    .review-btn:hover {
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }

    /* === PAGINATION === */
    .pagination-wrapper-mgmt {
        padding: 1.5rem;
        border-top: 1px solid rgba(220, 38, 38, 0.1);
        display: flex;
        justify-content: center;
    }

    /* === EMPTY STATE === */
    .empty-state-mgmt {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-icon-mgmt {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, rgba(220, 38, 38, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 3.5rem;
        color: rgba(220, 38, 38, 0.3);
    }

    .empty-title-mgmt {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .empty-message-mgmt {
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    /* === DARK MODE === */
    body.dark-mode .reports-mgmt-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .filter-card-mgmt,
    body.dark-mode .table-card-mgmt,
    body.dark-mode .stat-card-mgmt {
        background: #2a2a2a;
        border-color: rgba(220, 38, 38, 0.2);
    }

    body.dark-mode .filter-label-mgmt,
    body.dark-mode .stat-label,
    body.dark-mode .table-header-mgmt h5,
    body.dark-mode .reporter-info,
    body.dark-mode .empty-title-mgmt {
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-mgmt,
    body.dark-mode .filter-input-mgmt {
        background: #333333;
        border-color: rgba(220, 38, 38, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select-mgmt:focus,
    body.dark-mode .filter-input-mgmt:focus {
        background: #3a3a3a;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .reports-mgmt-header {
            padding: 1.75rem 1rem;
        }

        .reports-mgmt-header h1 {
            font-size: 1.5rem;
        }

        .reports-mgmt-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .filter-wrapper-mgmt {
            flex-direction: column;
            gap: 1rem;
        }

        .filter-group-mgmt,
        .filter-btn-mgmt {
            width: 100%;
        }

        .stat-value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .reports-mgmt-wrapper {
            padding: 1rem 0;
        }

        .stat-card-mgmt, .filter-card-mgmt, .table-card-mgmt {
            border-radius: 1rem;
            padding: 1.25rem 1rem;
            margin-bottom: 1rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="reports-mgmt-wrapper">
        <!-- Header -->
        <div class="reports-mgmt-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="reports-mgmt-header-content">
                    <div class="reports-mgmt-icon-box">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div>
                        <h1>Reports Management</h1>
                        <p>Review and manage user reports for inappropriate content, scams, and violations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-3 px-md-4">
            <!-- Statistics Grid -->
            <div class="row mb-4">
                <!-- Total Reports -->
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-mgmt stat-card-red">
                        <div class="stat-header">
                            <div class="stat-icon-box stat-icon-red">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div>
                                <p class="stat-label">Total Reports</p>
                            </div>
                        </div>
                        <h3 class="stat-value" style="color: #dc2626;">{{ $reports->total() }}</h3>
                        <p class="stat-description">All submitted reports</p>
                    </div>
                </div>

                <!-- Pending -->
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-mgmt stat-card-orange">
                        <div class="stat-header">
                            <div class="stat-icon-box stat-icon-orange">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div>
                                <p class="stat-label">Pending</p>
                            </div>
                        </div>
                        <h3 class="stat-value" style="color: #f97316;">
                            @php
                                $pending = $reports->getCollection()->filter(fn($r) => $r->status === 'pending')->count();
                            @endphp
                            {{ $pending }}
                        </h3>
                        <p class="stat-description">Awaiting review</p>
                    </div>
                </div>

                <!-- Under Review -->
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-mgmt stat-card-blue">
                        <div class="stat-header">
                            <div class="stat-icon-box stat-icon-blue">
                                <i class="fas fa-magnifying-glass"></i>
                            </div>
                            <div>
                                <p class="stat-label">Under Review</p>
                            </div>
                        </div>
                        <h3 class="stat-value" style="color: #3b82f6;">
                            @php
                                $review = $reports->getCollection()->filter(fn($r) => $r->status === 'under_review')->count();
                            @endphp
                            {{ $review }}
                        </h3>
                        <p class="stat-description">Currently being processed</p>
                    </div>
                </div>

                <!-- Resolved -->
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-mgmt stat-card-green">
                        <div class="stat-header">
                            <div class="stat-icon-box stat-icon-green">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <p class="stat-label">Resolved</p>
                            </div>
                        </div>
                        <h3 class="stat-value" style="color: #22c55e;">
                            @php
                                $resolved = $reports->getCollection()->filter(fn($r) => $r->status === 'resolved')->count();
                            @endphp
                            {{ $resolved }}
                        </h3>
                        <p class="stat-description">Completed actions</p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-card-mgmt">
                <h6><i class="fas fa-filter"></i>Filter Reports</h6>
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="filter-label-mgmt">
                            <i class="fas fa-toggle-on"></i>Status
                        </label>
                        <select name="status" class="filter-select-mgmt">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label-mgmt">
                            <i class="fas fa-exclamation-circle"></i>Reason
                        </label>
                        <select name="reason" class="filter-select-mgmt">
                            <option value="">All Reasons</option>
                            <option value="scam_fraud" {{ request('reason') == 'scam_fraud' ? 'selected' : '' }}>Scam/Fraud</option>
                            <option value="inappropriate_content" {{ request('reason') == 'inappropriate_content' ? 'selected' : '' }}>Inappropriate Content</option>
                            <option value="harassment_abuse" {{ request('reason') == 'harassment_abuse' ? 'selected' : '' }}>Harassment/Abuse</option>
                            <option value="fake_listing" {{ request('reason') == 'fake_listing' ? 'selected' : '' }}>Fake Listing</option>
                            <option value="seller_unresponsive" {{ request('reason') == 'seller_unresponsive' ? 'selected' : '' }}>Seller Unresponsive</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label-mgmt">
                            <i class="fas fa-list"></i>Type
                        </label>
                        <select name="type" class="filter-select-mgmt">
                            <option value="">All Types</option>
                            <option value="Listing" {{ request('type') == 'Listing' ? 'selected' : '' }}>Listings</option>
                            <option value="Offer" {{ request('type') == 'Offer' ? 'selected' : '' }}>Offers</option>
                            <option value="User" {{ request('type') == 'User' ? 'selected' : '' }}>Users</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label-mgmt">
                            <i class="fas fa-search"></i>Search
                        </label>
                        <input type="text" name="search" placeholder="Search report details..." value="{{ request('search') }}" class="filter-input-mgmt">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="filter-btn-mgmt">
                            <i class="fas fa-search"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reports Table -->
            <div class="table-card-mgmt">
                <div class="table-header-mgmt">
                    <h5><i class="fas fa-list"></i>All Reports</h5>
                </div>
                <div class="table-responsive-mgmt">
                    @if($reports->count() > 0)
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> ID</th>
                                    <th><i class="fas fa-user"></i> Reporter</th>
                                    <th><i class="fas fa-link"></i> Item</th>
                                    <th><i class="fas fa-exclamation"></i> Reason</th>
                                    <th><i class="fas fa-certificate"></i> Status</th>
                                    <th><i class="fas fa-clock"></i> Submitted</th>
                                    <th><i class="fas fa-action"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>
                                            <span class="report-id">#{{ $report->id }}</span>
                                        </td>
                                        <td>
                                            <div class="reporter-info">
                                                <span class="reporter-name">{{ $report->reporter->name }}</span>
                                                <span class="reporter-email">{{ $report->reporter->email }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <small style="color: #64748b;">
                                                @php
                                                    $type = class_basename($report->reportable_type);
                                                @endphp
                                                <strong style="color: #1e293b;">{{ $type }}</strong><br>
                                                @if($type === 'Listing')
                                                    <span style="color: #dc2626;">{{ $report->reportable->category ?? 'N/A' }}</span>
                                                @elseif($type === 'Offer')
                                                    Offer #{{ $report->reportable->id }}
                                                @else
                                                    {{ $report->reportable->name ?? 'User' }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="reason-badge">{{ str_replace('_', ' ', ucfirst($report->reason)) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($report->status) {
                                                    'pending' => 'status-pending',
                                                    'under_review' => 'status-review',
                                                    'resolved' => 'status-resolved',
                                                    'dismissed' => 'status-dismissed',
                                                    default => 'status-pending'
                                                };
                                                $statusText = match($report->status) {
                                                    'pending' => 'Pending',
                                                    'under_review' => 'Under Review',
                                                    'resolved' => 'Resolved',
                                                    'dismissed' => 'Dismissed',
                                                    default => 'Unknown'
                                                };
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <span class="date-value">{{ $report->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report) }}" class="review-btn">
                                                <i class="fas fa-eye"></i>Review
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        @if($reports->hasPages())
                            <div class="pagination-wrapper-mgmt">
                                {{ $reports->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="empty-state-mgmt">
                            <div class="empty-icon-mgmt">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5 class="empty-title-mgmt">No reports found</h5>
                            <p class="empty-message-mgmt">There are no reports matching your filters. Your users are behaving well!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
