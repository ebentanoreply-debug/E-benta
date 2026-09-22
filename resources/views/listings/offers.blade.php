@extends('layouts.seller')

@section('title', 'Offers for Listing - E-Benta')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid #0d9488; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: #f0fdfa; padding: 0.75rem 1rem; border-radius: 0.8rem; border: 1px solid #ccfbf1;">
                <i class="fas fa-handshake" style="color: #0d9488; font-size: 1.8rem;"></i>
            </div>
            <div>
                <h1 style="color: #0f172a; font-weight: 800; margin: 0; font-size: 2rem; letter-spacing: -0.5px;">
                    Offers for: <span style="color: #0d9488;">{{ $listing->category ?: ($listing->deviceType->name ?: 'Device') }}</span>
                </h1>
                <p style="color: #64748b; margin: 0; font-size: 0.95rem; font-weight: 500;">
                    Review and manage all offers for this listing
                </p>
            </div>
        </div>
    </div>

    <!-- Listing Details Card -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
        <h4 style="color: #0f172a; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-box-open" style="color: #0d9488;"></i>
            Listing Details
        </h4>
        <div style="display: flex; flex-wrap: wrap; gap: 2.5rem;">
            <div>
                <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Condition</small>
                <span style="background: #f0fdfa; color: #0f766e; font-weight: 700; padding: 0.4rem 0.9rem; border-radius: 0.5rem; border: 1px solid #99f6e4; display: inline-block;">
                    {{ ucfirst($listing->condition) }}
                </span>
            </div>
            <div>
                <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Description</small>
                <span style="color: #0f172a; font-weight: 600;">{{ $listing->description }}</span>
            </div>
            <div>
                <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Seller's Asking Price</small>
                <span style="color: #0d9488; font-weight: 800; font-size: 1.25rem;">₱{{ number_format($listing->suggested_price, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Offers Table Card -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
        <h4 style="color: #0f172a; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-users" style="color: #0284c7;"></i>
            Offers
        </h4>
        @if($offers->isEmpty())
            <div style="text-align: center; color: #94a3b8; font-size: 1.1rem; padding: 3rem 0;">
                <i class="fas fa-inbox fa-3x mb-3" style="color: #cbd5e1;"></i><br>
                No offers yet for this listing.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle" style="background: transparent;">
                    <thead>
                        <tr style="color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">
                            <th>Buyer</th>
                            <th>Bid Amount</th>
                            <th>Proposed Method</th>
                            <th>Pickup Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($offers as $offer)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="font-weight: 700; color: #0f172a;">{{ $offer->buyer->name }}</td>
                            <td style="color: #d97706; font-weight: 800; font-size: 1.05rem;">₱{{ number_format($offer->bid_amount, 2) }}</td>
                            <td style="color: #7c3aed; font-weight: 600;">{{ ucfirst($offer->proposed_method) }}</td>
                            <td style="color: #0284c7; font-weight: 600;">{{ $offer->proposed_pickup_date->format('M d, Y H:i') }}</td>
                            <td>
                                <span style="background: #fffbeb; color: #b45309; font-weight: 700; padding: 0.4rem 1rem; border-radius: 0.6rem; border: 1px solid #fde68a; display: inline-block; font-size: 0.9rem;">
                                    Pending
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('offers.show', $offer) }}" style="background: #0284c7; color: white; font-weight: 600; padding: 0.5rem 1.2rem; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; display: inline-block;">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
    .table tbody tr:hover {
        background: #f8fafc !important;
        transition: background 0.2s;
    }
</style>
@endsection
