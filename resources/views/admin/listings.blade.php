@extends('layouts.app')

@section('title', 'Marketplace Listings Oversight - E-Benta Admin')

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
                            <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-boxes-stacked me-1"></i>Marketplace Inventory
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $listings->total() }} Total Devices</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Listings & Bulk Scrap Lots
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Monitor verified listings, bulk scrap declarations, asking prices, and handover preferences.
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
                <form method="GET" action="{{ route('admin.listings') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Status Filter</label>
                        <select name="status" class="form-select form-select-sm" style="border-radius: 0.6rem; font-weight: 600;">
                            <option value="">All Statuses</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="matched" {{ request('status') == 'matched' ? 'selected' : '' }}>Matched (Offer Accepted)</option>
                            <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Completed / Processed</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected / Withdrawn</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">Search by Title or Seller</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search device title, category, seller name..." value="{{ request('search') }}" style="border-radius: 0.6rem;">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-dark w-100 font-weight-bold" style="border-radius: 0.6rem; padding: 0.45rem;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.listings') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.6rem;">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- LISTINGS TABLE -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Device / Lot</th>
                                <th>Seller</th>
                                <th>Status</th>
                                <th>Handover Mode</th>
                                <th>Price</th>
                                <th>Active Offers</th>
                                <th>CO₂ Saved</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listings as $listing)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width: 36px; height: 36px; border-radius: 0.6rem; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                                                <i class="fas {{ $listing->is_bulk_lot ? 'fa-boxes-stacked' : 'fa-laptop' }}"></i>
                                            </div>
                                            <div>
                                                <strong style="color: #0f172a; font-size: 0.92rem; display: block;">
                                                    {{ $listing->title ?: ($listing->category ?: ($listing->deviceType ? $listing->deviceType->name : 'Item')) }}
                                                </strong>
                                                <small class="text-muted text-capitalize">{{ str_replace('_', ' ', $listing->condition) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="display: block; font-size: 0.88rem;">{{ $listing->seller?->name ?? 'Unknown' }}</strong>
                                        <small class="text-muted">{{ $listing->seller?->email }}</small>
                                    </td>
                                    <td>
                                        @if($listing->status === 'available')
                                            <span class="badge bg-success font-weight-bold">Available</span>
                                        @elseif($listing->status === 'matched')
                                            <span class="badge bg-info text-dark font-weight-bold">Matched</span>
                                        @elseif($listing->status === 'processed' || $listing->status === 'completed')
                                            <span class="badge bg-primary font-weight-bold">Completed</span>
                                        @else
                                            <span class="badge bg-secondary font-weight-bold">{{ ucfirst($listing->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($listing->handover_preference === 'pickup_only')
                                            <span class="badge" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 700; font-size: 0.75rem;">
                                                <i class="fas fa-truck-pickup me-1"></i>Doorstep Pickup
                                            </span>
                                        @elseif($listing->handover_preference === 'meetup_only')
                                            <span class="badge" style="background: rgba(59, 130, 246, 0.12); color: #2563eb; font-weight: 700; font-size: 0.75rem;">
                                                <i class="fas fa-handshake me-1"></i>Meetup Only
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #059669; font-weight: 700; font-size: 0.75rem;">
                                                <i class="fas fa-arrows-split-up-and-left me-1"></i>Flexible
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a; font-family: 'Outfit', sans-serif;">
                                            {{ $listing->suggested_price > 0 ? '₱' . number_format($listing->suggested_price, 2) : 'Free Recycled' }}
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark font-weight-bold">
                                            {{ $listing->offers()->count() }} {{ Str::plural('Bid', $listing->offers()->count()) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-success border font-weight-bold">
                                            <i class="fas fa-leaf me-1"></i>{{ $listing->carbon_footprint ?? 0 }} kg
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-outline-dark" target="_blank" style="font-weight: 700; border-radius: 0.5rem; font-size: 0.8rem; padding: 0.35rem 0.85rem;">
                                            <i class="fas fa-arrow-up-right-from-square me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        <strong>No listings found.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($listings->hasPages())
                    <div class="p-3 border-top">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
