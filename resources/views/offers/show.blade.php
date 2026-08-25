@extends('layouts.app')

@section('title', 'Offer Details - E-Benta')

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.05) 100%); border-left: 4px solid #f39c12; padding: 2rem; border-radius: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <div style="background: rgba(243, 156, 18, 0.2); padding: 0.75rem 1rem; border-radius: 0.8rem;">
                        <i class="fas fa-file-contract" style="color: #f39c12; font-size: 1.8rem;"></i>
                    </div>
                    <div>
                        <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.5rem; letter-spacing: -0.5px;">
                            Offer Details
                        </h1>
                    </div>
                </div>
                <p style="color: #64748b; margin: 0; font-size: 1rem; font-weight: 500;">
                    Review and manage your offer for this device
                </p>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Listing Information Card -->
            <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.12) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <h3 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-box-open" style="color: #3498db;"></i>
                    Listing Information
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Item
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin: 0;">
                            {{ $offer->listing->category }}
                        </p>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Condition
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin: 0;">
                            <span style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)); color: #3498db; font-weight: 700; padding: 0.4rem 0.9rem; border-radius: 0.5rem; border: 1px solid rgba(52, 152, 219, 0.3); display: inline-block;">
                                {{ ucfirst(str_replace('_', ' ', $offer->listing->condition)) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Seller
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin: 0;">
                            {{ $offer->listing->seller->name }}
                        </p>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Asking Price
                        </small>
                        <p style="color: var(--light-green); font-weight: 800; font-size: 1.3rem; margin: 0;">
                            ₱{{ number_format($offer->listing->suggested_price, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Offer Details Card -->
            <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.12) 0%, rgba(13, 148, 136, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <h3 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-handshake" style="color: var(--light-green);"></i>
                    Your Offer
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.15), rgba(243, 156, 18, 0.05)); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #f39c12;">
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            <i class="fas fa-coins me-1" style="color: #f39c12;"></i>Your Bid
                        </small>
                        <p style="color: #f39c12; font-weight: 800; font-size: 1.5rem; margin: 0;">
                            ₱{{ number_format($offer->bid_amount, 2) }}
                        </p>
                    </div>
                    <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.15), rgba(155, 89, 182, 0.05)); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #9b59b6;">
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            <i class="fas fa-wrench me-1" style="color: #9b59b6;"></i>Processing Method
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1rem; margin: 0;">
                            {{ ucfirst(str_replace('_', ' ', $offer->proposed_method)) }}
                        </p>
                    </div>
                    <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(52, 152, 219, 0.05)); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #3498db;">
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            <i class="fas fa-calendar-alt me-1" style="color: #3498db;"></i>Proposed Pickup
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1rem; margin: 0;">
                            {{ $offer->proposed_pickup_date->format('M d, Y H:i') }}
                        </p>
                    </div>
                    <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.15), rgba(231, 76, 60, 0.05)); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #e74c3c;">
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            <i class="fas fa-map-marker-alt me-1" style="color: #e74c3c;"></i>Pickup Location
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1rem; margin: 0;">
                            {{ $offer->pickup_location }}
                        </p>
                    </div>
                </div>
                @if($offer->notes)
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(13, 148, 136, 0.2);">
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            <i class="fas fa-sticky-note me-1"></i>Notes
                        </small>
                        <p style="color: var(--text-light); font-size: 0.95rem; line-height: 1.6; margin: 0;">
                            {{ $offer->notes }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Seller Actions -->
            @if($offer->status === 'pending' && auth()->id() === $offer->listing->user_id)
                <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.1) 0%, rgba(243, 156, 18, 0.05) 100%); border: 1px solid rgba(243, 156, 18, 0.2); border-left: 4px solid #f39c12; padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem;">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-gavel" style="color: #f39c12;"></i>
                        Respond to Offer
                    </h4>
                    <div style="display: flex; gap: 1rem;">
                        <form method="POST" action="{{ route('offers.accept', $offer) }}" style="flex: 1;">
                            @csrf
                            <button type="submit" style="width: 100%; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; font-weight: 700; padding: 0.9rem 1.5rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(13, 148, 136, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(13, 148, 136, 0.25)'; this.style.transform='translateY(0)';">
                                <i class="fas fa-check me-2"></i>Accept Offer
                            </button>
                        </form>
                        <form method="POST" action="{{ route('offers.reject', $offer) }}" style="flex: 1;">
                            @csrf
                            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.9rem 1.5rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(231, 76, 60, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.25)'; this.style.transform='translateY(0)';">
                                <i class="fas fa-times me-2"></i>Reject Offer
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Buyer Cancel Action -->
            @if(auth()->id() === $offer->buyer_id && $offer->canBuyerCancel())
                <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(231, 76, 60, 0.03) 100%); border: 1px solid rgba(231, 76, 60, 0.2); border-left: 4px solid #e74c3c; padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-ban" style="color: #e74c3c;"></i>
                        Cancel Offer
                    </h4>
                    <p style="color: #64748b; margin-bottom: 1rem;">
                        You can cancel this offer while it is pending or within the grace period after acceptance.
                    </p>
                    <form method="POST" action="{{ route('offers.cancel', $offer) }}">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.85rem 2rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(231, 76, 60, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-times me-2"></i>Cancel Offer
                        </button>
                    </form>
                </div>
            @endif

            <!-- Pickup Confirmation -->
            @if($offer->status === 'accepted' && auth()->id() === $offer->buyer_id && $offer->listing->status !== 'in_transit')
                <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); border-left: 4px solid #3498db; padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem;">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-truck" style="color: #3498db;"></i>
                        Pickup Confirmation
                    </h4>
                    <p style="color: #64748b; margin-bottom: 1.25rem;">
                        Ready to pick up the item on <strong>{{ $offer->proposed_pickup_date->format('M d, Y') }}</strong> from <strong>{{ $offer->pickup_location }}</strong>?
                    </p>
                    <form method="POST" action="{{ route('offers.mark-picked-up', $offer) }}">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; font-weight: 700; padding: 0.9rem 2.5rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(52, 152, 219, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(52, 152, 219, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-check me-2"></i>Confirm Pickup
                        </button>
                    </form>
                </div>
            @endif

            <!-- Processing Status Form -->
            @if($offer->listing->status === 'in_transit' && auth()->id() === $offer->buyer_id)
                <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem;">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1rem;">
                        <i class="fas fa-box-open" style="color: #3498db;"></i> Confirm Delivery
                    </h4>
                    <p style="color: #64748b; margin-bottom: 1.25rem;">Confirm that you received the item before submitting its processing result.</p>
                    <form method="POST" action="{{ route('listings.mark-delivered', $offer->listing) }}">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; font-weight: 700; padding: 0.9rem 2.5rem; border: none; border-radius: 0.6rem; cursor: pointer;">
                            <i class="fas fa-check me-2"></i>Confirm Delivery
                        </button>
                    </form>
                </div>
            @endif

            <!-- Processing Status Form -->
            @if($offer->listing->status === 'delivered' && auth()->id() === $offer->buyer_id)
                <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.12) 0%, rgba(155, 89, 182, 0.05) 100%); border: 1px solid rgba(155, 89, 182, 0.2); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-industry" style="color: #9b59b6;"></i>
                        Report Processing Status
                    </h3>
                    <form method="POST" action="{{ route('offers.update-status', $offer) }}">
                        @csrf

                        <div style="margin-bottom: 1.75rem;">
                            <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                                <i class="fas fa-cogs me-2" style="color: #9b59b6;"></i>Processing Method *
                            </label>
                            <select name="processing_method" required style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(155, 89, 182, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; width: 100%; transition: all 0.3s ease;">
                                <option value="" style="background: #ffffff;">Select processing method</option>
                                <option value="repair" style="background: #ffffff;">Repaired for Resale</option>
                                <option value="harvest" style="background: #ffffff;">Components Harvested</option>
                                <option value="refine" style="background: #ffffff;">Raw Materials Extracted</option>
                                <option value="dispose" style="background: #ffffff;">Properly Disposed</option>
                            </select>
                        </div>

                        <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.25rem; margin-top: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-chart-pie" style="color: #9b59b6;"></i>
                            Material Recovery
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div style="background: rgba(0, 0, 0, 0.1); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #f39c12;">
                                <label style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem; font-size: 0.85rem;">
                                    <i class="fas fa-gem me-1" style="color: #f39c12;"></i>Gold Recovered (kg)
                                </label>
                                <input type="number" name="material_breakdown[0][weight]" step="0.0001" value="0" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(155, 89, 182, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; width: 100%;">
                                <input type="hidden" name="material_breakdown[0][type]" value="gold">
                            </div>
                            <div style="background: rgba(0, 0, 0, 0.1); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #e67e22;">
                                <label style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem; font-size: 0.85rem;">
                                    <i class="fas fa-shield me-1" style="color: #e67e22;"></i>Copper Recovered (kg)
                                </label>
                                <input type="number" name="material_breakdown[1][weight]" step="0.01" value="0" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(155, 89, 182, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; width: 100%;">
                                <input type="hidden" name="material_breakdown[1][type]" value="copper">
                            </div>
                            <div style="background: rgba(0, 0, 0, 0.1); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid #3498db;">
                                <label style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem; font-size: 0.85rem;">
                                    <i class="fas fa-cube me-1" style="color: #3498db;"></i>Plastic Recovered (kg)
                                </label>
                                <input type="number" name="material_breakdown[2][weight]" step="0.01" value="0" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(155, 89, 182, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; width: 100%;">
                                <input type="hidden" name="material_breakdown[2][type]" value="plastic">
                            </div>
                            <div style="background: rgba(0, 0, 0, 0.1); padding: 1.25rem; border-radius: 0.8rem; border-left: 3px solid var(--light-green);">
                                <label style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem; font-size: 0.85rem;">
                                    <i class="fas fa-wind me-1" style="color: var(--light-green);"></i>Aluminum Recovered (kg)
                                </label>
                                <input type="number" name="material_breakdown[3][weight]" step="0.01" value="0" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(155, 89, 182, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; width: 100%;">
                                <input type="hidden" name="material_breakdown[3][type]" value="aluminum">
                            </div>
                        </div>

                        <button type="submit" style="width: 100%; background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; font-weight: 700; padding: 1rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(155, 89, 182, 0.25); cursor: pointer; margin-top: 2rem;" onmouseover="this.style.boxShadow='0 8px 20px rgba(155, 89, 182, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(155, 89, 182, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-paper-plane me-2"></i>Submit Processing Report
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.12) 0%, rgba(243, 156, 18, 0.05) 100%); border: 1px solid rgba(243, 156, 18, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; text-align: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <h3 style="color: var(--text-light); font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                    <i class="fas fa-circle-info" style="color: #f39c12;"></i>Status
                </h3>
                <div style="margin-bottom: 1rem;">
                    @if($offer->status === 'accepted')
                        <span style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(46, 204, 113, 0.1)); color: var(--light-green); font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.8rem; border: 1px solid rgba(46, 204, 113, 0.3); display: inline-block; font-size: 1.15rem;">
                            <i class="fas fa-check-circle me-2"></i>Accepted
                        </span>
                    @elseif($offer->status === 'completed')
                        <span style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(46, 204, 113, 0.1)); color: var(--light-green); font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.8rem; border: 1px solid rgba(46, 204, 113, 0.3); display: inline-block; font-size: 1.15rem;">
                            <i class="fas fa-check-circle me-2"></i>Completed
                        </span>
                    @elseif($offer->status === 'pending')
                        <span style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.2), rgba(243, 156, 18, 0.1)); color: #f39c12; font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.8rem; border: 1px solid rgba(243, 156, 18, 0.3); display: inline-block; font-size: 1.15rem;">
                            <i class="fas fa-hourglass-half me-2"></i>Pending
                        </span>
                    @else
                        <span style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.2), rgba(231, 76, 60, 0.1)); color: #e74c3c; font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.8rem; border: 1px solid rgba(231, 76, 60, 0.3); display: inline-block; font-size: 1.15rem;">
                            <i class="fas fa-times-circle me-2"></i>{{ ucfirst($offer->status) }}
                        </span>
                    @endif
                </div>
                @if($offer->responded_at)
                    <small style="color: #64748b; display: block; font-weight: 500;">
                        <i class="fas fa-clock me-1"></i>Responded {{ $offer->responded_at->diffForHumans() }}
                    </small>
                @endif
            </div>

            <!-- Timeline -->
            @if(in_array($offer->status, ['accepted', 'completed']))
                <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.12) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-timeline" style="color: #3498db;"></i>Timeline
                    </h4>
                    <div style="position: relative; padding-left: 1.75rem;">
                        <!-- Offer Accepted -->
                        <div style="margin-bottom: 1.75rem; position: relative;">
                            <div style="position: absolute; left: -1.75rem; top: 0.25rem; width: 1.5rem; height: 1.5rem; background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(46, 204, 113, 0.1)); border: 2px solid var(--light-green); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: var(--light-green); font-size: 0.75rem;"></i>
                            </div>
                            <h6 style="color: var(--text-light); font-weight: 700; margin: 0;">Offer Accepted</h6>
                            <small style="color: #64748b; display: block; margin-top: 0.25rem;">
                                {{ $offer->responded_at?->format('M d, Y') }}
                            </small>
                        </div>

                        <!-- Item Pickup -->
                        <div style="margin-bottom: 1.75rem; position: relative;">
                            <div style="position: absolute; left: -1.75rem; top: 0.25rem; width: 1.5rem; height: 1.5rem; background: linear-gradient(135deg, @if($offer->listing->picked_up_at) rgba(46, 204, 113, 0.2) @else rgba(164, 184, 181, 0.2) @endif, rgba(164, 184, 181, 0.1)); border: 2px solid @if($offer->listing->picked_up_at) var(--light-green) @else #64748b @endif; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas @if($offer->listing->picked_up_at) fa-check @else fa-circle @endif" style="color: @if($offer->listing->picked_up_at) var(--light-green) @else #64748b @endif; font-size: 0.75rem;"></i>
                            </div>
                            <h6 style="color: var(--text-light); font-weight: 700; margin: 0;">Item Picked Up</h6>
                            @if($offer->listing->picked_up_at)
                                <small style="color: #64748b; display: block; margin-top: 0.25rem;">
                                    {{ $offer->listing->picked_up_at->format('M d, Y') }}
                                </small>
                            @else
                                <small style="color: #64748b; display: block; margin-top: 0.25rem;">
                                    Awaiting Pickup - {{ $offer->proposed_pickup_date->format('M d, Y') }}
                                </small>
                            @endif
                        </div>

                        <!-- Processing Complete -->
                        <div style="position: relative;">
                            <div style="position: absolute; left: -1.75rem; top: 0.25rem; width: 1.5rem; height: 1.5rem; background: linear-gradient(135deg, @if($offer->listing->processed_at) rgba(46, 204, 113, 0.2) @else rgba(164, 184, 181, 0.2) @endif, rgba(164, 184, 181, 0.1)); border: 2px solid @if($offer->listing->processed_at) var(--light-green) @else #64748b @endif; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas @if($offer->listing->processed_at) fa-check @else fa-circle @endif" style="color: @if($offer->listing->processed_at) var(--light-green) @else #64748b @endif; font-size: 0.75rem;"></i>
                            </div>
                            <h6 style="color: var(--text-light); font-weight: 700; margin: 0;">Processing Complete</h6>
                            @if($offer->listing->processed_at)
                                <small style="color: #64748b; display: block; margin-top: 0.25rem;">
                                    {{ $offer->listing->processed_at->format('M d, Y') }}
                                </small>
                            @else
                                <small style="color: #64748b; display: block; margin-top: 0.25rem;">
                                    Awaiting Processing
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Report Section -->
            @auth
                @if(auth()->id() !== $offer->listing->user_id && auth()->id() !== $offer->buyer_id)
                    <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.12) 0%, rgba(231, 76, 60, 0.05) 100%); border: 1px solid rgba(231, 76, 60, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                        <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-flag" style="color: #e74c3c;"></i>Report Offer
                        </h4>
                        <p style="color: #64748b; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Found something suspicious? Help us keep the marketplace safe by reporting this offer.
                        </p>
                        <button type="button" class="btn w-100" data-bs-toggle="modal" data-bs-target="#reportOfferModal" style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.3), rgba(231, 76, 60, 0.2)); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); font-weight: 700; padding: 0.9rem 1.5rem; border-radius: 0.6rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='rgba(231, 76, 60, 0.4)';" onmouseout="this.style.backgroundColor='rgba(231, 76, 60, 0.3)';">
                            <i class="fas fa-exclamation-triangle me-2"></i>Report This Offer
                        </button>
                    </div>
                @endif
            @endauth

            <!-- Review Section -->
            @if(in_array($offer->status, ['accepted', 'completed']) && (auth()->id() === $offer->buyer_id || auth()->id() === $offer->listing->user_id))
                <div style="background: linear-gradient(135deg, rgba(241, 196, 15, 0.12) 0%, rgba(241, 196, 15, 0.05) 100%); border: 1px solid rgba(241, 196, 15, 0.2); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-star" style="color: #f1c40f;"></i>Share Your Feedback
                    </h4>
                    @php
                        $hasReviewed = auth()->user()->reviewsGiven()
                            ->where('offer_id', $offer->id)
                            ->exists();
                    @endphp
                    
                    @if($hasReviewed)
                        <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(46, 204, 113, 0.1)); border-left: 3px solid var(--light-green); padding: 1rem; border-radius: 0.6rem;">
                            <p style="color: #27ae60; margin: 0; font-weight: 600;">
                                <i class="fas fa-check-circle me-2"></i>You've already reviewed this transaction
                            </p>
                        </div>
                    @else
                        <p style="color: #64748b; margin-bottom: 1.5rem;">
                            Help build trust in our marketplace by sharing your experience with 
                            <strong style="color: var(--text-light);">
                                {{ auth()->id() === $offer->buyer_id ? $offer->listing->seller->name : $offer->buyer->name }}
                            </strong>
                        </p>
                        <a href="{{ route('reviews.create', $offer) }}" class="btn" style="width: 100%; background: linear-gradient(135deg, #f1c40f 0%, #f39c12 100%); color: #ffffff; border: none; font-weight: 700; padding: 0.9rem 1.5rem; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(241, 196, 15, 0.25); cursor: pointer; display: block; text-align: center;" onmouseover="this.style.boxShadow='0 8px 20px rgba(241, 196, 15, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(241, 196, 15, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-pen-fancy me-2"></i>Write a Review
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
    </div>
