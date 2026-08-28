@extends('layouts.app')

@section('title', 'User Safety & Incident Reports - E-Benta Admin')

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

    .admin-module-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(239, 68, 68, 0.15) 0%, transparent 70%);
        pointer-events: none;
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

    .admin-table th {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        padding: 0.9rem 1.25rem;
        border: none;
    }

    body.dark-mode .admin-table th {
        background: rgba(0, 0, 0, 0.2);
        color: #94a3b8;
    }

    .admin-table td {
        padding: 1.1rem 1.25rem;
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
                            <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-shield-cat me-1"></i>Safety & Moderation Queue
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $reports->total() }} Total Incidents</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            User Incident Reports
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Investigate reports on suspicious listings, harassment, counterfeit items, or trading disputes.
                        </p>
                    </div>

                    <div>
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

            <!-- 4-STAT SUMMARY ROW -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">TOTAL REPORTS</small>
                            <h4 class="m-0 font-weight-bold" style="font-family: 'Outfit', sans-serif;">{{ $reports->total() }}</h4>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(239, 68, 68, 0.1); color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            <i class="fas fa-flag"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">PENDING REVIEW</small>
                            <h4 class="m-0 font-weight-bold text-warning" style="font-family: 'Outfit', sans-serif;">
                                {{ $reports->getCollection()->filter(fn($r) => $r->status === 'pending')->count() }}
                            </h4>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">UNDER INVESTIGATION</small>
                            <h4 class="m-0 font-weight-bold text-info" style="font-family: 'Outfit', sans-serif;">
                                {{ $reports->getCollection()->filter(fn($r) => $r->status === 'under_review')->count() }}
                            </h4>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(6, 182, 212, 0.1); color: #06b6d4; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            <i class="fas fa-magnifying-glass"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 bg-white border rounded-4 d-flex align-items-center justify-content-between shadow-sm" style="border-color: rgba(13,148,136,0.15) !important;">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">RESOLVED INCIDENTS</small>
                            <h4 class="m-0 font-weight-bold text-success" style="font-family: 'Outfit', sans-serif;">
                                {{ $reports->getCollection()->filter(fn($r) => $r->status === 'resolved')->count() }}
                            </h4>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER TOOLBAR -->
            <div class="admin-card mb-4 p-3 p-md-4">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Status Filter</label>
                        <select name="status" class="form-select form-select-sm" style="font-weight: 600; border-radius: 0.6rem;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Reason Category</label>
                        <select name="reason" class="form-select form-select-sm" style="font-weight: 600; border-radius: 0.6rem;">
                            <option value="">All Reasons</option>
                            <option value="inappropriate_content" {{ request('reason') == 'inappropriate_content' ? 'selected' : '' }}>Inappropriate Content</option>
                            <option value="scam_fraud" {{ request('reason') == 'scam_fraud' ? 'selected' : '' }}>Scam / Fraud</option>
                            <option value="harassment" {{ request('reason') == 'harassment' ? 'selected' : '' }}>Harassment</option>
                            <option value="spam" {{ request('reason') == 'spam' ? 'selected' : '' }}>Spam</option>
                            <option value="counterfeit" {{ request('reason') == 'counterfeit' ? 'selected' : '' }}>Counterfeit / Fake</option>
                            <option value="other" {{ request('reason') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Search Reporter / Target</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search user name or email..." value="{{ request('search') }}" style="border-radius: 0.6rem;">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark w-100 font-weight-bold" style="border-radius: 0.6rem; padding: 0.45rem;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem;" title="Reset Filters">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- REPORTS TABLE -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Incident ID</th>
                                <th>Reported Subject</th>
                                <th>Reporter</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>
                                        <strong style="color: #0f172a;">#{{ $report->id }}</strong>
                                    </td>
                                    <td>
                                        @php $type = class_basename($report->reportable_type); @endphp
                                        <span class="badge bg-light text-dark border font-weight-bold">
                                            {{ $type }} #{{ $report->reportable_id }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <strong style="display: block; font-size: 0.88rem;">{{ $report->reporter?->name ?? 'Deleted User' }}</strong>
                                                <small class="text-muted">{{ $report->reporter?->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #dc2626; font-weight: 700; font-size: 0.78rem;">
                                            {{ $report->getReasonLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($report->status === 'pending')
                                            <span class="badge bg-warning text-dark font-weight-bold">Pending</span>
                                        @elseif($report->status === 'under_review')
                                            <span class="badge bg-info text-dark font-weight-bold">Reviewing</span>
                                        @elseif($report->status === 'resolved')
                                            <span class="badge bg-success font-weight-bold">Resolved</span>
                                        @else
                                            <span class="badge bg-secondary font-weight-bold">Dismissed</span>
                                        @endif
                                    </td>
                                    <td style="color: #64748b; font-size: 0.82rem;">
                                        {{ $report->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-dark" style="font-weight: 700; border-radius: 0.5rem; font-size: 0.8rem; padding: 0.35rem 0.85rem;">
                                            <i class="fas fa-eye me-1"></i>Investigate
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-shield-check fa-2x mb-2 d-block text-success"></i>
                                        <strong>No incident reports match the current criteria.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reports->hasPages())
                    <div class="p-3 border-top">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
