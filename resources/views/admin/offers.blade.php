@extends('layouts.app')

@section('title', 'Offers & Transactions Oversight - E-Benta Admin')

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
                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-handshake me-1"></i>Trade Oversight
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $offers->total() }} Total Bids & Trades</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Offers & Transactions
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Track buyer bids, accepted handovers, doorstep pickup collections, and completion status.
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
                <form method="GET" action="{{ route('admin.offers') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Status Filter</label>
                        <select name="status" class="form-select form-select-sm" style="border-radius: 0.6rem; font-weight: 600;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Response</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted / Scheduled</option>
                            <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed Handover</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Search Parties or Items</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search buyer, seller, or listing title..." value="{{ request('search') }}" style="border-radius: 0.6rem;">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark w-100 font-weight-bold" style="border-radius: 0.6rem; padding: 0.45rem;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.offers') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem;">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- OFFERS TABLE -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Target Device</th>
                                <th>Buyer / Recycler</th>
                                <th>Seller</th>
                                <th>Bid Amount</th>
                                <th>Handover Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width: 34px; height: 34px; border-radius: 0.5rem; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                                                <i class="fas fa-microchip"></i>
                                            </div>
                                            <div>
                                                <strong style="color: #0f172a; font-size: 0.92rem; display: block;">
                                                    {{ $offer->listing?->category ?: ($offer->listing?->deviceType ? $offer->listing?->deviceType->name : 'Listing') }}
                                                </strong>
                                                <small class="text-muted">{{ $offer->listing?->title }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $offer->buyer?->name ?? 'Deleted' }}</strong>
                                        <small class="text-muted">{{ $offer->buyer?->email }}</small>
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $offer->listing?->seller?->name ?? 'Deleted' }}</strong>
                                        <small class="text-muted">{{ $offer->listing?->seller?->email }}</small>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a; font-family: 'Outfit', sans-serif; font-size: 0.95rem;">
                                            ₱{{ number_format($offer->bid_amount, 2) }}
                                        </strong>
                                    </td>
                                    <td>
                                        @if($offer->handover_method === 'doorstep_pickup')
                                            <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 700; font-size: 0.75rem;">
                                                <i class="fas fa-truck-pickup me-1"></i>Doorstep
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(59, 130, 246, 0.12); color: #2563eb; font-weight: 700; font-size: 0.75rem;">
                                                <i class="fas fa-handshake me-1"></i>Meetup
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offer->status === 'pending')
                                            <span class="badge bg-warning text-dark font-weight-bold">Pending</span>
                                        @elseif($offer->status === 'accepted')
                                            <span class="badge bg-info text-dark font-weight-bold">Accepted</span>
                                        @elseif($offer->status === 'completed' || $offer->status === 'picked_up')
                                            <span class="badge bg-success font-weight-bold">Completed</span>
                                        @elseif($offer->status === 'rejected')
                                            <span class="badge bg-danger font-weight-bold">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary font-weight-bold">{{ ucfirst(str_replace('_', ' ', $offer->status)) }}</span>
                                        @endif
                                    </td>
                                    <td style="color: #64748b; font-size: 0.82rem;">
                                        {{ $offer->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-handshake fa-2x mb-2 d-block"></i>
                                        <strong>No offers logged in the system.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($offers->hasPages())
                    <div class="p-3 border-top">
                        {{ $offers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
