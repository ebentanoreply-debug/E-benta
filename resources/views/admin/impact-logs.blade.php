@extends('layouts.app')

@section('title', 'Impact Logs & Environmental Certification - E-Benta Admin')

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
                            <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-leaf me-1"></i>Zero-Landfill Ledger
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $logs->total() }} Impact Records</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Environmental Impact Logs
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Audited ledger of CO₂ emissions prevented, e-waste diverted, and material recovery breakdown.
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
                <form method="GET" action="{{ route('admin.impact-logs') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Status Filter</label>
                        <select name="status" class="form-select form-select-sm" style="border-radius: 0.6rem; font-weight: 600;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Certification</option>
                            <option value="certified" {{ request('status') == 'certified' ? 'selected' : '' }}>Certified Zero-Landfill</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Search Category or Parties</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search device category, seller, or buyer..." value="{{ request('search') }}" style="border-radius: 0.6rem;">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark w-100 font-weight-bold" style="border-radius: 0.6rem; padding: 0.45rem;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.impact-logs') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem;">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- IMPACT TABLE -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Device Category</th>
                                <th>Seller</th>
                                <th>Certified Buyer</th>
                                <th>CO₂ Offset</th>
                                <th>Diverted Weight</th>
                                <th>Materials Recovered</th>
                                <th>Status</th>
                                <th>Certified Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width: 34px; height: 34px; border-radius: 0.5rem; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                                                <i class="fas fa-recycle"></i>
                                            </div>
                                            <div>
                                                <strong style="color: #0f172a; font-size: 0.92rem; display: block;">
                                                    {{ $log->device_category ?: 'Electronics' }}
                                                </strong>
                                                <small class="text-muted">{{ $log->device_weight }} kg item</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $log->seller?->name ?? 'N/A' }}</strong>
                                        <small class="text-muted">{{ $log->seller?->email }}</small>
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $log->buyer?->name ?? 'N/A' }}</strong>
                                        <small class="text-muted">{{ $log->buyer?->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success font-weight-bold" style="font-size: 0.82rem;">
                                            <i class="fas fa-leaf me-1"></i>{{ number_format($log->co2_saved, 2) }} kg
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a;">{{ number_format($log->landfill_diverted_weight, 2) }} kg</strong>
                                    </td>
                                    <td>
                                        @php
                                            $hasRecovered = ($log->gold_recovered > 0) || ($log->copper_recovered > 0) || ($log->plastic_recovered > 0) || ($log->aluminum_recovered > 0);
                                        @endphp
                                        @if($hasRecovered)
                                            <div class="d-flex flex-wrap gap-1" style="font-size: 0.72rem;">
                                                @if($log->gold_recovered > 0)
                                                    <span class="badge bg-warning text-dark">Au: {{ $log->gold_recovered }}g</span>
                                                @endif
                                                @if($log->copper_recovered > 0)
                                                    <span class="badge bg-danger text-white">Cu: {{ $log->copper_recovered }}g</span>
                                                @endif
                                                @if($log->plastic_recovered > 0)
                                                    <span class="badge bg-info text-dark">Plastic: {{ $log->plastic_recovered }}g</span>
                                                @endif
                                                @if($log->aluminum_recovered > 0)
                                                    <span class="badge bg-secondary text-white">Al: {{ $log->aluminum_recovered }}g</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem; font-style: italic;">Standard Processing</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->status === 'certified')
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; border-radius: 2rem; padding: 0.35rem 0.75rem;">
                                                <i class="fas fa-certificate me-1"></i>Certified
                                            </span>
                                        @elseif($log->status === 'completed')
                                            <span class="badge bg-success font-weight-bold">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark font-weight-bold">Pending</span>
                                        @endif
                                    </td>
                                    <td style="color: #64748b; font-size: 0.82rem;">
                                        {{ $log->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-leaf fa-2x mb-2 d-block text-success"></i>
                                        <strong>No environmental impact logs found.</strong>
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
