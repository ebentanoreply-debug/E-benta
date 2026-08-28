@extends('layouts.app')

@section('title', 'Security & System Audit Trail - E-Benta Admin')

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
        background: radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.15) 0%, transparent 70%);
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
                            <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-history me-1"></i>Security Audit Ledger
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $logs->total() }} Logged Events</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            System Audit Trail
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Immutable log of administrative approvals, user strikes, account suspensions, and logins.
                        </p>
                    </div>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.2);">
                        <i class="fas fa-arrow-left"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- FILTER TOOLBAR -->
            <div class="admin-card mb-4 p-3 p-md-4">
                <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Action Filter</label>
                        <select name="action" class="form-select form-select-sm" style="border-radius: 0.6rem; font-weight: 600;">
                            <option value="">All Actions</option>
                            <option value="user_login" {{ request('action') == 'user_login' ? 'selected' : '' }}>User Login</option>
                            <option value="user_verified" {{ request('action') == 'user_verified' ? 'selected' : '' }}>User Verified</option>
                            <option value="user_warning_strike" {{ request('action') == 'user_warning_strike' ? 'selected' : '' }}>Warning / Strike</option>
                            <option value="user_suspended" {{ request('action') == 'user_suspended' ? 'selected' : '' }}>User Suspended</option>
                            <option value="user_banned" {{ request('action') == 'user_banned' ? 'selected' : '' }}>User Banned</option>
                            <option value="listing_created" {{ request('action') == 'listing_created' ? 'selected' : '' }}>Listing Created</option>
                            <option value="offer_created" {{ request('action') == 'offer_created' ? 'selected' : '' }}>Offer Created</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Search Description or User</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search event description, user name, or IP address..." value="{{ request('search') }}" style="border-radius: 0.6rem;">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark w-100 font-weight-bold" style="border-radius: 0.6rem; padding: 0.45rem;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem;">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- AUDIT LOGS TABLE -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Actor / User</th>
                                <th>Action Taken</th>
                                <th>Description / Context</th>
                                <th>IP Address</th>
                                <th class="text-end">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td style="white-space: nowrap; color: #64748b; font-size: 0.82rem;">
                                        <i class="fas fa-clock me-1"></i>{{ $log->created_at->format('M d, Y • g:i:s A') }}
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $log->user?->name ?? 'System' }}</strong>
                                        <small class="text-muted">{{ $log->user?->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: rgba(168, 85, 247, 0.12); color: #9333ea; font-weight: 700; font-size: 0.78rem; text-transform: uppercase;">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td style="max-width: 320px;">
                                        <span style="font-size: 0.88rem; color: #334155;">{{ Str::limit($log->description, 100) }}</span>
                                    </td>
                                    <td>
                                        <span style="font-family: monospace; font-size: 0.82rem; background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 0.3rem;">
                                            {{ $log->ip_address ?? '127.0.0.1' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-outline-dark" style="font-weight: 700; border-radius: 0.5rem; font-size: 0.8rem; padding: 0.35rem 0.75rem;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fa-2x mb-2 d-block text-muted"></i>
                                        <strong>No audit logs match the current search filters.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div class="p-3 border-top">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
