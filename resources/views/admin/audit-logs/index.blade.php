@extends('layouts.app')

@section('title', 'Audit Logs - E-Benta Admin')

@section('content')
<style>
    /* === AUDIT LOGS WRAPPER === */
    .audit-logs-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .audit-logs-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .audit-logs-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .audit-logs-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .audit-logs-header-content {
        position: relative;
        z-index: 1;
    }

    .audit-logs-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .audit-logs-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    .audit-logs-icon-box {
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem;
        border-radius: 0.8rem;
        font-size: 2rem;
    }

    /* === STAT CARDS === */
    .stat-card {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-top: 4px solid #3b82f6;
        border-radius: 1.2rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.06);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .stat-card:hover {
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.15);
        transform: translateY(-5px);
    }

    .stat-card.stat-card-cyan {
        border-top-color: #06b6d4;
    }

    .stat-card.stat-card-blue {
        border-top-color: #3b82f6;
    }

    .stat-card.stat-card-green {
        border-top-color: #22c55e;
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.stat-card-teal .stat-card-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .stat-card.stat-card-cyan .stat-card-icon {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
        color: #06b6d4;
    }

    .stat-card.stat-card-blue .stat-card-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.08) 100%);
        color: #3b82f6;
    }

    .stat-card.stat-card-green .stat-card-icon {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%);
        color: #22c55e;
    }

    .stat-card-label {
        color: #64748b;
        font-size: 0.8rem;
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card-value {
        margin: 0.75rem 0 0.5rem 0;
        font-weight: 800;
        font-size: 2rem;
    }

    .stat-card.stat-card-teal .stat-card-value {
        color: #3b82f6;
    }

    .stat-card.stat-card-cyan .stat-card-value {
        color: #06b6d4;
    }

    .stat-card.stat-card-blue .stat-card-value {
        color: #3b82f6;
    }

    .stat-card.stat-card-green .stat-card-value {
        color: #22c55e;
    }

    .stat-card-description {
        color: #64748b;
        margin: 0;
        font-size: 0.85rem;
    }

    /* === FILTER CARD === */
    .filter-card {
        background: white;
        border-radius: 1.2rem;
        padding: 1.8rem;
        border: 1px solid rgba(59, 130, 246, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .filter-wrapper {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 250px;
    }

    .filter-card h6 {
        color: #1e293b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-card-icon {
        color: #3b82f6;
    }

    .filter-label {
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

    .filter-label i {
        color: #3b82f6;
    }

    .filter-select,
    .filter-input {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1e293b;
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        width: 100%;
    }

    .filter-select:focus,
    .filter-input:focus {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.15);
        background: white;
        outline: none;
    }

    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }

    .filter-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        cursor: pointer;
        white-space: nowrap;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-btn:hover {
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    .filter-btn-export {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.85rem 2rem;
        font-weight: 700;
        border-radius: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        white-space: nowrap;
        font-size: 0.95rem;
    }

    .filter-btn-export:hover {
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    /* === TABLE CARD === */
    .table-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(59, 130, 246, 0.1);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-card-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border-bottom: 1px solid rgba(59, 130, 246, 0.15);
        padding: 1.5rem;
    }

    .table-card-header h5 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-card-icon {
        color: #3b82f6;
    }

    /* === TABLE STYLES === */
    .audit-table {
        color: #1e293b;
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .audit-table thead {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.04) 100%);
        border-bottom: 2px solid rgba(59, 130, 246, 0.15);
    }

    .audit-table th {
        color: #3b82f6;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 1.25rem 1rem;
        letter-spacing: 1px;
        border: none;
    }

    .audit-table tbody tr {
        border-bottom: 1px solid rgba(59, 130, 246, 0.08);
        transition: background 0.2s ease;
    }

    .audit-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.04);
    }

    .audit-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        color: #1e293b;
        font-size: 0.9rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .audit-table-date {
        font-weight: 600;
    }

    .audit-table-date-time {
        color: #64748b;
        font-size: 0.8rem;
    }

    .audit-table-user {
        color: #1e293b;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .audit-table-user-email {
        color: #64748b;
        font-size: 0.8rem;
    }

    .action-badge {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        color: #3b82f6;
        padding: 0.5rem 0.9rem;
        border-radius: 0.6rem;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .audit-table-description {
        color: #1e293b;
        font-size: 0.9rem;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .audit-table-ip {
        color: #64748b;
        font-size: 0.85rem;
        font-family: monospace;
        background: rgba(59, 130, 246, 0.05);
        padding: 0.3rem 0.6rem;
        border-radius: 0.4rem;
    }

    .view-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }

    .view-btn:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 1.5rem;
        border-top: 1px solid rgba(59, 130, 246, 0.1);
    }

    .pagination-wrapper .pagination {
        gap: 0.35rem !important;
        margin-bottom: 0 !important;
    }

    .pagination-wrapper .page-item {
        margin: 0 !important;
    }

    .pagination-wrapper .page-link {
        padding: 0.5rem 0.8rem !important;
        font-size: 0.9rem !important;
        color: #3b82f6 !important;
        border: 1px solid rgba(59, 130, 246, 0.25) !important;
        border-radius: 0.5rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1.4 !important;
        background: white !important;
    }

    .pagination-wrapper .page-link:hover {
        background: rgba(59, 130, 246, 0.08) !important;
        color: #2563eb !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
        transform: translateY(-1px) !important;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.2) !important;
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1 !important;
        background: #f8fafc !important;
        border-color: rgba(59, 130, 246, 0.12) !important;
        cursor: not-allowed !important;
        opacity: 0.65 !important;
    }

    /* === EMPTY STATE === */
    .empty-state-container {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.08));
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        color: rgba(59, 130, 246, 0.3);
    }

    .empty-state-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #64748b;
        margin: 0;
    }

    /* === DARK MODE === */
    body.dark-mode .audit-logs-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .audit-logs-header {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }

    body.dark-mode .filter-card,
    body.dark-mode .table-card,
    body.dark-mode .stat-card {
        background: #2a2a2a;
        border-color: rgba(59, 130, 246, 0.2);
    }

    body.dark-mode .filter-label,
    body.dark-mode .stat-card-value,
    body.dark-mode .table-card-header h5,
    body.dark-mode .audit-table-user {
        color: #e0e0e0;
    }

    body.dark-mode .filter-select,
    body.dark-mode .filter-input {
        background: #333333;
        border-color: rgba(59, 130, 246, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .filter-select:focus,
    body.dark-mode .filter-input:focus {
        background: #3a3a3a;
    }

    body.dark-mode .audit-table thead {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
    }

    body.dark-mode .audit-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }

    body.dark-mode .table-card-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.03) 100%);
    }

    body.dark-mode .pagination-wrapper .page-link {
        background: #2a2a2a !important;
        border-color: rgba(59, 130, 246, 0.2) !important;
        color: #60a5fa !important;
    }

    body.dark-mode .pagination-wrapper .page-link:hover {
        background: rgba(59, 130, 246, 0.12) !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
        color: #93c5fd !important;
    }

    body.dark-mode .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        border-color: #3b82f6 !important;
    }

    body.dark-mode .pagination-wrapper .page-item.disabled .page-link {
        background: #1a1a1a !important;
        border-color: rgba(59, 130, 246, 0.1) !important;
        color: #64748b !important;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .audit-logs-header h1 {
            font-size: 1.75rem;
        }

        .audit-table-description {
            max-width: 150px;
        }

        .filter-wrapper {
            flex-direction: column;
            gap: 1.5rem;
        }

        .filter-group {
            width: 100%;
            min-width: auto;
        }

        .filter-actions {
            width: 100%;
            flex-direction: column;
        }

        .filter-btn,
        .filter-btn-export {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="audit-logs-wrapper">
        <!-- Header -->
        <div class="audit-logs-header">
            <div class="container-fluid">
                <div class="audit-logs-header-content">
                    <h1><i class="fas fa-history me-2"></i>Audit Logs</h1>
                    <p>Track all system actions and changes for security and compliance</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid" style="padding: 0 2rem;">

        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-teal">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Total Logs</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">{{ $logs->total() }}</h3>
                    <p class="stat-card-description">All audit log entries</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-cyan">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Logins</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">
                        @php
                            $logins = $logs->getCollection()->filter(fn($l) => $l->action === 'login')->count();
                        @endphp
                        {{ $logins }}
                    </h3>
                    <p class="stat-card-description">Login events recorded</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-blue">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Logouts</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">
                        @php
                            $logouts = $logs->getCollection()->filter(fn($l) => $l->action === 'logout')->count();
                        @endphp
                        {{ $logouts }}
                    </h3>
                    <p class="stat-card-description">Logout events recorded</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card stat-card-green">
                    <div class="stat-card-header">
                        <div class="stat-card-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div>
                            <p class="stat-card-label">Changes</p>
                        </div>
                    </div>
                    <h3 class="stat-card-value">
                        @php
                            $changes = $logs->getCollection()->filter(fn($l) => in_array($l->action, ['create_offer', 'accept_offer', 'reject_offer', 'approve_seller', 'reject_seller']))->count();
                        @endphp
                        {{ $changes }}
                    </h3>
                    <p class="stat-card-description">System state changes</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="filter-wrapper">
                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-toggle-on"></i>Action Type</label>
                    <select name="action" class="filter-select">
                        <option value="">All Actions</option>
                        <option value="login" @if(request('action') === 'login') selected @endif>Login</option>
                        <option value="logout" @if(request('action') === 'logout') selected @endif>Logout</option>
                        <option value="register" @if(request('action') === 'register') selected @endif>Registration</option>
                        <option value="create_offer" @if(request('action') === 'create_offer') selected @endif>Create Offer</option>
                        <option value="accept_offer" @if(request('action') === 'accept_offer') selected @endif>Accept Offer</option>
                        <option value="reject_offer" @if(request('action') === 'reject_offer') selected @endif>Reject Offer</option>
                        <option value="approve_seller" @if(request('action') === 'approve_seller') selected @endif>Approve Account</option>
                        <option value="reject_seller" @if(request('action') === 'reject_seller') selected @endif>Reject Account</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-user"></i>User</label>
                    <select name="user_id" class="filter-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-boxes"></i>Model Type</label>
                    <select name="model_type" class="filter-select">
                        <option value="">All Models</option>
                        <option value="User" @if(request('model_type') === 'User') selected @endif>User</option>
                        <option value="Listing" @if(request('model_type') === 'Listing') selected @endif>Listing</option>
                        <option value="Offer" @if(request('model_type') === 'Offer') selected @endif>Offer</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-search"></i>Search</label>
                    <input type="text" name="search" placeholder="Search log details..." value="{{ request('search') ?? '' }}" class="filter-select">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search"></i>Filter
                    </button>
                    <a href="{{ route('admin.audit-logs.export', request()->query()) }}" class="filter-btn-export">
                        <i class="fas fa-download"></i>Export
                    </a>
                </div>
            </form>
        </div>

        <!-- Audit Logs Table -->
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-list table-card-icon"></i>All Logs</h5>
            </div>

            <div class="table-responsive" style="padding: 0;">
                @if($logs->count() > 0)
                    <table class="table audit-table">
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <div class="audit-table-date">{{ $log->created_at->format('M d, Y') }}</div>
                                        <div class="audit-table-date-time">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td>
                                        <div class="audit-table-user">{{ $log->user->name }}</div>
                                        <div class="audit-table-user-email">{{ $log->user->email }}</div>
                                    </td>
                                    <td>
                                        <span class="action-badge">
                                            {{ $log->getActionLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span title="{{ $log->description }}" class="audit-table-description">
                                            {{ $log->description }}
                                        </span>
                                    </td>
                                    <td>
                                        <code class="audit-table-ip">{{ $log->ip_address ?? 'N/A' }}</code>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.audit-logs.show', $log) }}" class="view-btn">
                                            <i class="fas fa-eye"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($logs->hasPages())
                        <div class="pagination-wrapper">
                            {{ $logs->links('pagination.custom') }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="empty-state-container">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5 class="empty-state-title">No audit logs found</h5>
                        <p class="empty-state-text">There are no logs matching your filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
