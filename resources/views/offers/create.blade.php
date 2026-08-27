@extends('layouts.app')

@section('title', 'Make an Offer - E-Benta')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.05) 100%); border-left: 4px solid #f39c12; padding: 2rem; border-radius: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <div style="background: rgba(243, 156, 18, 0.2); padding: 0.75rem 1rem; border-radius: 0.8rem;">
                        <i class="fas fa-handshake" style="color: #f39c12; font-size: 1.8rem;"></i>
                    </div>
                    <div>
                        <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.5rem; letter-spacing: -0.5px;">
                            Submit an Offer
                        </h1>
                    </div>
                </div>
                <p style="color: #64748b; margin: 0; font-size: 1rem; font-weight: 500;">
                    Review the item details and submit your bid for this e-waste device
                </p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <!-- Item Details Card -->
            <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.12) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <h3 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-box-open" style="color: #3498db;"></i>
                    Item Being Offered
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Category
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin: 0;">
                            {{ $listing->category ?: ($listing->deviceType->name ?: 'Device') }}
                        </p>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                            Condition
                        </small>
                        <p style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin: 0;">
                            <span style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)); color: #3498db; font-weight: 700; padding: 0.4rem 0.9rem; border-radius: 0.5rem; border: 1px solid rgba(52, 152, 219, 0.3); display: inline-block;">
                                {{ ucfirst($listing->condition) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div style="margin-top: 1.5rem;">
                    <small style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">
                        Description
                    </small>
                    <p style="color: var(--text-light); font-size: 0.95rem; line-height: 1.5; margin: 0;">
                        {{ $listing->description }}
                    </p>
                </div>
                <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15), rgba(13, 148, 136, 0.05)); border-left: 3px solid var(--light-green); padding: 1rem; border-radius: 0.5rem; margin-top: 1.5rem;">
                    <small style="color: #64748b; display: block; font-weight: 600; margin-bottom: 0.25rem;">SELLER'S ASKING PRICE</small>
                    <h4 style="color: var(--light-green); margin: 0; font-weight: 800; font-size: 1.75rem;">
                        ₱{{ number_format($listing->suggested_price, 2) }}
                    </h4>
                </div>
            </div>

            <!-- Offer Form Card -->
            <div style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.2) 100%); border: 1px solid rgba(13, 148, 136, 0.15); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <form method="POST" action="{{ route('offers.store', $listing) }}">
                    @csrf

                    <!-- Bid Amount -->
                    <div style="margin-bottom: 1.75rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-coins me-2" style="color: #f39c12;"></i>Your Offer Amount *
                        </label>
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; align-items: start;">
                            <div>
                                <input type="number" 
                                       class="form-control @error('bid_amount') is-invalid @enderror" 
                                       id="bid_amount" 
                                       name="bid_amount" 
                                       step="0.01" 
                                       placeholder="Enter your bid amount"
                                       value="{{ old('bid_amount') }}" 
                                       required
                                       style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(13, 148, 136, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem;">
                                <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                                    Seller's asking price: <strong style="color: var(--light-green);">₱{{ number_format($listing->suggested_price, 2) }}</strong>
                                </small>
                                @error('bid_amount')
                                    <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Processing Method -->
                    <div style="margin-bottom: 1.75rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-wrench me-2" style="color: #3498db;"></i>Processing Method *
                        </label>
                        <select class="form-select @error('proposed_method') is-invalid @enderror" 
                               id="proposed_method" 
                               name="proposed_method" 
                               required
                               style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(46, 204, 113, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem;">
                            <option value="" style="background: #ffffff; color: #64748b;">Select your processing method</option>
                            <option value="repair" {{ old('proposed_method') == 'repair' ? 'selected' : '' }} style="background: #ffffff;">
                                Repair - Fix for resale
                            </option>
                            <option value="harvest" {{ old('proposed_method') == 'harvest' ? 'selected' : '' }} style="background: #ffffff;">
                                Harvest - Extract components
                            </option>
                            <option value="refine" {{ old('proposed_method') == 'refine' ? 'selected' : '' }} style="background: #ffffff;">
                                Refine - Extract raw materials
                            </option>
                            <option value="dispose" {{ old('proposed_method') == 'dispose' ? 'selected' : '' }} style="background: #ffffff;">
                                Dispose - Proper recycling
                            </option>
                        </select>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                            Choose how you intend to process this device responsibly
                        </small>
                        @error('proposed_method')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Handover Method -->
                    @php
                        $pref = $listing->handover_preference ?? 'both';
                    @endphp
                    <div style="margin-bottom: 1.75rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-truck-loading me-2" style="color: var(--light-green);"></i>Handover / Collection Method *
                        </label>
                        <select class="form-select @error('handover_method') is-invalid @enderror" 
                               id="handover_method" 
                               name="handover_method" 
                               required
                               style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(46, 204, 113, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem;" onchange="updateLocationLabel(this.value)">
                            @if($pref === 'both' || $pref === 'pickup_only')
                                <option value="pickup" {{ old('handover_method') === 'pickup' ? 'selected' : '' }}>🚚 Doorstep / Recycler Pickup (Collect from Seller's Location)</option>
                            @endif
                            @if($pref === 'both' || $pref === 'meetup_only')
                                <option value="meetup" {{ old('handover_method') === 'meetup' ? 'selected' : '' }}>🤝 Safe Public Meetup (Agree on Meetup Spot)</option>
                            @endif
                        </select>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                            Seller preference: <strong>{{ ucfirst(str_replace('_', ' ', $pref)) }}</strong>
                        </small>
                        @error('handover_method')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Pickup / Meetup Date -->
                    <div style="margin-bottom: 1.75rem;">
                        <label id="dateLabel" style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-calendar-alt me-2" style="color: #9b59b6;"></i>Proposed Date & Time *
                        </label>
                        <input type="datetime-local" 
                               class="form-control @error('proposed_pickup_date') is-invalid @enderror" 
                               id="proposed_pickup_date" 
                               name="proposed_pickup_date" 
                               value="{{ old('proposed_pickup_date') }}" 
                               required
                               style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(46, 204, 113, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem;">
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                            When you plan to meet or pick up the device
                        </small>
                        @error('proposed_pickup_date')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Pickup / Meetup Location -->
                    <div style="margin-bottom: 1.75rem;">
                        <label id="locationLabel" style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-map-marker-alt me-2" style="color: #e74c3c;"></i>Proposed Location / Address *
                        </label>
                        <input type="text" 
                               class="form-control @error('pickup_location') is-invalid @enderror" 
                               id="pickup_location" 
                               name="pickup_location" 
                               placeholder="e.g. Seller's address or Public Mall / Barangay Center"
                               value="{{ old('pickup_location') }}" 
                               required
                               style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(46, 204, 113, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem;">
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                            Where the transaction handover will take place
                        </small>
                        @error('pickup_location')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Additional Notes -->
                    <div style="margin-bottom: 2rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-sticky-note me-2" style="color: #3498db;"></i>Additional Notes
                        </label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                 id="notes" 
                                 name="notes" 
                                 rows="4"
                                 placeholder="Any special requirements or additional information..."
                                 style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(13, 148, 136, 0.2); color: var(--text-light); padding: 0.75rem 1rem; border-radius: 0.6rem; font-size: 1rem; font-family: inherit;">{{ old('notes') }}</textarea>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-weight: 500;">
                            Share any special requirements or comments about your processing plan
                        </small>
                        @error('notes')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem; font-weight: 600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Terms Confirmation Alert -->
                    <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.1) 0%, rgba(243, 156, 18, 0.05) 100%); border: 1px solid rgba(243, 156, 18, 0.2); border-left: 4px solid #f39c12; padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 2rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="flex-shrink: 0; padding-top: 0.25rem;">
                                <i class="fas fa-check-circle" style="color: #f39c12; font-size: 1.3rem;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <span>Terms & Conditions</span>
                                </h5>
                                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem; line-height: 1.6;">
                                    By submitting this offer, you confirm that:
                                </p>
                                <ul style="color: #64748b; font-size: 0.9rem; margin: 0; padding-left: 1.5rem; line-height: 1.6;">
                                    <li>You will process this device according to environmentally responsible practices</li>
                                    <li>You will provide tracking and disposal proof upon completion</li>
                                    <li>You agree to the E-Benta Terms of Service</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="{{ route('listings.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.08); color: var(--text-light); font-weight: 700; padding: 0.75rem 2rem; border: 1px solid rgba(100, 116, 139, 0.3); border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.12)'; this.style.borderColor='rgba(13, 148, 136, 0.4)';" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(100, 116, 139, 0.3)';">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; font-weight: 700; padding: 0.75rem 2.5rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(243, 156, 18, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(243, 156, 18, 0.25)'; this.style.transform='translateY(0)';">
                            <i class="fas fa-paper-plane me-2"></i>Submit Offer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus,
.form-select:focus {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: rgba(13, 148, 136, 0.4) !important;
    color: var(--text-light) !important;
    box-shadow: 0 0 0 0.2rem rgba(13, 148, 136, 0.15) !important;
}

.form-control::placeholder {
    color: #64748b;
}

.form-control,
.form-select {
    transition: all 0.3s ease;
}
</style>

@endsection
