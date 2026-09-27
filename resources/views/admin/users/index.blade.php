@extends('layouts.admin')

@section('title', 'User & Account Management - E-Benta Admin')

@section('styles')
<style>
    .admin-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    .admin-module-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
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
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(20, 184, 166, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }

    .stat-metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(13, 148, 136, 0.1);
        border-color: #0d9488;
    }

    .stat-metric-card .stat-icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
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

    .admin-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #334155;
    }

    .admin-table tbody tr:hover {
        background: rgba(13, 148, 136, 0.025);
    }

    .user-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        color: #ffffff;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .badge-role-buyer {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.25);
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.65rem;
        border-radius: 0.5rem;
    }

    .badge-role-seller {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.25);
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.65rem;
        border-radius: 0.5rem;
    }

    .badge-role-admin {
        background: rgba(139, 92, 246, 0.1);
        color: #7c3aed;
        border: 1px solid rgba(139, 92, 246, 0.25);
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.65rem;
        border-radius: 0.5rem;
    }

    .badge-verified {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .badge-pending {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .badge-unverified {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .badge-banned {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-weight: 800;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .badge-suspended {
        background: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
        font-weight: 800;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .badge-active {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.3rem 0.6rem;
        border-radius: 0.5rem;
    }

    .filter-input-control {
        border-radius: 0.65rem;
        border: 1px solid #cbd5e1;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.55rem 0.85rem;
        transition: all 0.2s ease;
    }

    .filter-input-control:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }
</style>
@endsection

@section('content')
<div class="admin-page-container">

    <!-- HERO HEADER -->
    <div class="admin-module-header">
        <div class="container-fluid px-3 px-md-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background: rgba(20, 184, 166, 0.2); color: #5eead4; border: 1px solid rgba(20, 184, 166, 0.4); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                            <i class="fas fa-users-gear me-1"></i>Directory & Permissions
                        </span>
                        <span style="color: #cbd5e1; font-size: 0.85rem;">• {{ number_format($stats['total']) }} Registered Accounts</span>
                    </div>
                    <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                        User & Account Management
                    </h1>
                    <p style="color: #ccfbf1; font-size: 0.95rem; margin: 0.35rem 0 0;">
                        Inspect user profiles, verify KYC credentials, manage account status, and enforce platform trust.
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.pending-verifications') }}" class="btn btn-warning d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);">
                        <i class="fas fa-id-card-clip"></i>
                        <span>Pending Verifications ({{ $stats['pending'] }})</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.25);">
                        <i class="fas fa-arrow-left"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- METRICS OVERVIEW CARDS -->
    <div class="container-fluid px-3 px-md-4 mt-4">
        <div class="row g-3">
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-metric-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Total Users</span>
                        <div class="stat-icon-wrap" style="background: #f0fdfa; color: #0d9488;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.65rem; font-weight: 900; color: #0f172a; line-height: 1;">
                        {{ number_format($stats['total']) }}
                    </div>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">All platform participants</span>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-metric-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Recycler Buyers</span>
                        <div class="stat-icon-wrap" style="background: #eff6ff; color: #2563eb;">
                            <i class="fas fa-cart-shopping"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.65rem; font-weight: 900; color: #1e3a8a; line-height: 1;">
                        {{ number_format($stats['buyers']) }}
                    </div>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">E-waste buyers & recyclers</span>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-metric-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Sellers & Shops</span>
                        <div class="stat-icon-wrap" style="background: #ecfdf5; color: #059669;">
                            <i class="fas fa-store"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.65rem; font-weight: 900; color: #065f46; line-height: 1;">
                        {{ number_format($stats['sellers']) }}
                    </div>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Merchants & scrap dealers</span>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-metric-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Verified KYC</span>
                        <div class="stat-icon-wrap" style="background: #ecfdf5; color: #10b981;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.65rem; font-weight: 900; color: #047857; line-height: 1;">
                        {{ number_format($stats['verified']) }}
                    </div>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">PhilSys / ID validated</span>
                </div>
            </div>

            <div class="col-12 col-md-4 col-xl">
                <div class="stat-metric-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Restricted</span>
                        <div class="stat-icon-wrap" style="background: #fef2f2; color: #dc2626;">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.65rem; font-weight: 900; color: #991b1b; line-height: 1;">
                        {{ number_format($stats['restricted']) }}
                    </div>
                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Suspended or banned</span>
                </div>
            </div>
        </div>

        <!-- SEARCH & FILTER TOOLBAR -->
        <div class="admin-card my-4 p-3 p-md-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label font-weight-bold" style="font-size: 0.78rem; text-transform: uppercase; color: #64748b;">Search Query</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 0.65rem 0 0 0.65rem; border-color: #cbd5e1; color: #94a3b8;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="q" value="{{ $search }}" class="form-control border-start-0 filter-input-control" style="border-radius: 0 0.65rem 0.65rem 0;" placeholder="Name, email, phone, city, ID...">
                    </div>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label font-weight-bold" style="font-size: 0.78rem; text-transform: uppercase; color: #64748b;">Role</label>
                    <select name="role" class="form-select filter-input-control">
                        <option value="">All Roles</option>
                        <option value="buyer" {{ $role === 'buyer' ? 'selected' : '' }}>Buyer / Recycler</option>
                        <option value="seller" {{ $role === 'seller' ? 'selected' : '' }}>Seller</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label font-weight-bold" style="font-size: 0.78rem; text-transform: uppercase; color: #64748b;">Verification</label>
                    <select name="verification" class="form-select filter-input-control">
                        <option value="">All KYC Status</option>
                        <option value="verified" {{ $verification === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="pending" {{ $verification === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="unverified" {{ $verification === 'unverified' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label font-weight-bold" style="font-size: 0.78rem; text-transform: uppercase; color: #64748b;">Account Standing</label>
                    <select name="status" class="form-select filter-input-control">
                        <option value="">All Standing</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="suspended" {{ $status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="banned" {{ $status === 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label font-weight-bold" style="font-size: 0.78rem; text-transform: uppercase; color: #64748b;">Sort Order</label>
                    <select name="sort" class="form-select filter-input-control">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest Registered</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest Registered</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name (A - Z)</option>
                        <option value="impact" {{ $sort === 'impact' ? 'selected' : '' }}>Highest Impact Score</option>
                        <option value="weight" {{ $sort === 'weight' ? 'selected' : '' }}>Most Waste Diverted</option>
                    </select>
                </div>

                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-teal w-100" style="background: #0d9488; color: #ffffff; border-radius: 0.65rem; font-weight: 700; padding: 0.55rem 0.5rem;" title="Apply Filter">
                        <i class="fas fa-filter"></i>
                    </button>
                    @if($search || $role || $verification || $status || $sort !== 'latest')
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light" style="border: 1px solid #cbd5e1; border-radius: 0.65rem; color: #64748b;" title="Reset filters">
                            <i class="fas fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- USERS TABLE CARD -->
        <div class="admin-card">
            <div class="p-3 p-md-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #ffffff;">
                <div class="d-flex align-items-center gap-2">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        User Accounts
                    </h3>
                    <span class="badge rounded-pill bg-light text-dark border px-2 py-1" style="font-weight: 700;">
                        Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                    </span>
                </div>
                <div class="text-muted" style="font-size: 0.82rem;">
                    <i class="fas fa-info-circle me-1 text-teal" style="color: #0d9488;"></i> Click <strong style="color: #0f172a;">Details</strong> to view full address, KYC credentials, and metrics.
                </div>
            </div>

            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>User Profile</th>
                            <th>Role</th>
                            <th>Location</th>
                            <th>KYC / Identity</th>
                            <th>Account Standing</th>
                            <th>Eco Metrics</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $initials = collect(explode(' ', $user->name))->map(fn($segment) => strtoupper(substr($segment, 0, 1)))->take(2)->join('');
                                $avatarGradients = [
                                    'linear-gradient(135deg, #0d9488, #10b981)',
                                    'linear-gradient(135deg, #2563eb, #3b82f6)',
                                    'linear-gradient(135deg, #7c3aed, #a855f7)',
                                    'linear-gradient(135deg, #d97706, #f59e0b)',
                                    'linear-gradient(135deg, #0891b2, #06b6d4)',
                                ];
                                $bgGrad = $avatarGradients[$user->id % count($avatarGradients)];
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="user-avatar-circle" style="object-fit: cover; border: 2px solid #e2e8f0;">
                                        @else
                                            <div class="user-avatar-circle" style="background: {{ $bgGrad }}; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                                {{ $initials ?: 'U' }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="d-flex align-items-center gap-1">
                                                <strong style="color: #0f172a; font-size: 0.95rem;">{{ $user->name }}</strong>
                                                @if($user->id === Auth::id())
                                                    <span class="badge bg-secondary" style="font-size: 0.62rem; padding: 0.15rem 0.4rem;">YOU</span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.8rem; color: #64748b;">
                                                <span><i class="far fa-envelope me-1"></i>{{ $user->email }}</span>
                                                @if($user->phone)
                                                    <span>• <i class="fas fa-phone me-1"></i>{{ $user->phone }}</span>
                                                @endif
                                            </div>
                                            @if($user->business_name)
                                                <div style="font-size: 0.75rem; color: #0d9488; font-weight: 600;">
                                                    <i class="fas fa-briefcase me-1"></i>{{ $user->business_name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge-role-admin">
                                            <i class="fas fa-shield-halved me-1"></i>Admin
                                        </span>
                                    @elseif($user->role === 'seller')
                                        <span class="badge-role-seller">
                                            <i class="fas fa-store me-1"></i>Seller
                                        </span>
                                    @else
                                        <span class="badge-role-buyer">
                                            <i class="fas fa-cart-shopping me-1"></i>Buyer
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->address_city || $user->address_province)
                                        <div style="font-weight: 600; font-size: 0.85rem; color: #1e293b;">
                                            <i class="fas fa-location-dot me-1 text-danger" style="font-size: 0.8rem;"></i>
                                            {{ $user->address_city ?? '' }}{{ $user->address_city && $user->address_province ? ', ' : '' }}{{ $user->address_province ?? '' }}
                                        </div>
                                        @if($user->barangay)
                                            <div style="font-size: 0.75rem; color: #94a3b8;">
                                                {{ \Illuminate\Support\Str::startsWith(trim($user->barangay), 'Brgy.') ? $user->barangay : 'Brgy. ' . $user->barangay }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size: 0.8rem;">Not specified</span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->is_verified)
                                        <span class="badge-verified d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-circle-check text-success"></i>
                                            <span>Verified</span>
                                        </span>
                                        @if($user->id_type)
                                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.2rem;">
                                                {{ $user->id_type }}
                                            </div>
                                        @endif
                                    @elseif($user->id_verification_status === 'pending')
                                        <a href="{{ route('admin.pending-verifications') }}" class="badge-pending text-decoration-none d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            <span>Pending Review</span>
                                        </a>
                                        @if($user->id_type)
                                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.2rem;">
                                                {{ $user->id_type }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge-unverified d-inline-flex align-items-center gap-1">
                                            <i class="far fa-circle text-muted"></i>
                                            <span>Unverified</span>
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->is_banned)
                                        <span class="badge-banned">
                                            <i class="fas fa-ban me-1"></i>Banned
                                        </span>
                                    @elseif($user->is_suspended)
                                        <span class="badge-suspended">
                                            <i class="fas fa-triangle-exclamation me-1"></i>Suspended
                                            @if($user->suspended_until)
                                                <small class="d-block" style="font-size: 0.68rem; font-weight: normal;">Until {{ $user->suspended_until->format('M d, Y') }}</small>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-active">
                                            <i class="fas fa-circle-check me-1"></i>Active
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div style="font-size: 0.82rem; font-weight: 700; color: #047857;">
                                        <i class="fas fa-recycle me-1"></i>{{ number_format((float) $user->total_weight_diverted, 1) }} kg diverted
                                    </div>
                                    <div style="font-size: 0.75rem; color: #64748b;">
                                        <i class="fas fa-leaf me-1 text-success"></i>{{ number_format((float) $user->total_co2_saved, 1) }} kg CO2 • {{ $user->total_impact_score ?? 0 }} pts
                                    </div>
                                </td>

                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700;">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 0.75rem; font-size: 0.85rem; border-color: #e2e8f0; min-width: 200px;">
                                            <li>
                                                <button type="button" class="dropdown-item py-2 view-user-btn"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-email="{{ $user->email }}"
                                                    data-phone="{{ $user->phone ?? 'Not provided' }}"
                                                    data-role="{{ strtoupper($user->role) }}"
                                                    data-business="{{ $user->business_name ?? 'None' }}"
                                                    data-business-desc="{{ $user->business_description ?? 'None' }}"
                                                    data-address="{{ trim(($user->address_line_1 ? $user->address_line_1 . ', ' : '') . ($user->barangay ? (\Illuminate\Support\Str::startsWith(trim($user->barangay), 'Brgy.') ? $user->barangay : 'Brgy. ' . $user->barangay) . ', ' : '') . ($user->address_city ? $user->address_city . ', ' : '') . ($user->address_province ? $user->address_province : '') . ($user->postal_code ? ' ' . $user->postal_code : '')) ?: 'No address specified' }}"
                                                    data-id-type="{{ $user->id_type ?? 'Not submitted' }}"
                                                    data-id-number="{{ $user->id_number ?? 'Not submitted' }}"
                                                    data-id-status="{{ ucfirst($user->id_verification_status ?? 'Unsubmitted') }}"
                                                    data-is-verified="{{ $user->is_verified ? 'Yes' : 'No' }}"
                                                    data-weight="{{ number_format((float) $user->total_weight_diverted, 2) }} kg"
                                                    data-co2="{{ number_format((float) $user->total_co2_saved, 2) }} kg"
                                                    data-score="{{ $user->total_impact_score ?? 0 }}"
                                                    data-status="{{ $user->is_banned ? 'Banned' : ($user->is_suspended ? 'Suspended' : 'Active') }}"
                                                    data-joined="{{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'Unknown' }}"
                                                    data-email-verified="{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Unverified' }}"
                                                    data-avatar="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}"
                                                    data-initials="{{ $initials ?: 'U' }}"
                                                    data-bg="{{ $bgGrad }}">
                                                    <i class="fas fa-eye text-primary me-2"></i>Full Details
                                                </button>
                                            </li>

                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('users.show', $user) }}" target="_blank">
                                                    <i class="fas fa-arrow-up-right-from-square text-secondary me-2"></i>Public Profile
                                                </a>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            <!-- Toggle Verification Status -->
                                            <li>
                                                <form action="{{ route('admin.users.toggle-verification', $user) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-2 text-{{ $user->is_verified ? 'secondary' : 'teal' }}" style="{{ !$user->is_verified ? 'color: #0d9488;' : '' }}">
                                                        <i class="fas fa-{{ $user->is_verified ? 'times-circle text-muted' : 'check-circle text-success' }} me-2"></i>
                                                        {{ $user->is_verified ? 'Revoke Verification' : 'Mark as Verified' }}
                                                    </button>
                                                </form>
                                            </li>

                                            @if($user->id !== Auth::id())
                                                <!-- Standing / Restriction Controls -->
                                                @if($user->is_banned)
                                                    <li>
                                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="m-0">
                                                            @csrf
                                                            <input type="hidden" name="action" value="unban">
                                                            <button type="submit" class="dropdown-item py-2 text-success">
                                                                <i class="fas fa-user-check me-2"></i>Lift Ban (Restore)
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    @if($user->is_suspended)
                                                        <li>
                                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="m-0">
                                                                @csrf
                                                                <input type="hidden" name="action" value="unsuspend">
                                                                <button type="submit" class="dropdown-item py-2 text-success">
                                                                    <i class="fas fa-circle-check me-2"></i>Lift Suspension
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button type="button" class="dropdown-item py-2 text-warning action-suspend-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                                <i class="fas fa-clock me-2"></i>Suspend (7 Days)
                                                            </button>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <button type="button" class="dropdown-item py-2 text-danger action-ban-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                            <i class="fas fa-ban me-2"></i>Ban Permanently
                                                        </button>
                                                    </li>
                                                @endif

                                                <li><hr class="dropdown-divider"></li>

                                                <!-- Delete Account -->
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 text-danger action-delete-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                                                        <i class="fas fa-trash-can me-2"></i>Delete User Account
                                                    </button>
                                                </li>
                                            @else
                                                <li>
                                                    <span class="dropdown-item disabled text-muted py-2" style="font-size: 0.8rem;">
                                                        <i class="fas fa-lock me-2"></i>Your Account (Protected)
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 0.75rem;">
                                        <i class="fas fa-users-slash"></i>
                                    </div>
                                    <h5 style="font-weight: 800; color: #334155; margin-bottom: 0.35rem;">No user accounts found</h5>
                                    <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0 auto 1.25rem;">
                                        Try adjusting your search query, clearing filters, or seeding initial users to inspect.
                                    </p>
                                    @if($search || $role || $verification || $status || $sort !== 'latest')
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-teal btn-sm" style="border-radius: 0.5rem; font-weight: 700; color: #0d9488; border-color: #0d9488;">
                                            Reset Filter Criteria
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            @if($users->hasPages())
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div style="font-size: 0.85rem; color: #64748b;">
                        Showing page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. FULL USER DETAILS MODAL -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 1.25rem; border: none; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18); overflow: hidden;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); border: none; padding: 1.5rem 1.75rem;">
                <div class="d-flex align-items-center gap-3">
                    <div id="modalUserAvatarWrap">
                        <!-- Populated via JS -->
                    </div>
                    <div>
                        <h4 class="modal-title font-weight-bold mb-1" id="modalUserName" style="font-weight: 800; letter-spacing: -0.3px;">User Profile</h4>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge" id="modalUserRole" style="background: rgba(255,255,255,0.25); color: #ffffff; font-weight: 700;">ROLE</span>
                            <span class="badge" id="modalUserStanding" style="background: rgba(255,255,255,0.2); color: #ffffff;">STANDING</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background: #ffffff; font-size: 0.9rem;">
                <!-- Contact & Account Overview -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="text-muted font-weight-bold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Contact Information</div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-envelope text-teal" style="color: #0d9488; width: 16px;"></i>
                                <span id="modalUserEmail" class="font-weight-bold" style="color: #0f172a;">-</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-phone text-teal" style="color: #0d9488; width: 16px;"></i>
                                <span id="modalUserPhone" style="color: #334155;">-</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-double text-teal" style="color: #0d9488; width: 16px;"></i>
                                <span style="font-size: 0.8rem; color: #64748b;">Email Verified: <strong id="modalEmailVerified">-</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="text-muted font-weight-bold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Registered Address</div>
                            <div class="d-flex align-items-start gap-2">
                                <i class="fas fa-location-dot text-danger mt-1" style="width: 16px;"></i>
                                <span id="modalUserAddress" style="color: #334155; line-height: 1.4;">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Info (for sellers) -->
                <div id="modalBusinessWrap" class="mb-4 p-3 rounded-3" style="background: #f0fdfa; border: 1px solid #ccfbf1; display: none;">
                    <div class="text-teal font-weight-bold mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #0f766e;">Merchant / Business Profile</div>
                    <div class="font-weight-bold mb-1" id="modalBusinessName" style="color: #0f172a; font-size: 1rem;">-</div>
                    <div class="text-muted" id="modalBusinessDesc" style="font-size: 0.85rem;">-</div>
                </div>

                <!-- KYC & Identity Credentials -->
                <div class="mb-4 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="text-muted font-weight-bold mb-2" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Identity & KYC Records</div>
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <span class="text-muted d-block" style="font-size: 0.75rem;">Document Type</span>
                            <strong id="modalIdType" style="color: #0f172a;">-</strong>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block" style="font-size: 0.75rem;">ID Number</span>
                            <code id="modalIdNumber" style="font-size: 0.85rem; color: #0f766e;">-</code>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block" style="font-size: 0.75rem;">KYC Status</span>
                            <span id="modalIdStatus" class="font-weight-bold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact Counters -->
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background: #ecfdf5; border: 1px solid #a7f3d0;">
                            <div class="text-success font-weight-bold" style="font-size: 1.1rem;" id="modalWeightDiverted">0 kg</div>
                            <span style="font-size: 0.72rem; color: #047857; text-transform: uppercase; font-weight: 700;">Landfill Diverted</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <div class="text-success font-weight-bold" style="font-size: 1.1rem;" id="modalCo2Saved">0 kg</div>
                            <span style="font-size: 0.72rem; color: #16a34a; text-transform: uppercase; font-weight: 700;">CO2 Mitigated</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background: #f0fdfa; border: 1px solid #99f6e4;">
                            <div class="text-teal font-weight-bold" style="font-size: 1.1rem; color: #0d9488;" id="modalImpactScore">0</div>
                            <span style="font-size: 0.72rem; color: #0f766e; text-transform: uppercase; font-weight: 700;">Impact Score</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-muted text-center" style="font-size: 0.78rem;">
                    Account created on <strong id="modalJoinedDate">-</strong>
                </div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 0.65rem; font-weight: 600;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. SUSPENSION REASON MODAL -->
<div class="modal fade" id="suspendUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="suspendUserForm" class="modal-content" style="border-radius: 1.25rem; border: none; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);">
            @csrf
            <input type="hidden" name="action" value="suspend">
            <div class="modal-header" style="border-bottom: 1px solid #fed7aa; background: #fff7ed; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title font-weight-bold text-warning" style="font-weight: 800; color: #c2410c !important;">
                    <i class="fas fa-triangle-exclamation me-2"></i>Suspend User Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p style="color: #334155; font-size: 0.95rem;">
                    Are you sure you want to suspend <strong id="suspendUserName">-</strong> for <strong>7 days</strong>? The user will be unable to list items, place bids, or negotiate.
                </p>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase; color: #64748b;">Administrative Reason (Optional)</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="e.g. Failure to comply with e-waste handover policy, spam reports..." style="border-radius: 0.65rem; font-size: 0.88rem;"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 0.9rem 1.5rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 0.65rem; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn btn-warning" style="border-radius: 0.65rem; font-weight: 700; color: #7c2d12;">Confirm 7-Day Suspension</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. BAN CONFIRMATION MODAL -->
<div class="modal fade" id="banUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="banUserForm" class="modal-content" style="border-radius: 1.25rem; border: none; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);">
            @csrf
            <input type="hidden" name="action" value="ban">
            <div class="modal-header" style="border-bottom: 1px solid #fecaca; background: #fef2f2; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title font-weight-bold text-danger" style="font-weight: 800;">
                    <i class="fas fa-ban me-2"></i>Permanently Ban User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p style="color: #334155; font-size: 0.95rem;">
                    You are about to permanently ban <strong id="banUserName">-</strong> from E-Benta. They will be immediately blocked from logging in.
                </p>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase; color: #64748b;">Ban Reason / Compliance Violation</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="e.g. Fraudulent scrap declaration, repeated abuse, severe terms violation..." style="border-radius: 0.65rem; font-size: 0.88rem;"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 0.9rem 1.5rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 0.65rem; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn btn-danger" style="border-radius: 0.65rem; font-weight: 700;">Confirm Permanent Ban</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. DELETE ACCOUNT CONFIRMATION MODAL -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="deleteUserForm" class="modal-content" style="border-radius: 1.25rem; border: none; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);">
            @csrf
            @method('DELETE')
            <div class="modal-header" style="border-bottom: 1px solid #fecaca; background: #fef2f2; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title font-weight-bold text-danger" style="font-weight: 800;">
                    <i class="fas fa-trash-can me-2"></i>Delete User Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p style="color: #334155; font-size: 0.95rem;">
                    Are you certain you wish to completely delete the account for <strong id="deleteUserName">-</strong> (<span id="deleteUserEmail">-</span>)?
                </p>
                <div class="alert alert-danger" style="border-radius: 0.75rem; font-size: 0.85rem; margin-bottom: 0;">
                    <i class="fas fa-triangle-exclamation me-1"></i>
                    <strong>Irreversible action:</strong> This will cascade delete or orphan linked records. This action is permanently recorded in the system audit log.
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 0.9rem 1.5rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 0.65rem; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn btn-danger" style="border-radius: 0.65rem; font-weight: 700;">Yes, Delete Account</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Details Modal Trigger
    const viewButtons = document.querySelectorAll('.view-user-btn');
    const userModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('modalUserName').textContent = this.dataset.name;
            document.getElementById('modalUserEmail').textContent = this.dataset.email;
            document.getElementById('modalUserPhone').textContent = this.dataset.phone;
            document.getElementById('modalUserRole').textContent = this.dataset.role;
            document.getElementById('modalUserStanding').textContent = this.dataset.status;
            document.getElementById('modalEmailVerified').textContent = this.dataset.emailVerified;
            document.getElementById('modalUserAddress').textContent = this.dataset.address;
            document.getElementById('modalIdType').textContent = this.dataset.idType;
            document.getElementById('modalIdNumber').textContent = this.dataset.idNumber;
            document.getElementById('modalIdStatus').textContent = this.dataset.idStatus;
            document.getElementById('modalWeightDiverted').textContent = this.dataset.weight;
            document.getElementById('modalCo2Saved').textContent = this.dataset.co2;
            document.getElementById('modalImpactScore').textContent = this.dataset.score;
            document.getElementById('modalJoinedDate').textContent = this.dataset.joined;

            // Avatar setup
            const avatarWrap = document.getElementById('modalUserAvatarWrap');
            if (this.dataset.avatar) {
                avatarWrap.innerHTML = `<img src="${this.dataset.avatar}" alt="${this.dataset.name}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.7);">`;
            } else {
                avatarWrap.innerHTML = `<div style="width: 48px; height: 48px; border-radius: 50%; background: ${this.dataset.bg}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; border: 2px solid rgba(255,255,255,0.7);">${this.dataset.initials}</div>`;
            }

            // Business info for sellers
            const bWrap = document.getElementById('modalBusinessWrap');
            if (this.dataset.business && this.dataset.business !== 'None') {
                bWrap.style.display = 'block';
                document.getElementById('modalBusinessName').textContent = this.dataset.business;
                document.getElementById('modalBusinessDesc').textContent = this.dataset.businessDesc;
            } else {
                bWrap.style.display = 'none';
            }

            userModal.show();
        });
    });

    // 2. Suspend Modal Trigger
    const suspendButtons = document.querySelectorAll('.action-suspend-btn');
    const suspendModal = new bootstrap.Modal(document.getElementById('suspendUserModal'));
    const suspendForm = document.getElementById('suspendUserForm');
    const suspendNameSpan = document.getElementById('suspendUserName');

    suspendButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const userId = this.dataset.id;
            suspendNameSpan.textContent = this.dataset.name;
            suspendForm.action = `/admin/users/${userId}/toggle-status`;
            suspendModal.show();
        });
    });

    // 3. Ban Modal Trigger
    const banButtons = document.querySelectorAll('.action-ban-btn');
    const banModal = new bootstrap.Modal(document.getElementById('banUserModal'));
    const banForm = document.getElementById('banUserForm');
    const banNameSpan = document.getElementById('banUserName');

    banButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const userId = this.dataset.id;
            banNameSpan.textContent = this.dataset.name;
            banForm.action = `/admin/users/${userId}/toggle-status`;
            banModal.show();
        });
    });

    // 4. Delete Modal Trigger
    const deleteButtons = document.querySelectorAll('.action-delete-btn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
    const deleteForm = document.getElementById('deleteUserForm');
    const deleteNameSpan = document.getElementById('deleteUserName');
    const deleteEmailSpan = document.getElementById('deleteUserEmail');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const userId = this.dataset.id;
            deleteNameSpan.textContent = this.dataset.name;
            deleteEmailSpan.textContent = this.dataset.email;
            deleteForm.action = `/admin/users/${userId}`;
            deleteModal.show();
        });
    });
});
</script>
@endsection