</div>

<style>
select:focus,
input:focus {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: rgba(155, 89, 182, 0.4) !important;
    color: var(--text-light) !important;
    box-shadow: 0 0 0 0.2rem rgba(155, 89, 182, 0.15) !important;
}

input::placeholder {
    color: #7f9e9a;
}

input,
select {
    transition: all 0.3s ease;
}
</style>

<!-- Report Offer Modal -->
<div class="modal fade" id="reportOfferModal" tabindex="-1" style="backdrop-filter: blur(5px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: linear-gradient(135deg, rgba(15, 40, 24, 0.95) 0%, rgba(15, 40, 24, 0.8) 100%); border: 1px solid rgba(46, 204, 113, 0.2); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(46, 204, 113, 0.2); padding: 2rem;">
                <h5 class="modal-title" style="color: var(--text-light); font-weight: 800; font-size: 1.3rem;">
                    <i class="fas fa-flag me-2" style="color: #e74c3c;"></i>Report This Offer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0.8); opacity: 0.6;"></button>
            </div>
            <form method="POST" action="{{ route('reports.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $offer->id }}">
                <input type="hidden" name="type" value="offer">
                <div class="modal-body" style="padding: 2rem; color: #64748b;">
                    <div class="mb-3">
                        <label style="color: var(--text-light); font-weight: 700; font-size: 1rem; margin-bottom: 0.75rem; display: block;">Report Reason</label>
                        <select name="reason" class="form-select" required style="background: rgba(46, 204, 113, 0.1); border: 1px solid rgba(46, 204, 113, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem;">
                            <option value="" style="background: #1a2e24; color: var(--text-light);">Select a reason...</option>
                            <option value="scam_fraud" style="background: #1a2e24; color: var(--text-light);">Fraudulent Offer</option>
                            <option value="suspicious_behavior" style="background: #1a2e24; color: var(--text-light);">Suspicious Activity</option>
                            <option value="false_information" style="background: #1a2e24; color: var(--text-light);">Price Manipulation</option>
                            <option value="inappropriate_content" style="background: #1a2e24; color: var(--text-light);">Attempting Off-Platform Deal</option>
                            <option value="other" style="background: #1a2e24; color: var(--text-light);">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-light); font-weight: 700; font-size: 1rem; margin-bottom: 0.75rem; display: block;">Details</label>
                        <textarea name="description" class="form-control" rows="4" required placeholder="Please provide details about your report..." style="background: rgba(46, 204, 113, 0.1); border: 1px solid rgba(46, 204, 113, 0.3); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; resize: vertical;"></textarea>
                    </div>
                    <div style="background: rgba(46, 204, 113, 0.1); border-left: 3px solid var(--light-green); padding: 1rem; border-radius: 0.6rem;">
                        <small style="color: #64748b; display: block; line-height: 1.6;">
                            <i class="fas fa-info-circle me-1" style="color: var(--light-green);"></i>Your report will be reviewed by our moderation team. Please provide detailed information to help us address the issue quickly.
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(46, 204, 113, 0.2); padding: 1.5rem; gap: 1rem;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: rgba(255, 255, 255, 0.08); color: var(--text-light); border: 1px solid rgba(46, 204, 113, 0.3); font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.6rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.12)';" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.08)';">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.75rem 1.5rem; border: none; border-radius: 0.6rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);" onmouseover="this.style.boxShadow='0 8px 20px rgba(231, 76, 60, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.2)'; this.style.transform='translateY(0)';">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
