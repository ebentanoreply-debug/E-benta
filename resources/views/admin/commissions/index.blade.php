@extends('layouts.app')

@section('title', 'Platform Revenue & Commissions - E-Benta')

@section('styles')
<style>
    .admin-commissions-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .admin-commissions-container {
        background: #09171f;
    }

    /* Executive Top Header */
    .admin-exec-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.5rem 0 2.25rem;
        position: relative;
        overflow: hidden;
    }

    .admin-exec-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .admin-kpi-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        padding: 1.6rem 1.4rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .admin-kpi-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .admin-kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.12);
        border-color: #0d9488;
    }

    .admin-kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .admin-kpi-val {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        font-family: 'Outfit', sans-serif;
        line-height: 1.1;
        margin: 0.4rem 0 0.25rem;
        word-break: break-word;
    }

    body.dark-mode .admin-kpi-val {
        color: #ffffff;
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

    .admin-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }

    body.dark-mode .admin-card-header {
        background: #0f232d;
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    .table th {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 0.85rem 1rem;
    }

    body.dark-mode .table th {
        background: #09171f;
        color: #94a3b8;
        border-bottom-color: rgba(13, 148, 136, 0.25);
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    body.dark-mode .table td {
        border-bottom-color: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }
</style>
@endsection

@section('content')

@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="admin-commissions-container">
        
        <!-- Header -->
        <div class="admin-exec-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-weight: 800; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.35rem 0.8rem; border-radius: 99px;">
                                <i class="fas fa-coins me-1"></i> PLATFORM MONETIZATION
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• Real-Time Treasury Ledger</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 900; letter-spacing: -0.5px; margin: 0;">
                            <i class="fas fa-hand-holding-dollar me-2" style="color: #10b981;"></i>Platform Revenue & Commissions
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Track marketplace commission earnings, configure rate policies, and monitor platform revenue.
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('admin.commissions.export', request()->query()) }}" class="btn fw-bold" style="background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 0.75rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35);">
                            <i class="fas fa-file-csv me-2"></i>Export CSV Ledger
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-3 px-md-4 mt-4">

            <!-- KPI Row -->
            <div class="row g-3 g-lg-4 mb-4">
                <!-- KPI 1: Total Platform Revenue -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL COMMISSIONS</small>
                                <div class="admin-kpi-val" style="color: #10b981;">
                                    ₱{{ number_format($stats['total_commission'], 2) }}
                                </div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700; color: #10b981;">
                            <i class="fas fa-calendar-check"></i>
                            <span>This Month: ₱{{ number_format($stats['month_commission'], 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 2: Gross Marketplace Volume -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">MARKETPLACE GMV</small>
                                <div class="admin-kpi-val">
                                    ₱{{ number_format($stats['total_gmv'], 2) }}
                                </div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(13, 148, 136, 0.12); color: #0d9488;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 600; color: #64748b;">
                            <i class="fas fa-receipt"></i>
                            <span>{{ number_format($stats['commission_count']) }} monetized orders</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 3: Current Commission Rate -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">ACTIVE COMMISSION RATE</small>
                                <div class="admin-kpi-val" style="color: #0d9488;">
                                    {{ number_format($currentRate, 2) }}%
                                </div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                                <i class="fas fa-percent"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700; color: {{ $cashCommissionEnabled ? '#10b981' : '#f59e0b' }};">
                            <i class="fas {{ $cashCommissionEnabled ? 'fa-check-circle' : 'fa-info-circle' }}"></i>
                            <span>Cash on Pickup: {{ $cashCommissionEnabled ? 'Commission Active' : 'Fee Waived' }}</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 4: Average Fee per Deal -->
                <div class="col-sm-6 col-lg-3">
                    <div class="admin-kpi-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <small style="color: #64748b; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">AVG COMMISSION / SALE</small>
                                <div class="admin-kpi-val">
                                    ₱{{ number_format($stats['avg_commission'], 2) }}
                                </div>
                            </div>
                            <div class="admin-kpi-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                                <i class="fas fa-scale-balanced"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 600; color: #64748b;">
                            <span>Online: <strong>₱{{ number_format($stats['paymongo_commission'], 2) }}</strong></span>
                            <span>• Cash: <strong>₱{{ number_format($stats['cash_commission'], 2) }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings & Filter Grid -->
            <div class="row g-4 mb-4">
                
                <!-- Commission Rate Settings Card -->
                <div class="col-lg-4">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">
                                <i class="fas fa-sliders me-2 text-success"></i>Commission Configuration
                            </h5>
                        </div>
                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.commissions.settings.update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">
                                        Commission Percentage (%) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" max="100" name="commission_rate_percent" class="form-control fw-bold" value="{{ old('commission_rate_percent', $currentRate) }}" required>
                                        <span class="input-group-text fw-bold">%</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        This percentage is retained by the platform on completed trades.
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">
                                        Cash on Pickup Policy <span class="text-danger">*</span>
                                    </label>
                                    <select name="cash_pickup_commission_enabled" class="form-select fw-bold">
                                        <option value="1" {{ $cashCommissionEnabled ? 'selected' : '' }}>
                                            Deduct from seller wallet upon cash confirmation
                                        </option>
                                        <option value="0" {{ !$cashCommissionEnabled ? 'selected' : '' }}>
                                            Waive commission for cash transactions (0% fee)
                                        </option>
                                    </select>
                                    <small class="text-muted d-block mt-1">
                                        Choose whether cash deals incur commission deducted from the seller's wallet balance.
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-success fw-bold w-100" style="padding: 0.75rem; border-radius: 0.75rem;">
                                    <i class="fas fa-floppy-disk me-2"></i>Save Commission Policy
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search Card -->
                <div class="col-lg-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">
                                <i class="fas fa-filter me-2 text-primary"></i>Filter Ledger
                            </h5>
                            @if(request()->anyFilled(['search', 'payment_method', 'status', 'date_from', 'date_to']))
                                <a href="{{ route('admin.commissions.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-rotate-left me-1"></i>Reset Filters
                                </a>
                            @endif
                        </div>
                        <div class="p-4">
                            <form method="GET" action="{{ route('admin.commissions.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Search User or Offer ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or offer ID..." value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Payment Method</label>
                                        <select name="payment_method" class="form-select">
                                            <option value="">All Methods</option>
                                            <option value="paymongo" {{ request('payment_method') === 'paymongo' ? 'selected' : '' }}>PayMongo (Online)</option>
                                            <option value="cash_pickup" {{ request('payment_method') === 'cash_pickup' ? 'selected' : '' }}>Cash on Pickup</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="collected" {{ request('status') === 'collected' ? 'selected' : '' }}>Collected</option>
                                            <option value="waived" {{ request('status') === 'waived' ? 'selected' : '' }}>Waived</option>
                                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Date From</label>
                                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Date To</label>
                                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary fw-bold px-4" style="border-radius: 0.6rem;">
                                            <i class="fas fa-magnifying-glass me-2"></i>Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Revenue Ledger Table -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <div>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">
                            <i class="fas fa-list-check me-2 text-success"></i>Revenue & Commission Ledger
                        </h5>
                        <small class="text-muted">Showing {{ $commissions->firstItem() ?? 0 }} - {{ $commissions->lastItem() ?? 0 }} of {{ $commissions->total() }} records</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Ledger ID</th>
                                <th>Offer / Item</th>
                                <th>Seller</th>
                                <th>Buyer</th>
                                <th>Gross Sale</th>
                                <th>Commission (Rate)</th>
                                <th>Seller Net Payout</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date Collected</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commissions as $comm)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-muted">#{{ $comm->id }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('offers.show', $comm->offer_id) }}" class="fw-bold text-decoration-none text-primary" target="_blank">
                                            Offer #{{ $comm->offer_id }}
                                        </a>
                                        <div class="small text-muted text-truncate" style="max-width: 180px;">
                                            {{ $comm->offer?->listing?->title ?? 'Listing' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $comm->seller?->name ?? 'Unknown Seller' }}</span>
                                        <div class="small text-muted">{{ $comm->seller?->email }}</div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $comm->buyer?->name ?? 'Unknown Buyer' }}</span>
                                        <div class="small text-muted">{{ $comm->buyer?->email }}</div>
                                    </td>
                                    <td>
                                        <strong>₱{{ number_format($comm->gross_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">+₱{{ number_format($comm->commission_amount, 2) }}</span>
                                        <span class="badge bg-light text-dark border ms-1">{{ number_format($comm->commission_rate, 1) }}%</span>
                                    </td>
                                    <td>
                                        <span class="text-primary fw-bold">₱{{ number_format($comm->seller_net_amount, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($comm->payment_method === 'paymongo')
                                            <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 700;">
                                                <i class="fas fa-credit-card me-1"></i>PayMongo
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 700;">
                                                <i class="fas fa-money-bill-wave me-1"></i>Cash
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3 py-1">
                                            {{ ucfirst($comm->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $comm->collected_at ? $comm->collected_at->format('M d, Y h:i A') : $comm->created_at->format('M d, Y h:i A') }}
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div style="max-width: 320px; margin: 0 auto;">
                                            <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">No Commission Records Yet</h6>
                                            <p class="text-muted small mb-0">
                                                Commissions will be automatically recorded and displayed here as accepted offers are completed and paid.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($commissions->hasPages())
                    <div class="p-3 border-top">
                        {{ $commissions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
