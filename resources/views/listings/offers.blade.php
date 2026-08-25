@extends('layouts.app')

@section('title', 'Offers for Listing - E-Benta')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.15) 0%, rgba(52, 152, 219, 0.05) 100%); border-left: 4px solid #3498db; padding: 2rem; border-radius: 1rem; margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: rgba(52, 152, 219, 0.2); padding: 0.75rem 1rem; border-radius: 0.8rem;">
                <i class="fas fa-handshake" style="color: #3498db; font-size: 1.8rem;"></i>
            </div>
            <div>
                <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.2rem; letter-spacing: -0.5px;">
                    Offers for: <span style="color: #3498db;">{{ $listing->category ?: ($listing->deviceType->name ?: 'Device') }}</span>
                </h1>
                <p style="color: #a4b8b5; margin: 0; font-size: 1rem; font-weight: 500;">
                    Review and manage all offers for this listing
                </p>
            </div>
        </div>
    </div>

    <!-- Listing Details Card -->
    <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.12) 0%, rgba(46, 204, 113, 0.05) 100%); border: 1px solid rgba(46, 204, 113, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
        <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-box-open" style="color: var(--light-green);"></i>
            Listing Details
        </h4>
        <div style="display: flex; flex-wrap: wrap; gap: 2.5rem;">
            <div>
                <small style="color: #a4b8b5; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Condition</small>
                <span style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)); color: #3498db; font-weight: 700; padding: 0.4rem 0.9rem; border-radius: 0.5rem; border: 1px solid rgba(52, 152, 219, 0.3); display: inline-block;">
                    {{ ucfirst($listing->condition) }}
                </span>
            </div>
            <div>
                <small style="color: #a4b8b5; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Description</small>
                <span style="color: var(--text-light); font-weight: 700;">{{ $listing->description }}</span>
            </div>
            <div>
                <small style="color: #a4b8b5; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Seller's Asking Price</small>
                <span style="color: var(--light-green); font-weight: 800; font-size: 1.2rem;">₱{{ number_format($listing->suggested_price, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Offers Table Card -->
    <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.12) 0%, rgba(243, 156, 18, 0.05) 100%); border: 1px solid rgba(243, 156, 18, 0.2); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
        <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-users" style="color: #f39c12;"></i>
            Offers
        </h4>
        @if($offers->isEmpty())
            <div style="text-align: center; color: #a4b8b5; font-size: 1.1rem; padding: 2rem 0;">
                <i class="fas fa-inbox fa-2x mb-2" style="color: #a4b8b5;"></i><br>
                No offers yet for this listing.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle" style="background: transparent;">
                    <thead style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.08) 0%, rgba(52, 152, 219, 0.02) 100%);">
                        <tr style="color: #3498db; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
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
                        <tr style="background: rgba(255,255,255,0.03);">
                            <td style="font-weight: 700; color: var(--text-light);">{{ $offer->buyer->name }}</td>
                            <td style="color: #f39c12; font-weight: 800;">₱{{ number_format($offer->bid_amount, 2) }}</td>
                            <td style="color: #9b59b6; font-weight: 700;">{{ ucfirst($offer->proposed_method) }}</td>
                            <td style="color: #3498db; font-weight: 700;">{{ $offer->proposed_pickup_date->format('M d, Y H:i') }}</td>
                            <td>
                                <span style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.2), rgba(243, 156, 18, 0.1)); color: #f39c12; font-weight: 700; padding: 0.5rem 1.2rem; border-radius: 0.7rem; border: 1px solid rgba(243, 156, 18, 0.3); display: inline-block; font-size: 1rem;">
                                    Pending
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('offers.show', $offer) }}" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; font-weight: 700; padding: 0.5rem 1.2rem; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(52, 152, 219, 0.15); display: inline-block;" onmouseover="this.style.boxShadow='0 4px 16px rgba(52, 152, 219, 0.25)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(52, 152, 219, 0.15)'; this.style.transform='translateY(0)';">
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
    .table thead th {
        border-bottom: 2px solid #3498db;
    }
    .table tbody tr:hover {
        background: rgba(52, 152, 219, 0.08) !important;
        transition: background 0.2s;
    }
</style>
@endsection
