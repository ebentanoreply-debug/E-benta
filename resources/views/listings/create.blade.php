@extends('layouts.app')

@section('title', 'Create Listing - E-Benta')

@section('content')
<div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%); min-height: 100vh; padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Header Section -->
                <div style="margin-bottom: 2.5rem; text-align: center;">
                    <div style="display: inline-block; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3);">
                        <i class="fas fa-plus-circle" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin-bottom: 0.5rem; font-size: 2.2rem;">
                        List Your E-Waste Item
                    </h1>
                    <p style="color: #64748b; margin: 0; font-size: 1rem;">Convert your electronic waste into value or ensure certified eco-friendly recycling</p>
                </div>

                <!-- Form Card -->
                <div class="card" style="border: 2px solid rgba(13, 148, 136, 0.15); background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); border-radius: 1.25rem; overflow: hidden;">
                    <div class="card-body" style="padding: 2.5rem 3rem;">
                    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" id="listingForm">
                        @csrf

                        <!-- Listing Mode / Type Selector -->
                        <div style="margin-bottom: 2.5rem; background: rgba(13, 148, 136, 0.04); border: 1.5px solid rgba(13, 148, 136, 0.2); border-radius: 1rem; padding: 1.5rem;">
                            <label class="form-label" style="color: var(--text-light); font-weight: 700; margin-bottom: 1rem; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-layer-group" style="color: var(--light-green);"></i>Listing Mode / Type <span style="color: #e74c3c;">*</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="listing-type-card" style="display: block; border: 2px solid rgba(13, 148, 136, 0.3); border-radius: 0.85rem; padding: 1.25rem; cursor: pointer; transition: all 0.25s ease; background: white;" id="typeCardSingle">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="listing_type" id="type_single" value="single" {{ old('listing_type', 'single') === 'single' ? 'checked' : '' }} onchange="updateListingTypeView()">
                                            <label class="form-check-label ms-2" for="type_single" style="font-weight: 700; color: #1e293b; cursor: pointer;">
                                                <i class="fas fa-mobile-alt me-1" style="color: #0d9488;"></i> Single Device / Item
                                            </label>
                                        </div>
                                        <p style="color: #64748b; font-size: 0.85rem; margin: 0.5rem 0 0 1.5rem;">List an individual phone, tablet, laptop, component, or accessory.</p>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="listing-type-card" style="display: block; border: 2px solid rgba(13, 148, 136, 0.3); border-radius: 0.85rem; padding: 1.25rem; cursor: pointer; transition: all 0.25s ease; background: white;" id="typeCardBulk">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="listing_type" id="type_bulk" value="bulk_lot" {{ old('listing_type') === 'bulk_lot' ? 'checked' : '' }} onchange="updateListingTypeView()">
                                            <label class="form-check-label ms-2" for="type_bulk" style="font-weight: 700; color: #1e293b; cursor: pointer;">
                                                <i class="fas fa-boxes me-1" style="color: #f59e0b;"></i> Bulk / E-Waste Scrap Lot (Bundle)
                                            </label>
                                        </div>
                                        <p style="color: #64748b; font-size: 0.85rem; margin: 0.5rem 0 0 1.5rem;">List a box/batch of non-working devices or scrap for buyers to purchase in one go.</p>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 1. Device Information Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">1</span>
                                Device Information
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="device_type_id" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-microchip me-1" style="color: var(--light-green);"></i>Primary Category <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('device_type_id') is-invalid @enderror" 
                                           id="device_type_id" name="device_type_id" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="">Select category</option>
                                        @foreach($deviceTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('device_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('device_type_id')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="bulkCountWrapper" style="display: none;">
                                    <label for="lot_item_count" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-calculator me-1" style="color: #f59e0b;"></i>Est. Device Count in Lot <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" min="2" max="1000" class="form-control @error('lot_item_count') is-invalid @enderror" 
                                           id="lot_item_count" name="lot_item_count" value="{{ old('lot_item_count', 5) }}"
                                           placeholder="e.g. 5, 10, 20 devices"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    @error('lot_item_count')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="device_details" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-tag me-1" style="color: var(--light-green);"></i>Item Title / Specific Details <span style="color: #64748b;">(e.g. Brands, Models, or Batch Summary)</span>
                                    </label>
                                    <input type="text" class="form-control @error('device_details') is-invalid @enderror" 
                                           id="device_details" name="device_details" value="{{ old('device_details') }}" 
                                           placeholder="e.g. Box of 8 Broken Android Phones & 2 iPads for Parts, or Samsung Galaxy S10 with broken screen"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    @error('device_details')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Condition & Handover Options -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">2</span>
                                Condition & Handover Options
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="condition" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-heartbeat me-1" style="color: var(--light-green);"></i>Device / Lot Condition <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                           id="condition" name="condition" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;" onchange="suggestHandoverOption()">
                                        <option value="">Select condition</option>
                                        <option value="working" {{ old('condition') == 'working' ? 'selected' : '' }}>Working (Fully Functional)</option>
                                        <option value="minor_damage" {{ old('condition') == 'minor_damage' ? 'selected' : '' }}>Minor Damage (Needs minor repair)</option>
                                        <option value="major_damage" {{ old('condition') == 'major_damage' ? 'selected' : '' }}>Major Damage (For parts/salvage)</option>
                                        <option value="non_functional" {{ old('condition', 'non_functional') == 'non_functional' ? 'selected' : '' }}>Non-functional (E-Waste / Scrap)</option>
                                    </select>
                                    @error('condition')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="handover_preference" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-truck-loading me-1" style="color: var(--light-green);"></i>Handover / Collection Option <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('handover_preference') is-invalid @enderror" 
                                           id="handover_preference" name="handover_preference" required
                                           onchange="togglePickupAddressField()"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="both" {{ old('handover_preference', 'both') == 'both' ? 'selected' : '' }}>🔄 Both Pickup & Meetup Available</option>
                                        <option value="pickup_only" {{ old('handover_preference') == 'pickup_only' ? 'selected' : '' }}>🚚 Doorstep / Location Pickup Only (Recommended for E-Waste)</option>
                                        <option value="meetup_only" {{ old('handover_preference') == 'meetup_only' ? 'selected' : '' }}>🤝 Safe Public Meetup Only (Recommended for working gadgets)</option>
                                    </select>
                                    <small style="color: #64748b; font-size: 0.82rem; margin-top: 0.35rem; display: block;">Pickup lets the recycler collect at your address; Meetup is for public spot testing.</small>
                                    @error('handover_preference')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12" id="pickup_address_group">
                                    <label for="pickup_address" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-map-marker-alt me-1" style="color: var(--light-green);"></i>Seller Pickup / Collection Address <span style="color: #e74c3c;" id="pickup_address_required_star">*</span>
                                    </label>
                                    <textarea class="form-control @error('pickup_address') is-invalid @enderror" 
                                             id="pickup_address" name="pickup_address" rows="2"
                                             placeholder="e.g. Unit / Street, Barangay, City, Province (where the recycler or buyer will collect the item)"
                                             style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">{{ old('pickup_address', auth()->user()->addresses()->first()?->getFullAddress() ?? (auth()->user()->address_city ? auth()->user()->address_city . (auth()->user()->address_province ? ', ' . auth()->user()->address_province : '') : '')) }}</textarea>
                                    <small style="color: #64748b; font-size: 0.82rem; margin-top: 0.35rem; display: block;">Required for doorstep pickup so buyers/recyclers know the collection location.</small>
                                    @error('pickup_address')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. Description & Pricing Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">3</span>
                                Item Details & Pricing
                            </h5>

                            <div class="mb-4">
                                <label for="description" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                    <i class="fas fa-align-left me-1" style="color: var(--light-green);"></i>Description & Condition Details <span style="color: #e74c3c;">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                         id="description" name="description" rows="4" required 
                                         placeholder="Describe the items, included cables/accessories, known defects or scrap details..."
                                         style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="intended_action" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-bullseye me-1" style="color: var(--light-green);"></i>Listing Goal <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('intended_action') is-invalid @enderror" 
                                           id="intended_action" name="intended_action" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="sell" {{ old('intended_action', 'sell') == 'sell' ? 'selected' : '' }}>💰 Sell (Set Selling Price / Accept Offers)</option>
                                        <option value="recycle" {{ old('intended_action') == 'recycle' ? 'selected' : '' }}>♻️ Recycle (Certified Scrap Disposal)</option>
                                    </select>
                                    @error('intended_action')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="seller-price-field">
                                    <label for="suggested_price" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-tags me-1" style="color: var(--light-green);"></i>Target Price (₱) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('suggested_price') is-invalid @enderror" 
                                           id="suggested_price" name="suggested_price" value="{{ old('suggested_price') }}"
                                           placeholder="Enter selling / lot price (₱)"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    <small style="color: #64748b; font-size: 0.82rem; margin-top: 0.35rem; display: block;">Buyers can propose counter-offers based on your price.</small>
                                    @error('suggested_price')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. Photos Section (Interactive Multi-Photo Uploader) -->
                        <div style="margin-bottom: 2.5rem;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 style="color: var(--text-light); font-weight: 700; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">4</span>
                                    Photos (Up to 8 Images)
                                </h5>
                                <span style="color: #64748b; font-size: 0.85rem;" id="photoCountDisplay">0 / 8 uploaded</span>
                            </div>

                            <!-- Dropzone Container -->
                            <div id="dropZoneWrapper" style="border: 2px dashed rgba(13, 148, 136, 0.4); border-radius: 1rem; padding: 2rem; background: rgba(13, 148, 136, 0.02); text-align: center; transition: all 0.3s ease; position: relative;">
                                <input type="file" id="photosInput" name="photos[]" multiple accept="image/*" style="display: none;">
                                
                                <div id="uploadPrompt" style="cursor: pointer;" onclick="document.getElementById('photosInput').click()">
                                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: rgba(13, 148, 136, 0.1); border-radius: 50%; margin-bottom: 1rem; color: var(--light-green); font-size: 1.8rem;">
                                        <i class="fas fa-images"></i>
                                    </div>
                                    <h6 style="font-weight: 700; color: #1e293b; margin-bottom: 0.35rem;">Click to browse or drag and drop multiple photos</h6>
                                    <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Upload multiple angles, screen condition, and labels (PNG, JPG, WEBP up to 4MB each)</p>
                                </div>

                                <!-- Thumbnails Grid -->
                                <div id="previewGrid" style="display: none; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                                </div>

                                <div id="addMoreBtnWrapper" style="display: none; margin-top: 1.25rem;">
                                    <button type="button" class="btn btn-sm" style="background: rgba(13, 148, 136, 0.1); color: #0d9488; font-weight: 700; border-radius: 0.6rem; padding: 0.5rem 1.25rem;" onclick="document.getElementById('photosInput').click()">
                                        <i class="fas fa-plus me-1"></i> Add More Photos
                                    </button>
                                </div>
                            </div>
                            @if($errors->has('photos.*'))
                                <span class="invalid-feedback d-block mt-2">{{ $errors->first('photos.*') }}</span>
                            @endif
                        </div>

                        <!-- System Note -->
                        <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%); border-left: 4px solid var(--light-green); padding: 1.25rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2.5rem;">
                            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                <i class="fas fa-shield-alt" style="color: var(--light-green); font-size: 1.25rem; margin-top: 0.2rem;"></i>
                                <div style="color: #475569; font-size: 0.9rem;">
                                    <strong style="color: #1e293b;">E-Benta Responsible Guarantee:</strong> Carbon footprint reduction is automatically recorded. Once transaction is complete, you will receive a verifiable <strong>Digital Certificate of Responsible Disposal</strong>.
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('seller.dashboard') }}" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 0.8rem; padding: 0.85rem 2rem;">
                                Cancel
                            </a>
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; border: none; padding: 0.85rem 2.5rem; font-weight: 700; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35);">
                                <i class="fas fa-check-circle me-2"></i>Publish Listing
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // --- Listing Type Toggle ---
    function updateListingTypeView() {
        const isBulk = document.getElementById('type_bulk').checked;
        const bulkWrapper = document.getElementById('bulkCountWrapper');
        const cardSingle = document.getElementById('typeCardSingle');
        const cardBulk = document.getElementById('typeCardBulk');

        if (isBulk) {
            bulkWrapper.style.display = 'block';
            cardBulk.style.borderColor = '#0d9488';
            cardBulk.style.background = 'rgba(13, 148, 136, 0.05)';
            cardSingle.style.borderColor = 'rgba(13, 148, 136, 0.2)';
            cardSingle.style.background = 'white';
            
            // Auto suggest pickup for bulk lots
            const handoverPref = document.getElementById('handover_preference');
            if (handoverPref && handoverPref.value === 'meetup_only') {
                handoverPref.value = 'pickup_only';
            }
        } else {
            bulkWrapper.style.display = 'none';
            cardSingle.style.borderColor = '#0d9488';
            cardSingle.style.background = 'rgba(13, 148, 136, 0.05)';
            cardBulk.style.borderColor = 'rgba(13, 148, 136, 0.2)';
            cardBulk.style.background = 'white';
        }
    }

    // --- Price field toggle ---
    function toggleSellerPriceField() {
        const intendedAction = document.getElementById('intended_action');
        const priceField = document.getElementById('seller-price-field');
        const priceInput = document.getElementById('suggested_price');

        if (!intendedAction || !priceField || !priceInput) return;

        const isSell = intendedAction.value === 'sell';
        priceField.style.display = isSell ? 'block' : 'none';
        priceInput.required = isSell;
        if (!isSell) {
            priceInput.value = '';
        }
    }

    function togglePickupAddressField() {
        const handover = document.getElementById('handover_preference');
        const group = document.getElementById('pickup_address_group');
        const input = document.getElementById('pickup_address');
        const star = document.getElementById('pickup_address_required_star');
        if (!handover || !group || !input) return;

        if (handover.value === 'meetup_only') {
            group.style.display = 'none';
            input.removeAttribute('required');
            if (star) star.style.display = 'none';
        } else {
            group.style.display = 'block';
            input.setAttribute('required', 'required');
            if (star) star.style.display = 'inline';
        }
    }

    function suggestHandoverOption() {
        const condition = document.getElementById('condition').value;
        const handover = document.getElementById('handover_preference');
        if (!handover) return;

        if (condition === 'non_functional' || condition === 'major_damage') {
            if (handover.value === 'meetup_only') {
                handover.value = 'pickup_only';
            }
        } else if (condition === 'working') {
            if (handover.value === 'pickup_only') {
                handover.value = 'both';
            }
        }
        togglePickupAddressField();
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateListingTypeView();
        toggleSellerPriceField();
        togglePickupAddressField();
        
        const intendedAction = document.getElementById('intended_action');
        if (intendedAction) {
            intendedAction.addEventListener('change', toggleSellerPriceField);
        }
    });

    // --- Multi-Photo File Queue & Gallery Manager ---
    const fileInput = document.getElementById('photosInput');
    const dropZone = document.getElementById('dropZoneWrapper');
    const previewGrid = document.getElementById('previewGrid');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const addMoreWrapper = document.getElementById('addMoreBtnWrapper');
    const countDisplay = document.getElementById('photoCountDisplay');
    
    // File state buffer using DataTransfer
    let fileBuffer = new DataTransfer();

    function renderPreviews() {
        previewGrid.innerHTML = '';
        const files = fileBuffer.files;
        const total = files.length;

        countDisplay.textContent = `${total} / 8 uploaded`;

        if (total === 0) {
            uploadPrompt.style.display = 'block';
            previewGrid.style.display = 'none';
            addMoreWrapper.style.display = 'none';
            return;
        }

        uploadPrompt.style.display = 'none';
        previewGrid.style.display = 'grid';
        addMoreWrapper.style.display = total < 8 ? 'block' : 'none';

        Array.from(files).forEach((file, idx) => {
            const card = document.createElement('div');
            card.style.cssText = 'position: relative; border-radius: 0.75rem; overflow: hidden; aspect-ratio: 1; border: 2px solid ' + (idx === 0 ? 'var(--light-green)' : 'rgba(0,0,0,0.1)') + '; background: #000;';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
            card.appendChild(img);

            // Cover Photo Badge
            if (idx === 0) {
                const badge = document.createElement('span');
                badge.textContent = 'COVER';
                badge.style.cssText = 'position: absolute; bottom: 6px; left: 6px; background: rgba(13, 148, 136, 0.9); color: white; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px;';
                card.appendChild(badge);
            }

            // Remove Button
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.innerHTML = '<i class="fas fa-times"></i>';
            delBtn.style.cssText = 'position: absolute; top: 6px; right: 6px; width: 26px; height: 26px; border-radius: 50%; background: rgba(239, 68, 68, 0.9); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0,0,0,0.3);';
            delBtn.onclick = (e) => {
                e.stopPropagation();
                removeFileAt(idx);
            };
            card.appendChild(delBtn);

            previewGrid.appendChild(card);
        });

        // Sync buffer to input element
        fileInput.files = fileBuffer.files;
    }

    function addFiles(newFiles) {
        for (let i = 0; i < newFiles.length; i++) {
            if (fileBuffer.files.length >= 8) {
                alert('You can upload a maximum of 8 photos.');
                break;
            }
            const file = newFiles[i];
            if (file.type.startsWith('image/')) {
                fileBuffer.items.add(file);
            }
        }
        renderPreviews();
    }

    function removeFileAt(index) {
        const newDt = new DataTransfer();
        Array.from(fileBuffer.files).forEach((f, i) => {
            if (i !== index) newDt.items.add(f);
        });
        fileBuffer = newDt;
        renderPreviews();
    }

    fileInput.addEventListener('change', (e) => {
        addFiles(e.target.files);
    });

    // Drag and Drop
    ['dragenter', 'dragover'].forEach(name => {
        dropZone.addEventListener(name, (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--light-green)';
            dropZone.style.background = 'rgba(13, 148, 136, 0.08)';
        });
    });

    ['dragleave', 'drop'].forEach(name => {
        dropZone.addEventListener(name, (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'rgba(13, 148, 136, 0.4)';
            dropZone.style.background = 'rgba(13, 148, 136, 0.02)';
        });
    });

    dropZone.addEventListener('drop', (e) => {
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            addFiles(e.dataTransfer.files);
        }
    });
</script>
@endsection

@endsection
